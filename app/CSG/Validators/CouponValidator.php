<?php namespace CSG\Validators;

class CouponValidator extends Validator {
	public static $rules = [
		'coupons' => [
			'code' => 'required',
			'name' => 'required',
			'expired_at' => 'date',
			'package_id' => 'numeric',
			'user_id' => ["regex:/[\d]+\s\-\s[\w\s-\'_]+/"],
			'discount' => 'required',
			'discount_type' => 'required'
		]
	];
}
