<?php namespace CSG\Events;

use Illuminate\Support\ServiceProvider;
use Event;

class EventServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->registerPackageEvents();
	}

	protected function registerPackageEvents()
	{
		Event::listen('package.create', 'CSG\Events\PackageListener@onCreate');
		Event::listen('package.update', 'CSG\Events\PackageListener@onUpdate');
	}
}
