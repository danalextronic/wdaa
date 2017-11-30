<?php 
use CSG\Exceptions\AjaxException;
use CSG\Scorecards\Verification;
use CSG\Validators\VerificationValidator;
use CSG\Mailers\VerificationMailer;
use CSG\Validators\StatusValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Order;
use Request;
use User;
use View;


class StatusController extends BaseController {


	public function __construct(StatusValidator $validation)
	{
		parent::__construct();
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
		
		return jsonResponse(true, "inprogress", [
			'students' => $students, 'cur_status' => 'inprogress', 'completed' => '0'
		]);
		
	} 
	
	public function pending(){
		$students = Order::getCurrentStatus("Pending");

		return jsonResponse(true, "pending", [
			'students' => $students, 'cur_status' => 'pending', 'completed' => '0'
		]);
			
	}
	
	public function satisfactory(){
		$students = Order::getCurrentStatus("Satisfactory");

		return jsonResponse(true, "pending", [
			'students' => $students, 'cur_status' => 'satisfactory', 'completed' => '0'
		]);
				
	}
	
	public function unsatisfactory(){
		$students = Order::getCurrentStatus("Unsatisfactory");

		return jsonResponse(true, "pending", [
			'students' => $students, 'cur_status' => 'satisfactory', 'completed' => '0'
		]);
	}
	
	public function completed(){
		$students = Order::getCurrentStatus("completed");

		return jsonResponse(true, "pending", [
			'students' => $students, 'cur_status' => 'completed', 'completed' => '1'
		]);

	}
	
	public function completesave(){
			
	}
}
