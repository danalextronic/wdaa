@include('partials/packages/datatables')

@section('content')
	<div class="pull-right">
		<a href="{{URL::route('admin.roles.create')}}" class="btn btn-info">
			<i class="glyphicon glyphicon-pencil"></i>
			Create New Role
		</a>
	</div>

	<div class="page-header">
		<h1>All User Roles</h1>
	</div>

	@if(!empty($roles))
		<p class="lead">Role Levels indicate amount of site priveliges. 10 = high, -1 = banned</p>
	@endif

	<table class="table table-bordered table-striped datatable">
		<col width="15%" />
		<col width="25%" />
		<col width="15%" />
		<col width="15%" />
		<col width="30%" />
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Level</th>
				<th>Number of Users</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@if(empty($roles))
				<tr class="danger text-center">
					<td colspan="5">No User Roles Found</td>
				</tr>
			@else
				@foreach($roles as $role)
					<tr>
						<td>{{$role->id}}</td>
						<td>{{link_to_route('admin.roles.show', $role->name, $role->id)}}</td>
						<td>{{$role->level}}</td>
						<td>{{$role->users()->count()}}</td>
						<td>
							@include('admin.roles.partials._actions')
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
@stop
