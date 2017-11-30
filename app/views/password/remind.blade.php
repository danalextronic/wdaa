@extends('layouts.master')

@section('content')
	<div class="page-header">
		<h1>Request Password Reset</h1>
	</div>
	
	<p class="lead">Provide your email address below to begin the password reset process.</p>
	
	{{Form::open(['class' => 'form-horizontal'])}}
		<div class="form-group">
			{{Form::label('email', 'Email Address', ['class' => 'control-label col-sm-2'])}}
			<div class="col-sm-10">
				{{Form::email('email', null, ['class' => 'form-control'])}}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{{Form::submit('Request Password Reset', ['class' => 'btn btn-primary'])}}
			</div>
		</div>
	{{Form::close()}}
@stop
