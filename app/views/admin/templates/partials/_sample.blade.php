<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{($type == 'T') ? $template->test_rows_label : $template->overall_rows_label}}
		</h3>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Test</th>
				<th>Ideas</th>
				<th>Coef</th>
			</tr>
		</thead>
		<tbody>
			@foreach($items[$type] as $index => $item)
			<tr>
				<td>{{$index + 1}}</td>
				<td>
					@if($type == 'T' && $template->use_markers && !$item->markers->isEmpty())
						@foreach($item->markers as $marker)
							@include('scorecards/partials/_marker')
						@endforeach
					@else
						{{$item->text}}
					@endif
				</td>
				<td>{{$item->ideas}}</td>
				<td>{{$item->coef}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
