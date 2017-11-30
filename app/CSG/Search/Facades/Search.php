<?php namespace CSG\Search\Facades;

use Illuminate\Support\Facades\Facade;

class Search extends Facade {

	public static function getFacadeAccessor()
	{
		return 'search';
	}
}
