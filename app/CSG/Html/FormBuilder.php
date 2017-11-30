<?php namespace CSG\Html;

use Lang;
use \Illuminate\Routing\UrlGenerator;
use \Illuminate\Html\HtmlBuilder;

class FormBuilder extends \Illuminate\Html\FormBuilder {

	/**
	 * extended method for selecting a state
	 * Reads the state names from a language file
	 * 
	 * @access public
	 * @param  string $name
	 * @param  mixed $selected  
	 * @param  array  $attributes
	 * @return string
	 */
	public function selectState($name, $selected = null, array $attributes = array())
	{
		$options = ['' => '--Select State--'] + Lang::get('states');

		return $this->select($name, $options, $selected, $attributes);
	}
}
