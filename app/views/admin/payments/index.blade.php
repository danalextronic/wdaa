@include('partials/packages/datatables')

@section('content')
	<div class="page-header">
		<h1>Recent Payments</h1>
	</div>

	<div class="responsive-table">
		<table class="table table-bordered table-striped datatable">
			<thead>
				<tr>
					<th>Transaction ID</th>
					<th>User</th>
					<th>Total</th>
					<th>Date</th>
					<th># of items</th>
				</tr>
			</thead>
			<tbody>
				@if($payments->isEmpty())
					<tr class="danger text-center">
						<td colspan="5">No Payments Found</td>
					</tr>
				@else
					@foreach($payments as $payment)
						<tr>
							<td>
								{{link_to_route('admin.payments.show', $payment->transaction_id, $payment->id)}}
							</td>
							<td>
								{{link_to_route('profile', $payment->owner->display_name, $payment->owner->username)}}
							</td>

							<td>
								${{$payment->total}}
							</td>

							<td>
								{{$payment->date->diffForHumans()}}
							</td>

							<td>
								{{$payment->orders->count()}}
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
@stop
