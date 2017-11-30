<p>You've completed the scoring process!</p>

@if($scorecard->type == 'LEARNER')
	<p class="text-warning">
		NOTE: you will not be allowed to make any edits once you've marked the scorecard as complete
	</p>
@endif

@if(($template->use_test_rows && count($items) > 0) || ($template->use_overall_rows && count($items) > 0) || ($template->use_manual_score))
	<p>
		<strong>Final Score:</strong> <?=$score['score'];?> / <?=$score['max_score']; ?> 
		(<?= number_format(($score['score'] / $score['max_score']) * 100,2); ?> %)
	</p>
@endif

@include('scorecards/partials/dialogs/_table')
