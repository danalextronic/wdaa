<div class="panel {{panelColor($scorecard, $compare)}}" id="{{($compare) ? strtolower($scorecard->type) . '_global_comment' : 'global_comment_container'}}">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{compareText($scorecard, $compare)}}
			@lang('site.global_comment_title')
		</h3>
	</div>

	<div class="panel-body">
		@if($editable)
			{{Form::textarea('global_comment', $scorecard->global_comment, ['class' => 'form-control', 'id' => 'global_comment'])}}
		@else
			<blockquote>{{$scorecard->global_comment}}</blockquote>
		@endif
	</div>
	
	@if($editable)
		<div class="panel-footer">
			<p class="updated-score text-info">
				@if($scorecard->updated_at)
					Saved
					@if(date('dmY') != $scorecard->updated_at->format('dmY'))
						on {{$scorecard->updated_at->format('M d \a\t g:ia')}}
					@else
						at {{$scorecard->updated_at->format('g:iA')}}
					@endif
				@endif
			</p>
		</div>
	@endif

</div>
