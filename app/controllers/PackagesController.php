<?php

use CSG\Exceptions\UserException;
use CSG\Cart\ItemInterface as Cart;

class PackagesController extends BaseController {

	protected $cart;

	public function __construct(Cart $cart)
	{
		parent::__construct();

		$this->cart = $cart;
	}

	/**
	 * enroll
	 * 
	 * Method that adds the user role to the cart for checkout
	 * 
	 * @access public
	 * @param  string $slug
	 * @return void
	 */
	public function enroll($slug)
	{
		$package = Package::whereSlug($slug)->first();

		if(empty($package)) {
			throw new UserException("Could not enroll!");
		}

		// add the item to the cart
		try {
			$this->cart->add($package, Auth::user());
		}
		catch(Exception $e) {
			throw new UserException("Could not enroll!");
		}

		// redirect to the cart page
		return Redirect::route('cart')->with('message', 'Please proceed with checkout!');
	}
}
