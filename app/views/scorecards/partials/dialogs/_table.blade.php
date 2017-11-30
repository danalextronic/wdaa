<table class="table">
	<thead>
		<tr>
			<th>Step</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($checklist as $key => $value)
			<tr>
				<td>{{$labels[$key]}}</td>
				<td>
					@if($value)
						<strong class="text-success">Complete</strong>
					@else
						<strong class="text-danger">Incomplete</strong>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
