<?php namespace Admin;

use CSG\Billing\BillingInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Payment;
use View;

class PaymentsController extends BaseController {

	protected $billing;

	public function __construct(BillingInterface $billing)
	{
		$this->billing = $billing;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = Payment::with('orders', 'owner')->recent('date')->get();

        $this->setupAdminLayout('Recent Payments')->content = View::make('admin.payments.index', compact('payments'));
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
        	$payment = Payment::findOrFail($id);
        }
        catch(ModelNotFoundException $e) {
        	return Redirect::route('admin.payments.index')->with('error', 'Payment Record not found!');
        }

        $payment->load('orders');

        // retrieve billing information from our billing provider
        $billing = $this->billing->retrieve($payment->transaction_id);

        $this->setupAdminLayout('View Payment - ' . $payment->transaction_id)->content = View::make('admin.payments.show', compact('payment', 'billing'));
	}
}
