<table class="table {{(!isset($hide_details)) ? 'table-bordered' : ''}} table-striped {{(isset($datatables) && $datatables) ? 'datatable' : ''}}">
	<thead>
		<tr>
			<th>#</th>
			@if(!isset($hide_details))
				<th>Name</th>
			@endif
			<th>Package</th>
			<th>Order Placed</th>
			<th>Price</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@if($orders->isEmpty())
			<tr class="danger text-center">
				<td colspan="7">No Orders Found</td>
			</tr>
		@else
			@foreach($orders as $order)
				<tr class="{{$order->state == 'I' ? 'danger' : 'success'}}">
					<td>
						{{$order->id}}
					</td>
					@if(!isset($hide_details))
						<td>
							{{link_to_route('profile', $order->owner->display_name, $order->owner->username)}}
							({{link_to_route('profile.settings', 'Edit User', $order->owner->username)}})
						</td>
					@endif
					<td>
						{{link_to_route('admin.packages.show', $order->package->name, $order->package->id)}}
					</td>
					<td>
						{{$order->created_at->format('m/d/Y \a\t g:iA')}}
					</td>
					<td>
						@if(!empty($order->final_cost))
							<span style="text-decoration:line-through">
						@endif
						${{$order->cost}}
						@if(!empty($order->final_cost))
							</span>
							${{$order->final_cost}}
							@if($order->coupon)
								<p>
									Coupon:
									{{$order->couponString()}}
								</p>
							@endif
						@endif

					</td>
					<td>
						{{Form::open(['route' => ['admin.orders.destroy', $order->id], 'method' => 'DELETE', 'class' => 'form-inline'])}}
							<a href="{{URL::route('admin.orders.show', $order->id)}}" class="btn btn-info btn-sm">
								<i class="glyphicon glyphicon-list-alt"></i>
								View Details
							</a>
			
							<button type="submit" class="btn btn-danger btn-sm">
								<i class="glyphicon glyphicon-trash"></i>
								Remove Order
							</button>
						{{Form::close()}}
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
