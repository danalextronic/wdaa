<tr class="row-item {{($item['item']->isComplete($template) && $editable) ? 'success' : ''}}" data-item-id="{{$item['item']->id}}" @if($compare)id="{{strtolower($scorecard->type) . '_' . $type . '_row_' . $num}}"@endif>
	@if(!$compare)
		<td id="meta_items_{{$item['item']->id}}">
			@if($editable)
				<input type="hidden" name="rows[{{$item['item']->id}}][points]" value="0" />
				<input type="hidden" name="rows[{{$item['item']->id}}][errors]" value="0" />
				<input type="hidden" name="rows[{{$item['item']->id}}][coef]" value="{{$item['item']->coef}}" />
				<input type="hidden" name="rows[{{$item['item']->id}}][comments]" value="" />
			@endif
			{{$num}}
		</td>
	@endif

	<!-- MARKERS / TEST -->
	@unless($compare && $scorecard->type == 'LEARNER')
	<td>
		@if($type == 'test' && $template->use_markers && count($item['markers']) > 0)
			<div class="marker-wrapper">
				@foreach($item['markers'] as $marker)
					@include('scorecards/partials/_marker')
				@endforeach
			</div>
		@else
			{{$item['template_item']->text}}
		@endif

		@if($template->use_ideas && !empty($item['template_item']->ideas))
			<div class="directive_ideas">
				<strong>Directive Ideas:</strong> 
				{{$item['template_item']->ideas}}
			</div>
		@endif
	</td>
	<!-- // MARKERS / TEST -->
	@endunless

	@if(!$template->use_manual_score)
		<!-- POINTS -->
		<td>
			{{buildPointsDropdown($item['item']->points, $item['item']->id, $template->scoring_precision, $editable)}}
		</td>
		<!-- /POINTS -->

		@if($template->use_coef)
			<!-- COEFFICIENT -->
			<td>
				@if($template->manual_coef)
					{{buildCoefficientDropdown(
						$item['item']->coef,
						$item['item']->id,
						1, 9, 1,
						$editable
					)}}
				@else
					{{$item['item']->coef}}
				@endif
			</td>
			<!-- /COEFFICIENT -->
		@endif

		@if($type == 'test' && $template->use_errors)
			<!-- ERRORS -->

			<td>
				{{buildErrorDropdown($item['item']->errors, $item['item']->id, 1, 9, 1, $editable)}}
			</td>

			<!-- /ERRORS -->
		@endif
	@endif

	<td {{$template->use_row_comment ? 'id="comments_'.$item['item']->id.'"' : ''}}>
		{{buildRowComment($item['item']->comments, $item['item']->id, $editable)}}

		@if($editable)
		<p class="saved-message text-info">
			@if($item['item']->updated_at && $item['item']->updated_at->ne($item['item']->created_at))
				Saved

				@if(date('dmY') != $item['item']->updated_at->format('dmY'))
					on {{$item['item']->updated_at->format('M d \a\t g:iA')}}
				@else
					at {{$item['item']->updated_at->format('g:iA')}}
				@endif

			@endif
		</p>
		@endif
	</td>
</tr>
