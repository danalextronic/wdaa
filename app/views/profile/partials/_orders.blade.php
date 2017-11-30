<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Orders</h3>
	</div>
	
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Price</th>
				<th>Date Completed</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
			<tr>
				<td>
					{{$order->package->name}}
				</td>
				<td>
					<span {{(!empty($order->final_cost)) ? 'style="text-decoration: line-through"' : ''}}>
						${{number_format($order->cost, 2)}}
					</span>
					@if(!empty($order->final_cost))
						<br />
						<span>
							${{number_format($order->final_cost, 2)}}
						</span>
					@endif
				</td>
				<td>
					{{$order->date_completed->format('m/d/Y')}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
	<div class="panel-footer">
		<span class="billing-total">Order Total: {{$orders->totalCost()}}</span>
	</div>
</div>

<div class="divider"></div>
