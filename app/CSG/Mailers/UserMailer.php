<?php namespace CSG\Mailers;

class UserMailer extends BaseMailer {

	/**
	 * welcome
	 * 
	 * Sends the welcome message to the user
	 * 
	 * @access public
	 * @param  array  $data
	 * @return object
	 */
	public function welcome(array $data = array())
	{
		$this->subject = 'Thank your for signing up!';
		$this->view = 'emails.users.welcome';
		$this->data = $data;

		return $this;
	}
}
