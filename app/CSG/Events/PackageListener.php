<?php namespace CSG\Events;

use CSG\Scorecards\Manager;

class PackageListener extends Listener {

	/**
	 * onCreate
	 * 
	 * Listener that fires when a package is created in the admin
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @param  array $data
	 * @param  integer $package_id
	 * @return boolean
	 */
	public function onCreate(array $data, $package_id)
	{
		$manager = new Manager($package_id, $data['templates']);

		return $manager->create();
	}

	/**
	 * onUpdate
	 * 
	 * Listener that fires when a package is updated in the admin
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @param  array $data
	 * @param  integer $package_id
	 * @return boolean
	 */
	public function onUpdate(array $data, $package_id)
	{
		$manager = new Manager($package_id, $data['templates']);

		return $manager->update();
	}
}
