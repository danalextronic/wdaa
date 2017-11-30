@section('content')
	<div class="pull-right">
		{{link_to_route('admin.coupons.create', 'Create Coupon', [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>All Coupons</h1>
	</div>

	@if(!$coupons->isEmpty())
		<p class="lead">
			Rows marked in <span class="text-danger">RED</span> are disabled or no longer active
		</p>
	@endif

	<div class="responsive-table">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Coupon Code</th>
					<th>Name</th>
					<th>Discount</th>
					<th>Expiration</th>
					<th>Number of Uses</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if($coupons->isEmpty())
					<tr class="danger text-center">
						<td colspan="6">No Coupons Found!</td>
					</tr>
				@else
					@foreach($coupons as $coupon)
					<tr class="{{($coupon->inactive()) ? 'danger' : ''}}">
						<td>{{$coupon->code}}</td>
						<td>
							{{link_to_route('admin.coupons.show', $coupon->name, $coupon->id)}}
						</td>
						<td>
							{{$coupon->discountString()}}
						</td>
						<td>
							
							@if(!empty($coupon->expired_at))
								{{$coupon->expired_at->format('m/d/Y')}}
							@else
								N/A
							@endif
						</td>
						<td>
							{{$coupon->uses()->count()}}
						</td>
						<td>
							{{Form::open(['route' => ['admin.coupons.destroy', $coupon->id], 'method' => 'DELETE', 'class' => 'form-inline'])}}

								<a href="{{URL::route('admin.coupons.edit', $coupon->id)}}" class="btn btn-success btn-sm">
									<i class="glyphicon glyphicon-edit"></i>
									Edit Coupon
								</a>

								<button type="submit" class="btn btn-danger btn-sm">
									<i class="glyphicon glyphicon-trash"></i>
									Delete Coupon
								</button>

							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
@stop
