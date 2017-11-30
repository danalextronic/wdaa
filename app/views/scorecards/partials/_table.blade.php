<?php 
	$label = "{$type}_rows_label"; 
	$num_cols = ($type == 'overall') ? $num_cols - 1 : $num_cols;

	$panel_color = panelColor($scorecard, $compare);
?>
<div class="panel {{$panel_color}}">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{compareText($scorecard, $compare)}}
			{{$template->$label}}
		</h3>
	</div>

	<table class="table table-striped">
		@if(!$compare)
			<col width="25" />
		@endif
		@unless($compare && $scorecard->type == 'LEARNER')
			<col width="{{$cols_width}}" />
		@endunless
		@for($i = 0; $i<$num_cols;$i++)
			<col width="70" />
		@endfor

		<col width="330" />
		<thead>
			<tr>
				@if(!$compare)
					<th>#</th>
				@endif
				@unless($compare && $scorecard->type == 'LEARNER')
					<th>Test</th>
				@endunless
				@if(!$template->use_manual_score)
					<th>Points</th>
					@if($template->use_coef)<th>Coef</th>@endif
					@if($type == 'test' && $template->use_errors)<th>Errors</th>@endif
				@endif

				<th>
					{{$template->use_row_comment ? 'Comments' : ''}}
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $num = 1; ?>
			@foreach($rows as $item)
				@include('scorecards/partials/_row', ['num' => $num])
				<?php $num++ ?>
			@endforeach
		</tbody>
	</table>
</div>
