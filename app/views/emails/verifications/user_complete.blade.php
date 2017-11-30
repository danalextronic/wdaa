@extends('layouts.email')

@section('subject')
	Thanks for completing the {{$package->name}}
@stop

@section('content')
	<p>Hello {{$user->display_name}}</p>

	<p>You have successfully completed the tests in the {{$package->name}}</p>

	<p>Your results are currently being verified by our panel.
				Once verified, you will be able to view your scores alongside the {{Str::properize(Lang::get('site.master'))}} scores.</p>

	<p>We will contact you again via email once the panel has reviewed your results.</p>
@stop
