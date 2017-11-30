<?php namespace CSG\Mailers;

use Auth;
use Mail;

class MailerException extends \Exception {}

abstract class BaseMailer {

	protected $subject;
	protected $view;
	protected $data = [];

	/**
	 * send
	 * 
	 * Method that sends an email to multiple users
	 * 
	 * @access public
	 * @param  Collection $users
	 * @return void
	 */
	public function send($users = null)
	{
		foreach($users as $user) {
			$this->sendTo($user);
		}
	}

	/**
	 * sendTo
	 * 
	 * Handles the sending of email based on
	 * the settings provided in our config files
	 * 
	 * @access public
	 * @return void
	 */
	public function sendTo($user = null)
	{
		if(is_null($user)) {
			$user = (Auth::check()) ? Auth::user() : false;
			if(!$user) {
				throw new MailerException("Could not send email.");
			}
		}

		$this->setGlobalVars($user);

		Mail::send($this->view, $this->data, function($message) use($user) {
			$message->to($user->email, $user->display_name)
				->subject($this->subject);
		});
	}

	/**
	 * setGlobalVars
	 * 
	 * Sets global variables on our data array
	 * 
	 * @access protected
	 * @return void
	 */
	protected function setGlobalVars($user)
	{
		$vars = [
			'subject' => $this->subject,
			'user' => $user
		];

		$this->data = array_merge($vars, $this->data);
	}
}
