<?php namespace CSG\Search\Providers;

use CSG\Search\SearchLibrary;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('search', function($app) {
			return new SearchLibrary();
		});
	}
}
