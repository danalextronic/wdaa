
@if($show_video)
	@include('scorecards/partials/_video')

	<div class="divider"></div>
@endif

@include('scorecards/partials/_table-wrapper')

<div class="divider"></div>

@if($compare)
	@include('scorecards/partials/_comparison-totals')
@else
<div class="row">
	@if($template->use_manual_score)
		<div class="col-md-{{!$template->use_global_comment ? '4' : '2'}}">
			@include('scorecards/partials/_manual-score')
		</div>
	@endif

	@if($template->use_global_comment)
		<div class="col-md-{{($template->use_manual_score) ? '10' : '12'}}">
			@include('scorecards/partials/_global-comment')
		</div>
	@endif
</div>
@endif

@if($editable)
	<div class="submitForm">
		<button id="save_scorecard" class="btn btn-primary btn-lg" data-scorecard-id="{{$scorecard->id}}">
			Complete Scorecard
		</button>
		<img src="/assets/images/loading-animation.gif" id="loader" style="display:none" />
	</div>
@endif
