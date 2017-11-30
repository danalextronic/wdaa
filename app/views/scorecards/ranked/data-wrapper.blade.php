<?php
	$panel_color = panelColor($scorecard, $compare);
?>

<!-- SINGLE PLAYBACK CONTAINER -->
<div id="single-scorecard"></div>

<div class="panel {{$panel_color}}">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{($editable) ? 'Videos' : compareText($scorecard, $compare) . ' Rankings'}}
		</h3>
	</div>

	@if($editable)
	<div class="panel-body">
		<p class="lead">
			Click on the title to watch the video and leave a detailed comment, then drag and drop the thumbnails to place them.
		</p>

		@include('scorecards/ranked/partials/_video-grid')
	</div>
	@else
		@include('scorecards/ranked/partials/_list')
	@endif
</div>
