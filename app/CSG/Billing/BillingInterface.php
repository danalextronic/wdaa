<?php namespace CSG\Billing;

interface BillingInterface {

	/**
	 * charge
	 * 
	 * Charge the user based on the provided data
	 * 
	 * @access public
	 * @param  array $data
	 */
	public function charge(array $data);

	/**
	 * retrieve
	 * 
	 * Retrieve information about the user's transaction
	 * 
	 * @access public
	 * @param  string $customerId
	 */
	public function retrieve($customerId);
}
