@extends(($in_modal) ? 'layouts.blank' : 'layouts.master')

@section('title')
	View Scorecard |
@stop

@if($editable)
	@include('partials/packages/jwplayer')
@endif

@section('external_css')
	{{HTML::style('assets/css/scorecard.css')}}
@stop

@section('external_js')
	@if($editable)
		{{HTML::script('vendor/bootbox/bootbox.js')}}
		{{HTML::script('assets/js/ranked-scorecard.js')}}
	@else
		{{HTML::script('assets/js/completed-ranked-scorecard.js')}}
	@endif
@stop

@section('content')
	@if(!isset($show_header) || $show_header === TRUE)
		@include('scorecards/partials/_header', ['type' => 'MASTER'])
	@endif

	@include('scorecards/ranked/data-wrapper')

	@if($editable)
		<div class="divider"></div>

		<div class="well submitForm">
			<button class="btn btn-success mark-complete" @unless($can_mark_complete)
				disabled="disabled"@endunless data-template-id="{{$template->id}}" data-scorecard-id="{{$scorecard->id}}">
				Mark Complete
			</button>
		</div>
	@endif
@stop
