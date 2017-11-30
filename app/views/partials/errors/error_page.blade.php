@extends('layouts.master')

@section('content')
	<div class="well text-center">
		@if(!empty($message))
			<h1>{{$message}}</h1>
		@else
			<h1>Page does not exist!</h1>

			<p>I'm sorry, but the page that you are requesting does not exist</p>
		@endif
	</div>
@endsection
