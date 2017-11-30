<?php namespace CSG\Billing;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('CSG\\Billing\\BillingInterface', 'CSG\\Billing\\StripeBilling');
	}
}
