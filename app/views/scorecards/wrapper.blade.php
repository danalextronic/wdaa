@extends(($in_modal) ? 'layouts.blank' : 'layouts.master')

@section('title')
	View Scorecard |
@stop

@if($in_modal)
	@section('internal_css')
		<style>
			#modal_wrapper {
				width:700px;
				margin-top:15px;
			}
		</style>
	@stop
@endif

@section('external_css')
	{{HTML::style('assets/css/scorecard.css')}}
@stop

@if($editable)
	@section('external_js')
		{{HTML::script('vendor/momentjs/moment.js')}}
		{{HTML::script('vendor/bootbox/bootbox.js')}}
		{{HTML::script('assets/js/scorecard.js')}}
	@stop
@endif

@if($show_video)
	@include('partials/packages/jwplayer')
@endif

@section('content')
	@if($show_header)
		@include('scorecards/partials/_header')
	@endif

	@if(!$in_modal)<div class="col-md-offset-1 col-md-10">@endif
		@include('scorecards.data-wrapper')
	@if(!$in_modal)</div>@endif
@stop
