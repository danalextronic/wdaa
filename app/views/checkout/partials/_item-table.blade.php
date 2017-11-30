<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">
			Order Details
		</h2>
	</div>
	<div class="panel-body">
		<div class="responsive-table">
			<table class="table" id="itemTable">
				<thead>
					<tr>
						<th style="width:60%">Name</th>
						<th style="width:30%">Cost</th>
						<th style="width:10%">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($order->items as $item)
						<tr id="order_{{$item->id}}">
							<td>{{$item->package->name}}</td>
							<td class="itemPriceWrapper">
								<div class="itemPrice {{(in_array($item->id, $discounted_items)) ? 'strike-out' : ''}}">
									<sup>$</sup><span class="price">{{number_format($item->cost, 2)}}</span>
								</div>

								<div class="discountedItemPrice {{(!in_array($item->id, $discounted_items)) ? 'hide' : ''}}">
									<sup>$</sup><span class="price">{{number_format($item->final_cost, 2)}}</span>
								</div>
							</td>
							<td>
								<button data-order-id="{{$item->id}}" class="btn btn-danger deleteItem">
									<i class="glyphicon glyphicon-ban-circle"></i> Remove
								</button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
