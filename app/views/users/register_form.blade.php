@extends('layouts.master')

@section('content')
	<div class="container-narrow">

	<div class="page-header">
		<p class="pull-right">Already have an account? {{link_to_route('login', 'Login', [], ['class' => 'btn btn-success'])}}</p>
		<h1>Register</h1>
	</div>

	@if($errors->any())
		<div class="alert alert-danger">
			There were errors that were found on the form below
		</div>
	@endif

	{{Form::open(['route' => 'signup', 'class' => 'form-horizontal'])}}

	<div class="page-header">
		<h3>
			Basic Information</br>
			<small>
				Complete this form to create your account. All fields with a red star ( <span class="required_marker">*</span> ) are required
			</small>
		</h3>
	</div>

	@include('partials/_user_essentials', ['is_settings_page' => false])

	<div class="page-header">
		<h3>Contact Information</h3>
	</div>
	
	@include('partials/_address')

	<div class="page-header">
		<h3>Terms of Service</h3>
	</div>

	<div class="tos-container">
		<p>
			@include('tos/register')
		</p>
	</div>

	<div class="checkbox tos-accept">
		<label>
			{{Form::checkbox('accept_tos')}}
			{{Lang::get('site.tos_text')}}
		</label>
		@if($errors->has('accept_tos'))
			<p class="text-danger">Please Accept the terms of service above before proceeding</p>
		@endif
	</div>

	<div class="form-group">
		{{Form::submit('Sign Up', ['class' => 'btn btn-primary btn-lg'])}}
	</div>
	</div>
	{{Form::close()}}
@stop

@section('external_js')
	{{HTML::script('vendor/jquery.maskedinput/jquery.maskedinput.min.js')}}
	{{HTML::script('assets/js/localization.js')}}
@stop
