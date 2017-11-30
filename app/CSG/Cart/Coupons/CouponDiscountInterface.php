<?php namespace CSG\Cart\Coupons;

interface CouponDiscountInterface {

	/**
	 * calcuate
	 * 
	 * Method that calculates the discount given our coupon type
	 * 
	 * @access public
	 * @param  $orders
	 * @param  integer $discount
	 * @return [type]        
	 */
	public function calculate($orders, $discount);
}
