@include('partials/packages/datatables')

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.packages.create', 'Create new Package', [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>All Packages</h1>
	</div>

	<table class="table table-bordered table-striped {{(!$packages->isEmpty()) ? 'datatable' : ''}}">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Owner</th>
				<th># of Scorecards</th>
				<th>Cost</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@if($packages->isEmpty())
				<tr class="danger text-center">
					<td colspan="8">No Packages Found</td>
				</tr>
			@else
				@foreach($packages as $package)
					<tr>
						<td>{{$package->id}}</td>
						<td>
							{{link_to_route('admin.packages.show', $package->name, $package->id)}}
						</td>
						<td>
							@if($package->owner)
							{{link_to_route('profile.settings', $package->owner->display_name, $package->owner->username)}}
							@else
								N/A
							@endif
						</td>
						<td>{{$package->templates->count()}}</td>
						<td>${{$package->cost}}</td>
						<td>
							{{Form::open(['method' => 'DELETE', 'route' => ['admin.packages.destroy', $package->id]])}}
								<a href="{{URL::route('admin.packages.edit', $package->id)}}" class="btn btn-success">
									<i class="glyphicon glyphicon-edit"></i>
									Edit
								</a>
								<button type="submit" class="btn btn-danger">
									<i class="glyphicon glyphicon-trash"></i>
									Delete
								</button>

							{{Form::close()}}
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
@stop
