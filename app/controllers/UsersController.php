<?php

use CSG\Billing\BillingInterface;
use CSG\Validators\UserValidator;
use CSG\Exceptions\UserException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends BaseController {
	
	protected $user;
	protected $validation;
	protected $billing;
	protected $scorecard;

	protected $layout = 'layouts.profile';

	/**
	 * __construct
	 * 
	 * Setup our controller
	 * 
	 * @access public
	 */
	public function __construct(UserValidator $validation, BillingInterface $billing)
	{
		$username = Request::segment(2);

		if($username != 'search') {
			$this->user = User::getUser(Request::segment(2));

			if(empty($this->user)) {
				throw new UserException("User Profile Not Found!");
			}
		}

		$this->validation = $validation;
		$this->billing = $billing;

		$this->beforeFilter('@getScorecard', ['only' => ['learnerScorecard', 'compareScorecards']]);
	}

	/**
	 * search
	 * 
	 * Quick and easy member search
	 * 
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @return void
	 */
	public function search()
	{
		return Search::users(Input::get('term'));
	}

	/**
	 * profile
	 * 
	 * Loads profile display
	 * Checks to see if the user has any active orders
	 * 
	 * @access public
	 * @return Response
	 */
	public function profile()
	{
		$orders = $this->user->getLearnerScorecards();

		// set the proper heading if they have records
		$page_title = (!$orders->isEmpty()) ? Lang::get('site.learner') : '';

		$this->setupProfileView($this->user->display_name)
			->with('page_title', $page_title)
			->content = View::make('profile.index', ['user' => $this->user, 'orders' => $orders]);
	}


	/**
	 * settings
	 * 
	 * Loads settings display
	 * 
	 * @access public
	 * @return Response
	 */
	public function settings()
	{
		$viewData = [];
		
		// build role dropdown list
		if(Auth::user()->isAdmin()) {
			$current_roles = $this->user->roles->modelKeys();
			$role_list = Role::all()->lists('name');

			$viewData = [
				'role_list' => $role_list,
				'current_roles' => $current_roles
			];
		}

		$viewData['user'] = $this->user;

		$this->getStatesUrl($this->user);

		$this->setupProfileView(Str::properize($this->user->display_name) . ' Account Settings')
			->with('page_title', 'Account Settings')
			->content = View::make('profile.settings', $viewData);
	}

	/**
	 * billing
	 * 
	 * Loads billing display
	 * 
	 * @access public
	 * @return Response
	 */
	public function billing()
	{
		$viewData['payments'] = $this->user->loadPayments();
		$viewData['user'] = $this->user;

		$this->setupProfileView(Str::properize($this->user->display_name) . ' Billing History')
			->with('page_title', 'Billing History')
			->content = View::make('profile.billing', $viewData);
	}

	/**
	 * learnerScorecard
	 * 
	 * Displays a learner scorecard
	 * 
	 * @access public
	 * @param  string $username
	 * @param  integer $scorecard_id
	 * @return void
	 */
	public function learnerScorecard($username, $scorecard_id)
	{
		if($this->scorecard->order->completed() && $this->scorecard->order->reviewed()) {
			return Redirect::route('profile', $username);
		}

		if($this->scorecard->template->type == 'R') {
			return $this->viewRankedScorecard($this->scorecard, $this->scorecard->type);
		}

		return $this->viewScorecard($this->scorecard);
	}

	/**
	 * comparisonScorecards
	 * 
	 * Displays a comparison view of a learner scorecard
	 * 
	 * @access public
	 * @param  string $username
	 * @return void
	 */
	public function compareScorecards($username)
	{
		if(!$this->scorecard->order->reviewed()) {
			return Redirect::route('profile', $username);
		}

		return $this->scorecardCompare($this->scorecard);
	}

	/**
	 * singlePayment
	 * 
	 * Loads a single payment for display
	 * 
	 * @access public
	 * @param  string $username
	 * @param  integer $paymentId
	 * @return void
	 */
	public function singlePayment($username, $paymentId)
	{
		try {
			$payment = Payment::findOrFail($paymentId);
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route('profile.billing', $username)->with('error', 'Payment Record not found!');
		}

		$orders = $payment->loadCompletedOrders();

		$coupons = CouponUse::loadByOrders($orders->modelKeys());

		$viewData = [
			'payment' => $payment,
			'orders' => $orders,
			'coupons' => $coupons,
			'billing' => $this->billing->retrieve($payment->transaction_id)
		];

		$title = "Payment #" . (!empty($payment->transaction_id) ? $payment->transaction_id : $payment->id);

		$this->setupProfileView($title)
			->with('page_title', $title)
			->content = View::make('profile.single_payment', $viewData);
	}

	/**
	 * saveSettings
	 * 
	 * Method that saves user settings to the database
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @return Redirect
	 */
	public function saveSettings()
	{
		$input = Input::all();

		// define additional validation rules here
		// we can't define them on our validatior instance 
		// since we need to do some verification
		$rules = $this->addSettingsValidation($input);

		if(!$this->validation->validate($input, 'settings', $rules)) {
			return Redirect::route("profile.settings", $this->user->username)->withErrors($this->validation->getErrors())->withInput();
		}

		try {
			$user = User::manageUser($input, $this->user);
		}
		catch(UserException $e) {
			return Redirect::route('profile.settings', $this->user->username)->with('error', $e->getMessage())->withInput($input);
		}

		return Redirect::route('profile.settings', $this->user->username)->with('message', 'Account Settings Updated!');
	}

	/**
	 * setupProfileView
	 * 
	 * Method that sets up the profile
	 * layout with the default data
	 * 
	 * @access private
	 * @return Illuminate\View
	 */
	private function setupProfileView($title)
	{
		return $this->layout
			->with('title', $title)
			->with('user', $this->user)
			->with('current_page', Request::segment(3));
	}

	/**
	 * addSettingsValidation
	 * 
	 * Private method that adds settings validation
	 * to the page
	 * 
	 * @access private
	 * @author Eric Paulsen
	 * @param  array $input
	 * @return array $rules
	 */
	private function addSettingsValidation($input)
	{
		$rules = [];

 		$rules['email'] = "required|email|unique:users,email,{$this->user->id}";

 		if(isset($input['current_password'])) {
 			$rules['current_password'] = 'required';
 		}

		return $rules;
	}

	/**
	 * getScorecard
	 * 
	 * Called from the scorecard filter
	 * 
	 * @access public
	 * @param  $route
	 * @param  $request
	 * @return Scorecard
	 */
	public function getScorecard($route, $request)
	{
		try {
			$this->scorecard = Scorecard::findOrFail($route->parameter('id'));
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route('profile', $route->parameter('username'))->with('error', 'Scorecard not found!');
		}
	}
}
