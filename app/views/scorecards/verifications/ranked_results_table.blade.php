<div class="panel-body">
	<p class="lead">
		Click on each scorecard to view comparison scores
	</p>
</div>

<ul class="list-group">
	@foreach($scorecards as $sc)
		<li class="list-group-item">
			{{link_to_route('verification.view_scorecard', $templates[$sc->template_id], [$sc->id], ['target' => '_blank'])}}
		</li>
	@endforeach
</ul>
