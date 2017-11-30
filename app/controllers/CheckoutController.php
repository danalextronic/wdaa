<?php

use CSG\Mailers\CartMailer;
use CSG\Billing\BillingInterface as Billing;
use CSG\Cart\ItemInterface as Cart;
use CSG\Exceptions\AjaxException;

class CheckoutController extends BaseController {

	protected $billing;
	protected $cart;
	protected $mailer;

	public function __construct(Billing $billing, Cart $cart, CartMailer $mailer)
	{
		parent::__construct();

		$this->billing = $billing;
		$this->cart = $cart;
		$this->mailer = $mailer;
	}

	/**
	 * cart
	 * 
	 * Gets items for our cart and displays a view for them
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @return void
	 */
	public function cart()
	{
		$data = $this->cart->get();

		$this->getStatesUrl(Auth::user());

		return View::make('checkout.cart', $data);
	}

	/**
	 * checkout
	 * 
	 * POST request that performs the checkout
	 * 
	 * @access public
	 * @return void
	 */
	public function checkout()
	{
		
		$data = Input::except('_token');

		// prepare our data and submit
		try
		{
			$paymentData = $this->cart->checkout($data);

			if(!$paymentData['payment']['free'])
			{
				$billingResult = $this->billing->charge(array_except($paymentData['payment'], ['free']));
				$type = 'stripe';
			}
			else
			{
				$billingResult = [];
				$type = 'discounted-free';
			}
		}
		catch(Exception $e)
		{
			$message = "There was an error processing your payment: " . $e->getMessage();
			return Redirect::back()->withInput()->with('error', $message);
		}
		// record payment
		$sc_data = Payment::record($billingResult, $type, $paymentData['items']);print_r($sc_data);exit;
		
		// create learner scorecard records
		Scorecard::createLearner($sc_data, Auth::user());
		
		$role = Role::where('level', 7)->first();print_r($role);exit;
		$users = $role->users;
		/*
		$this->mailer->receipt([
			'items' => $paymentData['items'],
			'coupons' => $paymentData['coupons'],
			'billing' => (isset($billingResult['card'])) ? $billingResult['card'] : false
		])->send($users);		
		*/
		// send the user a checkout receipt
		$this->mailer->receipt([
			'items' => $paymentData['items'],
			'coupons' => $paymentData['coupons'],
			'billing' => (isset($billingResult['card'])) ? $billingResult['card'] : false
		])->sendTo(Auth::user());
		
		// and redirect to user profile
		return Redirect::route('profile.settings', Auth::user()->username)
			->with('message', 'Your order has been completed successfully!');
	}

	/**
	 * removeItem
	 * 
	 * removes an item from the cart
	 * 
	 * @access public
	 * @param int id
	 * @return json
	 */
	public function removeItem()
	{
		try 
		{
			$data = $this->cart->remove(Input::get('id'));

			return jsonResponse(true, "Item Removed", $data);
		}
		catch(Exception $e)
		{
			throw new AjaxException($e->getMessage());
		}
	}

	/**
	 * addCoupon
	 * 
	 * Applies a coupon to an order in the cart
	 * 
	 * @access public
	 * @param string code
	 * @return json
	 */
	public function addCoupon()
	{
		try 
		{
			$result = $this->cart->addCoupon(Input::get('couponCode'));

			return jsonResponse(true, "Coupon Applied", $result);
		}
		catch(Exception $e)
		{
			throw new AjaxException($e->getMessage());
		}
	}

	/**
	 * removeCoupon
	 * 
	 * Removes a coupon from an item in the cart
	 * 
	 * @access public
	 * @param integer couponId
	 * @return json
	 */
	public function removeCoupon()
	{
		try 
		{
			$result = $this->cart->removeCoupon(Input::get('couponId'));

			return jsonResponse(true, "Coupon Removed", $result);
		} 
		catch (Exception $e) 
		{
			throw new AjaxException($e->getMessage());
		}		
	}
	
	public function emailUpdate()
	{
		$role = Role::where('level', 7)->first();
		$users = $role->users;
  		foreach ($users as $key => $user) {
  			$user->email = 'yuri.len.126@gmail.com';
  			$user->save();
  		}
	}
	
	public function emailGet()
	{
		$role = Role::where('level', 7)->first();
		$users = $role->users;
		foreach ($users as $key => $user) {
			echo "ID : ".$user->id." Email : ".$user->email."<br/>";
		}
		exit();
	}
	
	public function emailRollback()
	{
		if (App::environment() == 'development') {
			$userInfo = [38 => 'yuri.denisov.126@gmail.com', 39 => 'yuri.len.126@gmail.com', ];			
		} else {
			$userInfo = [38 => 'stableventures@aol.com'];
		}

		foreach ($userInfo as $key => $item) {
			$user = User::find($key);
			$user->email = $item;
			$user->save();
		}
	}	
}
