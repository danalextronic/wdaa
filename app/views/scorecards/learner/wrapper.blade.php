<?php
	$scorecards = $item->scorecard;
	$scorecards->load('template');
	$incomplete = $scorecards->filterBy('incomplete');
	$complete = $scorecards->filterBy('complete');

	$template = $item->package->templates->first();

	$is_reviewed = ($item->completed($template->type == 'R')) ? $item->reviewed() : false;

	$active_tab = ($incomplete->isEmpty()) ? 'complete' : 'incomplete';

	$route = scorecardLink($is_reviewed);
?>

<ul class="nav nav-tabs scorecard-tabs">
	@unless($incomplete->isEmpty())
		<li {{($active_tab == 'incomplete') ? 'class="active"' : ''}}>
			<a href="#incomplete" data-toggle="tab">
				Incomplete
			</a>
		</li>
	@endunless

	@unless($complete->isEmpty())
		<li {{($active_tab == 'complete') ? 'class="active"' : ''}}>
			<a href="#complete" data-toggle="tab">
				Complete
			</a>
		</li>
	@endunless
</ul>

<div class="tab-content">
	@unless($incomplete->isEmpty())
		<div class="tab-pane {{($active_tab == 'incomplete') ? 'active' : ''}}" id="incomplete">
			@include('scorecards/learner/table', ['scorecards' => $incomplete, 'name' => $route])
		</div>
	@endunless

	@unless($complete->isEmpty())
		<div class="tab-pane {{($active_tab == 'complete') ? 'active' : ''}}" id="complete">
			@include('scorecards/learner/table', ['scorecards' => $complete, 'name' => $route, 'verified' => $is_reviewed])
		</div>
	@endunless
</div>

@if($is_reviewed && !$item->verifications->isEmpty())
	<div class="divider"></div>
	
	@include('scorecards/verifications/existing-verifications', ['verifications' => $item->verifications, 'editing' => false, 'title' => 'Panel Commentary'])
@endif
