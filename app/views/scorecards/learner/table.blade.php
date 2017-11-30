<div class="scorecard-list-wrapper">
	@if($scorecards->isEmpty())
		<div class="alert alert-danger">
			No Scorecards Found!
		</div>
	@else

		@if(isset($verified) && $verified === FALSE)
			<div class="alert alert-warning">
				Your results are currently being verified by our panel.
				Once verified, you will be able to view your scores alongside the {{Str::properize(Lang::get('site.master'))}} scores.
			</div>
		@endif
		<table class="table table-striped">
		<thead>
			<tr>
				<th>Test</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($scorecards as $sc)
				<tr>
					<td>
						{{link_to_route($name, $sc->template->name, [$user->username, $sc->id])}}
					</td>
					<td>
						@if(isset($verified) && $verified === FALSE)
							<span class="label label-warning">
								Awaiting Review
							</span>
						@else
							<span class="label label-{{($sc->complete) ? 'success' : 'danger'}}">
								{{$sc->complete ? 'Complete' : 'Incomplete'}}
							</span>
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif
</div>
