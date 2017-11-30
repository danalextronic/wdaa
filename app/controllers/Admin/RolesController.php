<?php namespace Admin;

use CSG\Validators\RoleValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Input;
use Redirect;
use Role;
use View;

class RolesController extends BaseController {

	protected $validation;

	public function __construct(RoleValidator $validation)
	{
		$this->validation = $validation;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::with('users')->get();

        $this->setupAdminLayout('All User Roles')->content = View::make('admin.roles.index', compact('roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $this->setupAdminLayout('Create User Role')->content = View::make('admin.roles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		if(!$this->validation->validate($input, 'roles')) {
			return Redirect::back()->withInput()->withErrors($this->validation->getErrors());
		}

		$role = Role::create($input);

		return Redirect::route('admin.roles.edit', $role->id)->with('message', 'Role Created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$role = Role::findOrFail($id);

	        $this->setupAdminLayout('View Role - ' . $role->name)->content = View::make('admin.roles.show', compact('role'));
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.roles.index")->with('error', 'Role Not Found!');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$role = Role::findOrFail($id);

        	$this->setupAdminLayout('Edit Role - ' . $role->name)->content = View::make('admin.roles.edit', compact('role'));
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.roles.index")->with('error', 'Role Not Found!');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try {
			$role = Role::findOrFail($id);

			$input = Input::all();

			$rules = ['name' => "required|unique:roles,name,{$id}"];

			if(!$this->validation->validate($input, 'roles', $rules)) {
				return Redirect::back()->withInput()->withErrors($this->validation->getErrors());
			}

			$role->name = $input['name'];
			$role->level = $input['level'];

			$role->save();

			return Redirect::route('admin.roles.edit', $role->id)->with('message', 'Role Saved!');
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.roles.index")->with('error', 'Role Not Found!');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$role = Role::findOrFail($id);

			$role->delete();

			return Redirect::route('admin.roles.index')->with('message', 'Role Deleted!');
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.roles.index")->with('error', 'Role Not Found!');
		}
	}

}
