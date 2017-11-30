@section('content')
	<div class="pull-right">
		{{link_to_route('admin.roles.index', 'Return to Role Listing', [], ['class' => 'btn btn-info'])}}
	</div>
	<div class="page-header">
		<h1>Edit Role</h1>
	</div>

	{{Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->id], 'class' => 'form-horizontal'])}}
		@include('admin/roles/partials/_form')
	{{Form::close()}}
@stop
