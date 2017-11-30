@section('content')
	<div class="page-header">
		<h1>Create New Role</h1>
	</div>

	{{Form::open(['route' => 'admin.roles.store', 'class' => 'form-horizontal'])}}
		@include('admin/roles/partials/_form')
	{{Form::close()}}
@stop
