@extends('layouts.email')

@section('subject')
	You have requested a password reset.
@stop

@section('content')
	<div>
		<p>You have requested a password reset.</p>
		<p>To reset your password, click the following link: </p>
		<p><a href="{{ URL::to('password/reset', array($token)) }}">Reset Password</a>.</p> 
		<p>This link will expire 1 hour from the time that you have received this email.</p>
		<p>Please discard this message if you believe that you have received it in error.</p>
	</div>
@stop
