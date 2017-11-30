@section('content')
	<div class="pull-right">
		{{link_to_route('admin.payments.index', 'Return To Listing', [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>
			Payment
			<small>
				&raquo; {{$payment->transaction_id}}
			</small>
		</h1>
	</div>

	@include('partials/_payment')

	<!-- ITEMS IN PAYMENT -->
	@if(!$payment->orders->isEmpty())
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					Orders in This payment
				</h3>
			</div>

			<div class="panel-body">
				@include('admin/orders/partials/_table', ['orders' => $payment->orders, 'hide_details' => true])
			</div>
		</div>
	@endif
@stop
