@extends('layouts.master')

@section('title')
	Evaluate Scorecards |
@stop

@section('external_css')
	{{HTML::style('assets/css/verification.css')}}
@stop

@section('content')

	@if(Input::get('msg') == 'complete')
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			You have completed the verification process
		</div>
	@endif

	<div class="panel panel-default verification-panel">
		<div class="panel-heading">
			@include('scorecards.verifications.tabs')
		</div>
	</div>

	<div class="tab-content">
		@include('scorecards.verifications.tab_wrapper', ['tab' => $current_tab, 'orders' => $orders, 'name' => ucwords($current_tab)])
	</div>
@stop
