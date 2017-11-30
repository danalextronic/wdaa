@section('content')
	<div class="pull-right">
		{{link_to_route('admin.orders.index', 'Return to Orders Listing', [], ['class' => 'btn btn-info'])}}
	</div>
	<div class="page-header">
		<h1>
			Order For {{$order->owner->display_name}}
		</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Order Details
			</h3>
		</div>

		<div class="panel-body">
			<ul>
				<li>
					<strong>Package:</strong> {{link_to_route('admin.packages.edit', $order->package->name, $order->package->id)}}
				</li>

				<li>
					<strong>Cost:</strong> ${{$order->getCost()}}
				</li>

				@if($order->final_cost && $order->final_cost != $order->cost)
					<li>
						<strong>Coupon:</strong> {{$order->couponString()}}
					</li>
				@endif

				@if($order->payment_id)
					<li>
						<strong>Payment:</strong> 
						{{link_to_route('admin.payments.show', 'View Payment', $order->payment_id)}}
					</li>
				@endif
			</ul>
		</div>
	</div>
@stop
