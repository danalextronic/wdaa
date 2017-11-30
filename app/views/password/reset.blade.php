@extends('layouts.master')

@section('content')
	<div class="page-header">
		<h1>Reset Password</h1>
	</div>
	
	<p class="lead">
		Please fill out the form below to reset your password
	</p>

	{{Form::open(['class' => 'form-horizontal'])}}
	{{Form::hidden('token', $token)}}

	<div class="form-group">
		{{Form::label('email', 'Email Address', ['class' => 'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::email('email', null, ['class' => 'form-control'])}}
		</div>
	</div>

	<div class="form-group">
		{{Form::label('password', 'New Password', ['class' => 'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::password('password', ['class' => 'form-control'])}}
		</div>
	</div>

	<div class="form-group">
		{{Form::label('password_confirmation', 'Confirm New Password', ['class' => 'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::password('password_confirmation',['class' => 'form-control'])}}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			{{Form::submit('Reset Password', ['class' => 'btn btn-primary'])}}
		</div>
	</div>

	{{Form::close()}}


@stop
