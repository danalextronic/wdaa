<?php namespace CSG\Validators;

class VerificationValidator extends Validator {

	public static $rules = [
		'verify' => [
			'comment' => 'required',
			'satisfactory' => 'required'
		]
	];

}
