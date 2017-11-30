@section('content')
	<div class="pull-right">
		{{link_to_route('admin.coupons.index', 'Return to Coupon List', [], ['class' => 'btn btn-info'])}}
		{{link_to_route('admin.coupons.edit', 'Edit Coupon', $coupon->id, ['class' => 'btn btn-success'])}}
	</div>

	<div class="page-header">
		<h1>
			Coupons
			<small>
				&raquo; {{$coupon->name}}
			</small>
		</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Coupon Details
			</h3>
		</div>

		<div class="panel-body">
			<div class="col-sm-6">
				<ul class="list-group">
					<li><strong>Coupon Code</strong> - {{$coupon->code}}</li>
					<li><strong>Coupon Name</strong> - {{$coupon->name}}</li>
					<li><strong>Discount</strong> - {{$coupon->discountString()}}</li>
					<li><strong>Active</strong> -  {{ $coupon->active() ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>'}}</li>
				</ul>
			</div>
			<div class="col-sm-6">
				<ul class="list-group">
					@if(!empty($coupon->expired_at))
						<li><strong>Expiration Date</strong> - {{$coupon->expired_at->format('m/d/Y')}}</li>
					@endif

					@if(!empty($coupon->package_id))
						<li><strong>Package Assigned</strong> - {{$coupon->package->name}}</li>
					@endif

					@if(!empty($coupon->user_id))
						<li><strong>User Assigned</strong> - {{link_to_route('profile', $coupon->owner->display_name, $coupon->owner->username, ['target' => '_blank'])}}</li>
					@endif
				</ul>
			</div>
			<div class="clearfix"></div>

			@unless(empty($coupon->description))
				<div class="divider"></div>

				<blockqoute>
					{{$coupon->description}}
				</blockqoute>
			@endunless
		</div>
	</div>

	@if(!$coupon->uses->isEmpty())
		<div class="divider"></div>
		
		@include('admin/coupons/partials/_use_table', ['uses' => $coupon->uses])
	@endif

@stop
