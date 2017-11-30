<div class="panel {{panelColor($scorecard, $compare)}}" @if($editable)id="manual_score_container"@endif>
	<div class="panel-heading">
		<h3 class="panel-title">
			{{compareText($scorecard, $compare)}}
			@lang('site.manual_score_title')
		</h3>
	</div>

	<div class="panel-body">
		@if($editable)
			<div class="input-group">
				{{Form::text('score', ($scorecard->score != '0.00') ? $scorecard->score : '', ['class' => 'form-control', 'id' => 'manual_score'])}}
				<div class="input-group-addon">/{{Config::get('site.scorecard.max_score')}}</div>
			</div>
		@else
			<div class="text-center final-score">
				{{$scorecard->score}} / {{$scorecard->max_score}} = {{number_format(($scorecard->score / $scorecard->max_score) * 100, 2)}}%
			</div>
		@endif
	</div>

	@if($editable)
	<div class="panel-footer">
		<small class="updated-score text-info">
			@if($scorecard->updated_at)
				Last Updated: <br />
				@if(date('dmY') != $scorecard->updated_at->format('dmY'))
					{{$scorecard->updated_at->format('M d \a\t g:ia')}}
				@else
					{{$scorecard->updated_at->format('g:iA')}}
				@endif
			@endif
		</small>
	</div>
	@endif
</div>
