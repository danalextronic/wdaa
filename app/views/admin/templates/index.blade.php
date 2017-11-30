@include('partials.packages.datatables')

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.templates.create', 'Create New Template', [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>Scorecard Templates</h1>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped {{(!$templates->isEmpty()) ? 'datatable' : ''}}">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Type</th>
					<th>Last Updated</th>
					<th>Author</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if($templates->isEmpty())
					<tr class="danger text-center">
						<td colspan="6">No Templates Available</td>
					</tr>
				@else
					@foreach($templates as $template)
						<tr>
							<td>{{$template->id}}</td>
							<td>
								{{link_to_route('admin.templates.show', $template->name, $template->id)}}
							</td>
							<td>
								{{($template->type == 'S') ? 'Scored' : 'Drag and Drop'}}
							</td>
							<td>
								{{$template->updated_at->diffForHumans()}}
							</td>
							<td>
								@if(!is_null($template->owner))
									{{link_to_route('profile', $template->owner->display_name, $template->owner->username)}}
								@else
									N/A
								@endif
							</td>
							<td>
								@if($template->packages->count() == 0)
									{{Form::open(['method' => 'DELETE', 'route' => ['admin.templates.destroy', $template->id]])}}
								@endif

								<a class="btn btn-sm btn-success" href="{{URL::route('admin.templates.edit', $template->id)}}">
									<i class="glyphicon glyphicon-edit"></i>
									Edit Template
								</a>

								@if($template->type == 'S')
									<a class="btn btn-sm btn-success" href="{{URL::route('admin.templates.rows', $template->id)}}">
										<i class="glyphicon glyphicon-th-list"></i>
										Edit Rows
									</a>
								@endif

								@if($template->packages->count() == 0)
									<button type="submit" class="btn btn-sm btn-danger delete-btn">
										<i class="glyphicon glyphicon-trash"></i>
										Delete
									</button>
									{{Form::close()}}
								@endif
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
@stop
