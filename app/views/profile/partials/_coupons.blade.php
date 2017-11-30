<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Coupons applied to this payment
		</h3>
	</div>
	<div class="panel-body">
		<table class="table">
			<thead>
				<tr>
					<th>Coupon Name</th>
					<th>Coupon Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($coupons as $c)
					<tr>
						<td>{{$c->coupon->name}}</td>
						<td>{{$c->coupon->discountString()}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="divider"></div>
