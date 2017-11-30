<div class="form-group {{$errors->has('first_name') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('first_name', 'First Name', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::text('first_name', null, ['class' => 'form-control'])}}
		@if($errors->has('first_name'))
			<span class="help-block">{{$errors->first('first_name')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('last_name') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('last_name', 'Last Name', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::text('last_name', null, ['class' => 'form-control'])}}
		@if($errors->has('last_name'))
			<span class="help-block">{{$errors->first('last_name')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('username', 'Username', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		<?php $disabled = ($is_settings_page) ? ['disabled' => 'disabled'] : [] ?>
 		{{Form::text('username', null, ['class' => 'form-control'] + $disabled)}}
		@if($errors->has('username'))
			<span class="help-block">{{$errors->first('username')}}</span>
		@elseif($is_settings_page)
			<span class="help-block">Usernames cannot be changed</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('email', 'Email', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::email('email', null, ['class' => 'form-control'])}}
		@if($errors->has('email'))
			<span class="help-block">{{$errors->first('email')}}</span>
		@endif
	</div>
</div>

@if(!$is_settings_page)
<div class="form-group {{$errors->has('email_confirmation') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('email_confirmation', 'Confirm Email', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::email('email_confirmation', null, ['class' => 'form-control'])}}
		@if($errors->has('email_confirmation'))
			<span class="help-block">{{$errors->first('email_confirmation')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('password', 'Password', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::password('password', ['class' => 'form-control'])}}
		@if($errors->has('password'))
			<span class="help-block">{{$errors->first('password')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
	<div class="col-sm-3">
		{{Form::label('password_confirmation', 'Confirm Password', ['class' => ' control-label'])}}
		<span class="required_marker">*</span>
	</div>

	<div class="col-sm-9">
		{{Form::password('password_confirmation', ['class' => 'form-control'])}}
		@if($errors->has('password_confirmation'))
			<span class="help-block">{{$errors->first('password_confirmation')}}</span>
		@endif
	</div>
</div>
@endif
