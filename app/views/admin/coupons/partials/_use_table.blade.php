<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Coupon Use for {{$coupon->name}}
		</h3>
	</div>

	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User</th>
					<th>Date</th>
					<th>Discount Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($uses as $u)
					<tr>
						<td>
							{{link_to_route('profile', $u->owner->display_name, $u->owner->username, ['target' => '_blank'])}}
						</td>
						<td>
							{{$u->date->toDayDateTimeString()}}
						</td>
						<td>
							${{$u->discount}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
