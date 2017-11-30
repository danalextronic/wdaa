<?php
	list($cols_width, $num_cols) = scorecardRowSettings($template);
?>

<div class="table-wrapper">
	@if($template->use_test_rows && isset($items['T']) && count($items['T']) > 0)
		@include('scorecards/partials/_table', ['rows' => $items['T'], 'type' => 'test'])
	@endif

	<div class="divider"></div>

	@if($template->use_overall_rows && isset($items['O']) && count($items['O']) > 0)
		@include('scorecards/partials/_table', ['rows' => $items['O'], 'type' => 'overall'])
	@endif
</div>
