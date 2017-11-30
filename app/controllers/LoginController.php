<?php

use CSG\Validators\UserValidator;
use CSG\Exceptions\UserException;
use CSG\Exceptions\AjaxException;
use CSG\Helpers\States;
use CSG\Mailers\UserMailer;

class LoginController extends BaseController {
		
	/**
	 * $validation
	 * 
	 * Instance that holds the validation result
	 * 
	 * @access protected
	 * @var \CSG\Validators\UserValidator
	 */
	protected $validation;

	protected $mailer;

	public function __construct(UserValidator $validation, UserMailer $mailer)
	{
		$this->validation = $validation;
		$this->mailer = $mailer;
	}

	/**
	 * login
	 * 
	 * displays a form for site login
	 * 
	 * @access public
	 * @return string
	 */
	public function login()
	{
		return View::make('users.login_form')->with('modal', Input::get('modal'));
	}

	/**
	 * displays a form for user signup
	 * 
	 * @access public
	 * @return string
	 */
	public function signup()
	{
		$this->getStatesUrl();
		
		return View::make('users.register_form');
	}

	/**
	 * logout
	 * 
	 * Method that logs out our users
	 * 
	 * @access public
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout()
	{
		Auth::logout();

		return Redirect::intended("/");
	}

	/**
	 * processLogin
	 * 
	 * Handles the post request for our login form
	 * 
	 * @access public
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processLogin()
	{
		$input = Input::all();

		if(!$this->validation->validate($input, 'login')) {
			return Redirect::route("login")->withErrors($this->validation->getErrors())->withInput($input);
		}

		$username_field = strpos($input['username'], '@') === FALSE ? 'username' : 'email';

		if(Auth::attempt([$username_field => $input['username'], 'password' => $input['password']])) {
			return Redirect::intended("/");
		}

		return Redirect::route("login")->with('error', 'Invalid Login Credentials');
	}

	/**
	 * processSignup
	 * 
	 * Handles the post request for our signup form
	 * 
	 * @access public
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processSignup()
	{
		$input = Input::all();

		if(!$this->validation->validate($input, 'signup')) {
			return Redirect::route('signup')->withErrors($this->validation->getErrors())->withInput($input);
		}

		try {
			$user = User::manageUser($input);
		}
		catch(UserException $e) {
			return Redirect::route('signup')->with('error', $e->getMessage())->withInput($input);
		}

		// log the user in automatically
		Auth::login($user);
		
		// and send a welcome email
		 $this->mailer->welcome()->sendTo($user);
		
	
		return Redirect::intended("/")->with('message', 'Your account was successfully created!');
	}

	/**
	 * getStates
	 * 
	 * AJAX method that gets the list of states
	 * for a given country
	 * 
	 * @access public
	 * @param string $country
	 * @return json
	 */
	public function getStates()
	{
		$country = Input::get('country');

		$states = States::fetchBy($country);

		return jsonResponse(true, "States Found", [
			'states' => $states
		]);
	}
}
