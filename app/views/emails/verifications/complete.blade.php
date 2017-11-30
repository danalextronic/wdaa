@extends('layouts.email')

@section('subject')
	The comparison results are available
@stop

@section('content')
	<p>Hello {{$user->display_name}}</p>

	<p>Thank you very much for completing your 16 Western Dressage Test scorecards. You may now go to the website to review your results and see your evaluation report.  A member of the Judge Education Task Force will be contacting you to discuss your results and explain the next steps in the licensing process.</p>

	<p>Click the link below to return to your user dashboard and see your completed results.</p>

	<p>{{link_to_route('profile', 'View Results', $user->username)}}</p>


@stop