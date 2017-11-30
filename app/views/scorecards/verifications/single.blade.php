@extends('layouts.master')

@section('title')
	Evaluate Results |
@stop

@section('external_css')
	{{HTML::style('assets/css/verification.css')}}
@stop

@section('external_js')
	{{HTML::script('assets/js/verification.js')}}
@stop

@section('content')
	<div class="pull-right">
		{{link_to_route('verification.dashboard', 'Return to Listing' , [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>
			Verification
			<small>
				Completed by {{$order->owner->display_name}} on
				{{$order->date_scorecards_completed->format('m/d/Y')}}
			</small>
		</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Results</h3>
		</div>

		@if($template_type == 'R')
			@include('scorecards.verifications.ranked_results_table')
		@else
			@include('scorecards.verifications.results_table')
		@endif
	</div>

	<div class="divider"></div>

	@unless($order->verifications->isEmpty())
		@include('scorecards.verifications.existing-verifications', ['verifications' => $order->verifications])
	@endunless

	@if($order->canCreateVerification())
		<div class="divider"></div>
		@include('scorecards.verifications.comment-form')
	@endif
@stop
