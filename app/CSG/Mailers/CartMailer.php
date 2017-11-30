<?php namespace CSG\Mailers;

class CartMailer extends BaseMailer {

	public function receipt(array $data = array())
	{
		$this->subject = 'Your order has been completed.';
		$this->view = 'emails.cart.checkout';
		$this->data = $data;
		
		return $this;
	}
}
