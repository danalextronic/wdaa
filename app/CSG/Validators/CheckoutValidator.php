<?php namespace CSG\Validators;

class CheckoutValidator extends Validator {

	public static $rules = [
		'checkout' => [
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zipcode' => 'required',
			'phone' => 'required'
		]
	];
}
