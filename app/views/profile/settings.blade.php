@if(Auth::user()->isAdmin())
	@include('partials.packages.chosen')
@endif

@section('content')
	{{Form::model($user, ['class' => 'form-horizontal'])}}

	@if(!Auth::user()->isAdmin())
		<div class="alert alert-warning">
			You must submit your current password before making changes
		</div>
	@endif

	<p class="lead">
		All fields with a red star ( <span class="required_marker">*</span> ) are required
	</p>

	@if($errors->any())
		<div class="alert alert-danger">
			Please correct any errors below before proceeding.
		</div>
	@endif

	@include('partials._user_essentials', ['is_settings_page' => true])

	<hr />

	@include('partials._address')

	<hr />

	@include('partials._change_password', ['is_settings_page' => true])

	@if(Auth::user()->isAdmin())
		<hr />

		@include('partials._admin_settings', ['role_list' => $role_list, 'current_roles' => $current_roles])
	@endif

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			{{Form::submit('Save Settings', ['class' => 'btn btn-primary'])}}
		</div>
	</div>

	{{Form::close()}}
@stop

@section('external_js')
	{{HTML::script('vendor/jquery.maskedinput/jquery.maskedinput.min.js')}}
	{{HTML::script('assets/js/localization.js')}}
@stop
