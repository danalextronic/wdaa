<?php namespace CSG\Validators;

class UserValidator extends Validator {

	public static $rules = [
		'login' => [
			'username' => 'required',
			'password' => 'required'
		],
		'signup' => [
			'first_name' => 'required',
			'last_name' => 'required',
			'username' => 'required|unique:users|alpha_dash|min:4',
			'email' => 'required|email|unique:users|confirmed',
			'password' => 'required|min:6|confirmed',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zipcode' => 'required',
			'phone' => 'required',
			'country' => 'required',
			'accept_tos' => 'required'
		],
		'settings' => [
			'first_name' => 'required',
			'last_name' => 'required',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zipcode' => 'required',
			'phone' => 'required',
			'country' => 'required',
			'password' => 'min:6|confirmed'
		]
	];
}
