<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

use CSG\Exceptions\UserException;

class User extends BaseModel implements UserInterface, RemindableInterface {

	/**
	 * The types of dashboards available
	 * Available keys:
	 * - roles - an array of role name that have access (admins have access to all)
	 * - name - the name that we want to display to the user
	 * - route - the named route target of the link
	 * 
	 * @access protected
	 * @var array
	 */
	protected $dashboard_types = [
		'admin' => [
			'roles' => ['Admin'],
			'name' => 'Admin Panel',
			'route' => 'admin.dashboard'
		],
		'judge' => [
			'roles' => ['Judge'],
			'name' => 'Judging Dashboard',
			'route' => 'master.dashboard'
		],
		'verification' => [
			'roles' => ['Evaluate','Review'],
			'name' => 'Verification Dashboard',
			'route' => 'verification.dashboard'
		]
	];

	protected static $roleNames = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * boot
	 * 
	 * Overriden method where we can register our model events
	 * 
	 * @access protected
	 * 
	 * @return void
	 * @todo move into events class
	 */
	protected static function boot()
	{
		parent::boot();
		
		static::creating(function($model) {
			$ip_address = Request::getClientIp();

			if(IpAddress::isBanned($ip_address)) {
				throw new UserException("Could not create user account");
			}

			$model->ip_address = $ip_address;

			$model->display_name = $model->attributes['first_name'] . ' ' . $model->attributes['last_name'];
		});

		static::created(function($model) {
			$model->roles()->attach(Role::getDefaultRole());
		});
	}

	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------
	
	
	/**
	 * a user can have many roles
	 */
	public function roles()
	{
		return $this->belongsToMany('Role');
	}

	/**
	 * a user can own many packages
	 */
	public function packages()
	{
		return $this->hasMany('Package');
	}

	/**
	 * a user can be assigned to judge multiple packages
	 */
	public function assignedPackages()
	{
		return $this->belongsToMany('Package');
	}

	/**
	 * A user can own many orders
	 * @return void
	 */
	public function orders()
	{
		return $this->hasMany('Order');
	}

	/**
	 * a user can have many payments
	 * 
	 * @return void
	 */
	public function payments()
	{
		return $this->hasMany('Payment');
	}

	/**
	 * a user can have analytics
	 * 
	 * 
	 * @return void
	 */
	public function analytics()
	{
		return $this->hasMany('Analytics');
	}

	// ==================================================================
	//
	// End Relationships
	//
	// ------------------------------------------------------------------
	
	/**
	 * scopeSearch
	 * 
	 * Query scope that is useful for scoping out queries
	 * 
	 * @access public
	 * @param  object $query
	 * @param  string $term 
	 * @return object
	 */
	public function scopeSearch($query, $term)
	{
		$query->where('username', 'LIKE', "%$term%")
				->orWhere('first_name', 'LIKE', "%$term%")
				->orWhere('last_name', 'LIKE', "%$term%")
				->orWhere('display_name', 'LIKE', "%$term%");
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * isAdmin
	 * 
	 * Method that checks the current instance to see if
	 * the user is an admin
	 * 
	 * @access public
	 * @return boolean 
	 */
	public function isAdmin()
	{
		$roles = $this->roles->filter(function($role) {
			return (strpos(strtolower($role['name']), 'admin') !== FALSE);
		});

		return !($roles->isEmpty());
	}

	/**
	 * belongsToRole
	 * 
	 * Method that checks to see if a given user belongs to the provided role
	 * 
	 * @access public
	 * @param  string $role
	 * @return boolean
	 */
	public function belongsToRole($role, $admin_check = true)
	{
		$roles = $this->getRoleNames();

		if(!is_array($role)) $role = [$role];

		$role = array_map('ucwords', $role);

		$available_roles = array_intersect($role, $roles);

		// if we want to check for admin, run this role
		// otherwise, we will default to false so our logic below
		// isn't determined by this value
		$admin_check = ($admin_check) ? ($this->isAdmin()) : false;

		// if the role is here, they belong in that role
		if(!empty($available_roles) || $admin_check) {
			return true;
		}

		return false;
	}

	/**
	 * getRoleNames
	 * 
	 * Method that checks to see if the role names have already been fetched
	 * If so, load from our makeshift cache
	 * 
	 * @access public
	 * @return array
	 */
	public function getRoleNames()
	{
		if(!empty(static::$roleNames)) {
			return static::$roleNames;
		}

		return static::$roleNames = array_pluck($this->roles->toArray(), 'name');	
	}

	/**
	 * getIncompleteItems
	 * 
	 * Checks to see if the current user has any incomplete items
	 * in the cart
	 * 
	 * @access public
	 * @return number
	 */
	public function getIncompleteItems()
	{
		return Order::whereUserId($this->id)->incomplete()->count();
	}

	/**
	 * loadPayments
	 * 
	 * Method that loads payments from the database
	 * 
	 * @access public
	 * @param  string $order - either 'asc' or 'desc'
	 * @return Collection
	 */
	public function loadPayments($order = 'desc') 
	{
		return $this->load(['payments' => function($query) use($order) {
			$query->orderBy('date', $order);
		}])->payments;
	}

	/**
	 * Method that gets the learner scorecards from this user
	 * 
	 * @access public
	 * @return Collection
	 */
	public function getLearnerScorecards()
	{
		return Order::with('Package', 'Scorecard', 'Verifications')->owner($this->id)->complete()->orderBy('date_completed', 'desc')->get();
	}

	/**
	 * Builds the available dashboards for the currently logged in user
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @return void
	 */
	public function buildDashboardList()
	{
		$available_dashboards = [];

		foreach($this->dashboard_types as $key => $dash) {
			if($this->belongsToRole($dash['roles'])) {
				$available_dashboards[$key] = array_except($dash, ['roles']);
			}
		}

		return $available_dashboards;
	}

	// ==================================================================
	//
	// Model Accessors/Mutators
	//
	// ------------------------------------------------------------------
	
	/**
	 * setPasswordAttribute
	 * 
	 * Mutator that will always make sure that we hash our password
	 * whenever we attempt to set it
	 * 
	 * @access public
	 * 
	 * @param mixed $value
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------

	/**
	 * manageUser
	 * 
	 * Method that manages (creates or updates) a user
	 * 
	 * @access public
	 * @author Eric Paulsen
	 * @param  array $input
	 * @param  User  $user 
	 * @return User
	 */
	public static function manageUser($input, User $user = null)
	{
		if(is_null($user)) {
			$user = new static;
		}

		// try to sync the roles if we have them
		if(!empty($input['roles'])) {
			$user->roles()->sync($input['roles']);
		}

		if(!empty($input['first_name']) && !empty($input['last_name'])) {
			$user->first_name = $input['first_name'];
			$user->last_name = $input['last_name'];
		}

		if(!empty($input['username'])) {
			$user->username = $input['username'];
		}

		if(!empty($input['password'])) {
			$user->password = $input['password'];
		}

		if(!empty($input['email'])) {
			$user->email = $input['email'];
		}
		
		$user->address = $input['address'];

		if(!empty($input['address2'])) {
			$user->address2 = $input['address2'];
		}

		$user->city = $input['city'];
		$user->state = $input['state'];
		$user->zipcode = $input['zipcode'];
		$user->phone = $input['phone'];
		$user->country = $input['country'];

		$user->save();

		return $user;
	}

	/**
	 * getUser
	 * 
	 * Method that gets the user by field name and value
	 * If the user object is currently logged in, we will grab
	 * from the session in order to save a query
	 * 
	 * @access public
	 * @param  mixed $value
	 * @param  string $field
	 * @return User object
	 * @static
	 */
	public static function getUser($value, $field = 'username') 
	{
		if(Auth::check() && (isset(Auth::user()->$field) && Auth::user()->$field == $value)) {
			return Auth::user();
		}

		return static::where($field, $value)->first();
	}

	/**
	 * byRole
	 * 
	 * Fetches users by their role
	 * 
	 * @access public
	 * @param  string $name
	 * @return Collection
	 */
	public static function byRole($name)
	{
		return static::whereHas('roles', function($query) use($name) {
			if(is_array($name)) {
				$query->whereIn('name', $name);
			}
			else {
				$query->where('name', '=', $name);
			}
		})->get();
	}

	/**
	 * addUserTo
	 * 
	 * Method that assigns a user to a specified model
	 * 
	 * @access public
	 * @param Eloquent $model
	 */
	public static function addUserTo($model)
	{
		if(Auth::check() && $model->hasColumn('user_id') && empty($model->user_id)) {
			$model->user_id = Auth::user()->id;
		}
	}

	/**
	 * recentSignups
	 * 
	 * Gets the standard users who have signed up recently
	 * 
	 * @access public
	 * @param  integer $limit
	 * @return Collection
	 * @static
	 */
	public static function recentSignups($limit = 10)
	{
		return static::join('role_user', 'users.id', '=', 'role_user.user_id')
			->join('roles', 'role_user.role_id', '=', 'roles.id')
			->where('roles.name', Role::$defaultRole)
			->recent('created_at')
			->take($limit)
			->get(['users.id', 'users.username', 'users.display_name', 'users.email', 'users.created_at']);
	}
}
