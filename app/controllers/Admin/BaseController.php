<?php namespace Admin;

use Order;
use Request;
use User;
use View;

class BaseController extends \BaseController {

	protected $layout = 'layouts.admin';
	protected $in_modal = false;

	public function __construct()
	{
		parent::__construct();

		if(Request::get('modal')) {
			$this->layout = 'layouts.blank';
			$this->in_modal = true;
		}
	}

	public function dashboard()
	{
		$users = User::recentSignups();
		$students = Order::getCurrentStudents();

		$this->setupAdminLayout("Dashboard")->content = View::make('admin.dashboard.index', [
			'users' => $users,
			'students' => $students
		]);
	}

	/**
	 * setupAdminLayout
	 * 
	 * @access protected
	 * @return \Illuminate\View
	 */
	protected function setupAdminLayout($title)
	{
		return $this->layout->with('title', $title . ' - Admin Panel - ')
			->with('current_page', Request::segment(2));
	}
}
