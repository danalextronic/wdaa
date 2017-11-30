<?php namespace CSG\Helpers;

use \Illuminate\Support\Str as ParentStr;

class Str extends ParentStr {

	/**
	 * properize
	 * 
	 * Method that takes a string and adds an apostrophe afterward
	 * 
	 * Example: Eric Paulsen ==> Eric Paulsen's
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public static function properize($input)
	{
		return $input.'\''.($input[static::length($input) - 1] != 's' ? 's' : '');
	}
}
