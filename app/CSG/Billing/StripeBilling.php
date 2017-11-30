<?php namespace CSG\Billing;

use Exception;
use Config;
use Stripe;
use Stripe_CardError;
use Stripe_Error;
use Stripe_Charge;


class StripeBilling implements BillingInterface {

	public function __construct()
	{
		Stripe::setApiKey(Config::get('stripe.private_key'));
	}

	/**
	 * charge
	 * 
	 * Apply the appropriate charge for the item provided
	 * @param  array  $data
	 * @return Stripe_Charge
	 * @throws Stripe_CardError
	 * @throws Stripe_Error
	 */
	public function charge(array $data)
	{
		try {
			$charge = Stripe_Charge::create($data);
			return $charge->__toArray();
		}
		catch(Stripe_CardError $e) {
			// invalid card credentials
			throw new Exception($e->getMessage());
		}
		catch(Stripe_Error $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * retrieve
	 * 
	 * Retrieve a record from the datasource
	 * 
	 * @access public
	 * @param  string $customerId
	 * @return Stripe_Charge
	 * @throws Stripe_Error
	 */
	public function retrieve($customerId)
	{
		try {
			return Stripe_Charge::retrieve($customerId);
		}
		catch(Stripe_Error $e) {
			return null;
		}
	}
}
