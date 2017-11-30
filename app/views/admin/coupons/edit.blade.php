@include('partials/packages/wysiwyg')

@section('external_js')
	<script>
		var newData = {
			'user_search' : "{{URL::route('users.search')}}"
		};

		if(typeof script_data !== 'undefined' && typeof script_data === 'object') {
			script_data = $.extend({}, script_data, newData);
		}
		else {
			var script_data = newData;
		}
	</script>
	{{HTML::script('assets/js/admin/coupons.js')}}
@stop

@section('content')
	<div class="page-header">
		<h1>
			Edit Coupon
			<small>
				{{$coupon->name}}
			</small>
		</h1>
	</div>

	{{Form::model($coupon, ['method' => 'PUT', 'route' => ['admin.coupons.update', $coupon->id], 'class' => 'form-horizontal'])}}
		@include('admin.coupons.partials._form', ['buttonText' => 'Save Coupon'])
	{{Form::close()}}
@stop
