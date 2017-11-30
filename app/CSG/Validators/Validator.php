<?php namespace CSG\Validators;

use Validator as V;

abstract class Validator {

	/**
	 * $errors
	 * 
	 * Holds error messages that are returned
	 * 
	 * @access protected
	 * @var array
	 */
	protected $errors;

	/**
	 * __construct
	 * 
	 * Define custom validation rules here
	 */
	public function __construct()
	{
		V::extend('phone', get_class($this). '@phone');
	}

	/**
	 * validate
	 * 
	 * Main method that performs our validation
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @param  array  $data
	 * @param  string $key
	 * @param  array  $rules
	 * @return boolean
	 */
	public function validate(array $data, $key = null, array $additional_rules = array())
	{
		if(!isset(static::$rules[$key])) {
			$this->errors = "Rule(s) for " . ucfirst($key) . " are not defined!";

			return false;
		}

		if(!empty($additional_rules)) {
			$rules = array_merge(static::$rules[$key], $additional_rules);
		}
		else {
			$rules = static::$rules[$key];
		}
		
		$validator = V::make($data, $rules);

		if($validator->fails()) {
			$this->errors = $validator->messages();

			return false;
		}

		return true;
	}

	/**
	 * getErrors
	 * 
	 * Accessor method that grabs the error messages from the class
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * phone
	 * 
	 * Method for validating a phone number
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @param  string $attribute
	 * @param  mixed $value    
	 * @param  array $params   
	 * @return boolean
	 */
	public function phone($attribute, $value, $params)
	{
		return preg_match('/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/', $value);
	}
}
