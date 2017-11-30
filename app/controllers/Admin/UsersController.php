<?php namespace Admin;

use View;
use User;

class UsersController extends BaseController {

	public function index()
	{
		$users = User::with('roles')->get();

		$this->setupAdminLayout('All Users')->content = View::make('admin.users.index', compact('users'));
	}
}
