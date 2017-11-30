<?php namespace CSG\Cart\Coupons;

class DollarsDiscount implements CouponDiscountInterface 
{
	public function calculate($orders, $discount)
	{
		$highest_total = 0;
		$applied_order_id = 0;

		foreach($orders as $item) {
			// If this item is more expensive than the previous value, update stored value
			if($highest_total < $item->cost) {
				$higest_total = $item->cost;
				$applied_order_id = $item->id;
			}
		}

		// Calculate Discount
		$applied_item = $orders->get($applied_order_id);

		$discount_value = $discount;
		$final_cost = $applied_item->cost - $discount;
		
		if($final_cost < 0) {
			$final_cost = 0;
		}

		return [
			$discount_value,
			$final_cost,
			$applied_order_id
		];
	}
}
