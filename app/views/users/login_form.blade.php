@extends((($modal) ? 'layouts.blank' : 'layouts.master'))

@section('content')
	<?php $modalLink = ($modal) ? ['target' => '_parent'] : [] ?>
	
	<div class="page-header">
		<h1>Login</h1>
	</div>

	<div class="col-md-6 login-form">
		{{Form::open(array_merge(['route' => 'login', 'class' => 'form-horizontal'], $modalLink))}}
			<div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
				{{Form::label('username', 'Username or Email', ['class' => 'col-sm-4 control-label'])}}
				<div class="col-sm-8">
					{{Form::text('username', null, ['class' => 'form-control'])}}
					@if($errors->has('username'))
						<span class="help-block">Please provide a username or email address</span>
					@endif
				</div>
			</div>

			<div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
				{{Form::label('password', 'Password', ['class' => 'col-sm-4 control-label'])}}
				<div class="col-sm-8">
					{{Form::password('password', ['class' => 'form-control'])}}
					@if($errors->has('password'))
						<span class="help-block">{{$errors->first('password')}}</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					{{Form::submit('Sign In', ['class' => 'btn btn-primary login-button'])}}
					
						{{HTML::link('password/remind','Forget your password?', array_merge(['class' => 'btn btn-info login-button'], $modalLink))}}
					
				</div>
			</div>
		{{Form::close()}}
	</div>

	<div class="col-md-5 register-block">
		<h3>Don't have an account?</h3>

		<p>
			{{link_to_route('signup', 'Create Account', [], ['class' => 'btn btn-success login-button'])}}
		</p>
	</div>
@stop
