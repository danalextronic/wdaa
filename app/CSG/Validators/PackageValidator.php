<?php namespace CSG\Validators;

class PackageValidator extends Validator {

	public static $rules = [
		'packages' => [
			'name' => 'required',
			'cost' => 'required|numeric',
			'templates' => 'required'
		]
	];
}
