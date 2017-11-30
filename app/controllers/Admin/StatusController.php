<?php namespace Admin;

use CSG\Validators\StatusValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Order;
use Request;
use User;
use View;


class StatusController extends BaseController {

	protected $layout = 'layouts.admin';
	protected $in_modal = false;

	public function __construct(StatusValidator $validation)
	{
		parent::__construct();

		if(Request::get('modal')) {
			$this->layout = 'layouts.blank';
			$this->in_modal = true;
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
	}

	public function inprogress(){
		$students = Order::getCurrentStatus("In Progress");
		
		//$this->setupAdminLayout("Status")->content = View::make('admin.status.index', compact(students) );
		
		$this->setupAdminLayout("Status")->content = View::make('admin.status.index', [
			'students' => $students, 'cur_status' => 'inprogress', 'completed' => '0'
		]);			
	} 
	
	public function pending(){
		$students = Order::getCurrentStatus("Pending");

		//$this->setupAdminLayout("Status")->content = View::make('admin.status.index', compact(students) );
		
		$this->setupAdminLayout("Status")->content = View::make('admin.status.index', [
			'students' => $students, 'cur_status' => 'pending', 'completed' => '0'
		]);			
	}
	
	public function satisfactory(){
		$students = Order::getCurrentStatus("Satisfactory");

		//$this->setupAdminLayout("Status")->content = View::make('admin.status.index', compact(students) );
		
		$this->setupAdminLayout("Status")->content = View::make('admin.status.index', [
			'students' => $students, 'cur_status' => 'satisfactory', 'completed' => '0'
		]);			
	}
	
	public function unsatisfactory(){
		$students = Order::getCurrentStatus("Unsatisfactory");

		//$this->setupAdminLayout("Status")->content = View::make('admin.status.index', compact(students) );
		
		$this->setupAdminLayout("Status")->content = View::make('admin.status.index', [
			'students' => $students, 'cur_status' => 'unsatisfactory', 'completed' => '0'
		]);			
	}
	
	public function completed(){
		$students = Order::getCurrentStatus("completed");
		
		$this->setupAdminLayout("Status")->content = View::make('admin.status.index', [
			'students' => $students, 'cur_status' => 'completed', 'completed' => '1'
		]);
	}
	
	public function completesave(){
			
	}
}
