<?php namespace CSG\Cart;

use CSG\Cart\Coupons\PercentDiscount;
use CSG\Cart\Coupons\DollarsDiscount;
use CSG\Validators\CheckoutValidator;
use Coupon;
use Exception;
use CouponUse;
use Illuminate\Database\QueryException;
use Order;
use User;
use View;

class DbItemRepository implements ItemInterface {

	protected $user;
	protected $validation;

	/**
	 * __construct
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct(User $user, CheckoutValidator $validation)
	{
		$this->user = $user;
		$this->validation = $validation;
	}

	/**
	 * get
	 * 
	 * Method that gets orders
	 * If any arguments are provided, we will filter by then
	 * 
	 * @access public
	 * @param  array $args 
	 * @return array
	 */
	public function get(array $args = array())
	{
		try {
			$items = Order::with('package')->incomplete()->where('user_id', $this->user->id)->get()->keys('id');
		}
		catch(QueryException $e) {
			return [];
		}

		return $this->sortItems($items);
	}

	/**
	 * add
	 * 
	 * Method that adds an item to the cart
	 * 
	 * @access public
	 * @param  object $package
	 * @param  object $user
	 */
	public function add($package, $user)
	{
		return Order::create([
			'user_id' => $user->id,
			'cost' => $package->cost,
			'package_id' => $package->id
		]);
	}

	/**
	 * remove
	 * 
	 * Method that removes an item from the cart
	 * 
	 * @access public
	 * @param  integer $id
	 * @return void
	 */
	public function remove($id)
	{
		$order = Order::find($id);

		if(is_null($order)) throw new Exception("Order not found!");

		$order->delete();

		return $this->get();
	}

	/**
	 * addCoupon
	 * 
	 * Method that applies a coupon to an item in our order
	 * 
	 * @access public
	 * @param  string $code
	 * @return void
	 */
	public function addCoupon($code)
	{
		// get coupon from the database
		$coupon = Coupon::whereCode($code)->first();

		if(is_null($coupon)) throw new Exception("Invalid Coupon!");

		// validate coupon
		$items = $this->get();

		$errors = $coupon->validate($items['order']->items);

		if(count($errors) > 0) {
			throw new Exception(implode("\n", $errors));
		}

		// apply coupon discount to an item and
		// do the appropriate assignment in the database
		$result = $this->applyCoupon($coupon, $items);

		if(array_key_exists('errors', $result)) {
			throw new Exception("Errors: " . $result['errors']);
		}

		CouponUse::add($result, $coupon->id);

		$orders = $this->get();

		return [
			'discounted_cost' => number_format($result['final_cost'], 2),
			'total' => number_format($result['total'], 2),
			'total_discount' => number_format($result['amount_off'], 2),
			'coupon_name' => $coupon->name,
			'applied_order_id' => $result['applied_order_id'],
			'coupon_discount' => $coupon->discount,
			'coupon_discount_type' => $coupon->discount_type,
			'orders' => $orders,
			'coupon_html' => $this->getCouponView($orders)
		];
	}

	/**
	 * removeCoupon
	 * 
	 * Method that removes a coupon from an assigned ID
	 * 
	 * @access public
	 * @param  integer $id
	 * @return array
	 */
	public function removeCoupon($id)
	{
		$order = $this->get()['order'];
		$coupons = $order->coupons;

		$coupon_ids = [];
		$credit_amount = 0;

		foreach($coupons as $c)
		{
			$coupon_ids[] = $c->coupon->id;
			$credit_amount += $c->discount;

			// remove the final cost..otherwise, if a coupon is applied to this order again,
			// the price will be (incorrectly) based off of the final cost
			Order::updateFinalCost($c->order_id, null);
		}

		// delete coupon use
		CouponUse::byCoupons($coupon_ids)->delete();

		// and return
		$total = number_format($order->total + $credit_amount, 2);
		$orders = $this->get();

		return [
			'total' => $total,
			'orders' => $orders,
			'coupon_html' => $this->getCouponView($orders)
		];
	}

	/**
	 * checkout
	 * 
	 * Method that hanldes user checkout
	 * We will determine if it is for free or paid
	 * 
	 * @access public
	 * @param  array  $data
	 * @return array
	 */
	public function checkout(array $data)
	{
		$addressData = array_only($data, ['address', 'address2', 'city', 'country', 'state', 'zipcode', 'phone']);

		if(!$this->validation->validate($addressData, 'checkout')) 
		{
			throw new Exception("Please provide all required address information");
		}

		// update the user address data in the database
		User::manageUser($addressData, $this->user);

		$order = $this->get()['order'];

		if(empty($order->items)) 
		{
			throw new Exception("There are no items in your cart!");
		}

		$return = [
			'items' => $order->items,
			'coupons' => $order->coupons,
			'payment' => []
		];

		// if we have a balance, check to make sure that we have valid card information
		// for our stripe implementation, this is passed via a token that is created using
		// their javascript library
		// for other libraries (Braintree, Paypal, Square, etc.), this process might be different
		if($order->total > 0)
		{
			$total = $order->total * 100;

			if(!isset($data['paymentToken'])) {
				throw new Exception("Cannot complete payment!");
			}

			$return['payment'] = [
				"amount" => $total,
				"currency" => "usd",
				"card" => $data['paymentToken'],
				"description" => $this->user->display_name,
				'free' => false
			];
		}
		else
		{
			$return['payment']['free'] = true;
		}

		return $return;
	}

	/**
	 * sortItems
	 * 
	 * @access protected
	 * @param  Collection $items
	 * @return void
	 */
	protected function sortItems($items)
	{
		$subtotal = 0;
		$total = 0;

		$item_list = [];
		// needed so we can query for coupons
		$item_ids = [];

		$coupons = [];
		$discounted_items = [];

		// use this method so items is still a collection
		$items->each(function($item) use(&$item_ids, &$total, &$subtotal) {
			$item_ids[] = $item->id;

			// calculate the total
			$subtotal += $item->cost;
			$total += (!empty($item->final_cost)) ? $item->final_cost : $item->cost;
		});

		if(!empty($item_ids)) {
			$coupons = $this->getCoupons($item_ids);
			$discounted_items = $this->getDiscountedItems($coupons);
		}

		return [
			'order' => (object) [
				'items' => $items,
				'total' => $total,
				'subtotal' => $subtotal,
				'coupons' => $coupons
			],
			'discounted_items' => $discounted_items
		];
	}

	/**
	 * getCoupons
	 * 
	 * Method for getting coupons
	 * 
	 * @access public
	 * @param  array $item_ids
	 * @return Collection
	 */
	protected function getCoupons(array $item_ids)
	{
		return CouponUse::with('coupon')->byOrder($item_ids)->get();
	}

	/**
	 * getDiscountedItems
	 * 
	 * Method that helps to calculate which items are discounted
	 * in our order
	 * 
	 * @access protected
	 * @param  Collection $coupons
	 * @return array
	 */
	protected function getDiscountedItems($coupons)
	{
		$discounted_items = [];
		foreach($coupons as $coupon) {
			$discounted_items[] = $coupon->order_id;
		}

		return $discounted_items;
	}

	/**
	 * applyCoupon
	 * 
	 * Handles the direct application of coupon data
	 * 
	 * @access protected
	 * @param  Coupon $coupon
	 * @param  array $items
	 * @return array
	 */
	protected function applyCoupon(Coupon $coupon, array $items)
	{
		$return = [];
		$discount_type = $coupon->discount_type;

		$order = $items['order'];

		$discount = ($discount_type == 'percent') ? new PercentDiscount : new DollarsDiscount;

		list($discount_value, $final_cost, $applied_order_id) = $discount->calculate($order->items, $coupon->discount);

		if($applied_order_id === 0) {
			$return['errors'] = 'Could not apply coupon to any items in this order!';
		}

		if(!isset($return['errors'])) {
			// calculate our final results
			$total = $order->total - $discount_value;
			$amount_off = abs($total - $order->total);

			$return = [
				'discount_value' => $discount_value,
				'final_cost' => $final_cost,
				'applied_order_id' => $applied_order_id,
				'total' => $total,
				'amount_off' => $amount_off
			];
		}

		return $return;
	}

	/**
	 * getCouponView
	 * 
	 * Method that loads the coupon view
	 * 
	 * @access protected
	 * @param  array $items
	 * @return string
	 */
	protected function getCouponView($items)
	{
		return View::make('checkout.partials.coupons._wrapper', ['order' => $items['order']])->render();
	}
}
