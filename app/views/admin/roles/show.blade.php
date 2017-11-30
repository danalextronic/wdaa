@if($role->users)
	@include('partials/packages/datatables')
@endif

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.roles.index', 'Return to Role Listing', $role->id, ['class' => 'btn btn-info'])}}
	</div>
	<div class="page-header">
		<h1>View Role</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Role Information</div>
		<div class="panel-body">
			<ul>
				<li>Role Name: {{$role->name}}</li>
				<li>Role Level: {{$role->level}}</li>
				<li>Last Updated: {{$role->updated_at->diffForHumans()}}</li>
			</ul>

			@include('admin.roles.partials._actions')
		</div>
	</div>

	@if($role->users)
		<div class="panel panel-default">
			<div class="panel-heading">
				Users Assigned to this Role
			</div>

			<div class="panel-body">
				@include('admin/users/partials/_table', ['users' => $role->users, 'hide_roles' => true])
			</div>
		</div>
	@endif
@stop
