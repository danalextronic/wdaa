@extends('layouts.email')

@section('subject')
	There is a new scorecard to verify
@stop

@section('content')
	<p>Hello {{$user->display_name}}</p>

	<p>{{$evaulated_user->display_name}} has reviewed the tests that were completed by {{$completed_user->display_name}}</p>

	<p>Visit the link below to verify their results.</p>

	<p>{{link_to_route('verification.dashboard', 'Verify Results')}}</p>
@stop
