<?php namespace CSG\Validators;

use Validator as V;

class TemplateValidator extends Validator {

	public static $rules = [
		'form' => [
			'name' => 'required',
			'videos' => 'required'
		],
		'rows' => [
			'text' => 'required_without:markers',
			'markers' => 'markers',
			'ideas' => 'required',
			'coef' => 'required|numeric|min:1|max:5'
		]
	];

	public function __construct()
	{
		parent::__construct();

		V::extend('markers', get_class($this). '@markers');
	}

	/**
	 * markers
	 * 
	 * Method for validating template markers
	 * 
	 * @access public
	 * @param  string $field
	 * @param  mixed  $markers
	 * @param  array  $params 
	 * @return boolean        
	 */
	public function markers($field, $markers, $params)
	{
		if(is_array($markers))
		{
			// pull off the last marker and check and see if the data is valid
			$last_marker = array_pop($markers);

			return (!empty($last_marker['name']) && !empty($last_marker['text']));
		}

		return (!empty($markers));
	}
}
