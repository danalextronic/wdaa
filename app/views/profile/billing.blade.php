@section('content')
	@if(!$payments->isEmpty())
	<div class="responsive-table">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Payment Date</th>
					<th>Payment Method</th>
					<th>Order Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payments as $payment)
				<tr>
					<td>
						{{link_to_route('profile.single_payment', $payment->date->format("m/d/Y"), [$user->username, $payment->id])}}
					</td>
					<td>
						{{$payment->type == 'discounted-free' ? 'Free (used coupon)' : 'Credit Card'}}
					</td>
					<td>
						${{number_format($payment->total, 2)}}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@else
		<div class="alert alert-danger">
			No Records Found!
		</div>
	@endif
@stop
