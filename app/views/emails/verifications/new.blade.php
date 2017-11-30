@extends('layouts.email')

@section('subject')
	You have scorecards to evaluate
@stop

@section('content')
	<p>Hello {{$user->display_name}}</p>

	<p>{{$completed_user->display_name}} has completed their tests</p>

	<p>Visit the link below to review their results and to leave your comments and satisfactory rating.</p>

	<p>{{link_to_route('verification.dashboard', 'Validate Results')}}</p>
@stop
