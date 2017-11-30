<?php namespace CSG\Validators;

class StatusValidator extends Validator {
	public static $rules = [
		'status' => [
			'name' => 'required|unique:status',
			'level' => 'required|numeric'
		]
	];
}
