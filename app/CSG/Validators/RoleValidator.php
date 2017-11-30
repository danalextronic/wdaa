<?php namespace CSG\Validators;

class RoleValidator extends Validator {
	public static $rules = [
		'roles' => [
			'name' => 'required|unique:roles',
			'level' => 'required|numeric'
		]
	];
}
