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
		<h1>Create Coupon</h1>
	</div>

	{{Form::open(['route' => 'admin.coupons.store', 'class' => 'form-horizontal'])}}
		@include('admin.coupons.partials._form')
	{{Form::close()}}
@stop
