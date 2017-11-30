@extends('layouts.compare')

@section('external_css')
	{{HTML::style('assets/css/scorecard.css')}}
@stop

@if($template->type == 'R')
	@section('external_js')
		{{HTML::script('assets/js/completed-ranked-scorecard.js')}}
	@stop
@endif

@section('content')
	@include('scorecards/partials/_header')

	{{$pagination}}

	@if($template->type == 'R')
		@include('scorecards/ranked/partials/_complete-description')
	@endif
	
	<div class="col-md-12">
		@include('scorecards/partials/_video')

		<div class="divider"></div>
	</div>
	
	<div class="col-md-6">
		{{$master}}
	</div>

	<div class="col-md-6">
		{{$learner}}
	</div>

	<div class="clearfix"></div>


	@unless($hide_return_button)
		<div class="divider"></div>

		<div class="compare-submit">
			{{link_to_route('profile', 'Return to Scorecard Listing', $user->username, ['class' => 'btn btn-success'])}}
		</div>
	@endunless

	{{$pagination}}
@stop
