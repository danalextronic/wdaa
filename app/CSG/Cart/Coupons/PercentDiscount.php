<?php namespace CSG\Cart\Coupons;

class PercentDiscount implements CouponDiscountInterface 
{
	public function calculate($orders, $discount)
	{
		$lowest_total = 999999999999;
		$applied_order_id = 0; 

		foreach($orders as $item) {
			// If this item is cheaper than the previous value, update our stored values.
			if($lowest_total > $item->cost) {
				$lowest_total = $item->cost;
				$applied_order_id = $item->id;
			}
		}

		$applied_item = $orders->get($applied_order_id);

		// Calculate our discount
		$discount_value = $applied_item->cost * ($discount/100);
		$final_cost = $lowest_total - $discount_value;

		return [
			$discount_value,
			$final_cost,
			$applied_order_id
		];
	}
}
