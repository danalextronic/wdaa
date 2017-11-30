<div class="panel-body">
	<p class="lead">
		Click on each test name to view detailed scores
	</p>
</div>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Test</th>
			<th>{{Str::properize(Lang::get('site.learner'))}} Score</th>
			<th>{{Str::properize(Lang::get('site.master'))}} Score</th>
		</tr>
	</thead>
	<tbody>
		@foreach($scorecards as $sc)
		<tr>
			<td>
				{{link_to_route('verification.view_scorecard', $templates[$sc->template_id], [$sc->id], ['target' => '_blank'])}}
			</td>
			<td>
				@include('scorecards/verifications/partials/_final-score', ['scores' => $learner[$sc->template_id]])
			</td>
			<td>
				@include('scorecards/verifications/partials/_final-score', ['scores' => $master[$sc->template_id]])
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
