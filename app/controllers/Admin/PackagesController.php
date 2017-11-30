<?php namespace Admin;

use CSG\Validators\PackageValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Input, Package, Redirect, ScorecardTemplate, User, View;

class PackagesController extends BaseController {

	protected $validation;

	public function __construct(PackageValidator $validation)
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
		$packages = Package::with('owner', 'templates')->get();

        $this->setupAdminLayout('All Packages')->content = View::make('admin.packages.index', compact('packages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = $this->getFormData();

        $this->setupAdminLayout('Create Package')->content = View::make('admin.packages.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		if(!$this->validation->validate($input, 'packages')) {
			return Redirect::back()->withInput()->withErrors($this->validation->getErrors());
		}

		try {
			$package = Package::manage($input);
		}
		catch(Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}

		return Redirect::route('admin.packages.edit', $package->id)->with('message', 'Package Created!');
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
			$package = Package::findOrFail($id);

        	$this->setupAdminLayout('View Package - ' . $package->name)->content = View::make('admin.packages.show', compact('package'));
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.packages.index")->with('error', 'Package not found!');
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
			$package = Package::findOrFail($id);

			$data = $this->getFormData();

			$data['package'] = $package;
			$data['current_templates'] = $package->templates->modelKeys();

	        $this->setupAdminLayout('Edit Package - ' . $package->name)->content = View::make('admin.packages.edit', $data);
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.packages.index")->with('error', 'Package not found!');
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
			$package = Package::findOrFail($id);
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.packages.index")->with('error', 'Package not found!');
		}

		$input = Input::all();

		if(!$this->validation->validate($input, 'packages')) {
			return Redirect::back()->withInput()->withErrors($this->validation->getErrors());
		}

		try {
			$package = Package::manage($input, $package);
		}
		catch(ModelException $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}

		return Redirect::route('admin.packages.edit', $package->id)->with('message', 'Package Saved!');
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
			$package = Package::findOrFail($id);

			$package->delete();

			return Redirect::route('admin.roles.index')->with('message', 'Role Deleted!');
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route('admin.packages.index')->with('error', 'Package Not Found!');
		}
	}

	/**
	 * getFormData
	 * 
	 * Method that grabs data that is needed for our package form
	 * 
	 * @access protected
	 * @return array
	 */
	protected function getFormData()
	{
		$templates = ScorecardTemplate::all()->lists('name');
		$judges = User::byRole('Judge')->lists('display_name');

		return [
			'templates' => $templates,
			'judges' => $judges
		];
	}

}
