<?php namespace CSG\Cart;

interface ItemInterface {

	/**
	 * getBy
	 * 
	 * Gets a list of items
	 * 
	 * @access public
	 * @param  array $args
	 * @return array
	 */
	public function get(array $args = array());

	/**
	 * add
	 * 
	 * Method that adds an item to a shopping cart
	 * 
	 * @access public
	 * @param  object $package
	 * @param  object $user
	 */
	public function add($package, $user);

	/**
	 * remove
	 * 
	 * Method that removes an item from the shopping cart
	 * 
	 * @access public
	 * @param  integer $id
	 * @return void
	 */
	public function remove($id);

	/**
	 * addCoupon
	 * 
	 * Method that applies a coupon code
	 * 
	 * @access public
	 * @param  string $code
	 * @return array
	 */
	public function addCoupon($code);

	/**
	 * removeCoupon
	 * 
	 * Remove a coupon code from the assigned order
	 * 
	 * @access public
	 * @param  integer $id
	 * @return void
	 */
	public function removeCoupon($id);

	/**
	 * checkout
	 * 
	 * Processes the checkout for items in the cart
	 * 
	 * @access public
	 * @param  array  $data
	 * @return void
	 */
	public function checkout(array $data);
}
