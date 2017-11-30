<?php namespace CSG\Cart;

use CSG\Validators\CheckoutValidator;
use Illuminate\Support\ServiceProvider;
use Auth;

class ItemServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('CSG\\Cart\\ItemInterface', function($app) 
		{
			if(Auth::check())
			{
				return new DbItemRepository(Auth::user(), new CheckoutValidator);
			}
		});
	}
}
