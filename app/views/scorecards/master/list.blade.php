<div class="responsive-table">
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th>Test</th>
				<th>Completed?</th>
				<th>Last Updated</th>
			</tr>
		</thead>
		<tbody>
			@foreach($scorecards as $sc)
				<tr>
					<td>{{link_to_route('master.scorecard', $sc->template->name, $sc->id)}}</td>
					<td class="text-center">
						<h4>
							@if($sc->complete)
								<span class="label label-success">Yes</span>
							@else
								<span class="label label-danger">No</span>
							@endif
						</h4>
					</td>
					<td>
						@if(date("dmY") != $sc->updated_at->format("dmY"))
							{{$sc->updated_at->format("F jS, Y")}}
						@else
							{{$sc->updated_at->diffForHumans()}}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
