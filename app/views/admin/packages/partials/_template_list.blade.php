<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Assigned Scorecard Templates</h3>
	</div>

	<div class="panel-body">
		<table class="table">
			<thead>
				<tr>
					<th>Scorecard</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($templates as $t)
				<tr>
					<td>
						{{link_to_route('admin.templates.show', $t->name, $t->id)}}
					</td>
					<td>
						<a href="{{URL::route('admin.templates.edit', $t->id)}}" class="btn btn-success">
							<i class="glyphicon glyphicon-edit"></i>
							Edit Template
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
