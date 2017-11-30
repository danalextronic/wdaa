@include('partials/packages/datatables')

@section('content')
	<div class="page-header">
		<h1>All Users</h1>
	</div>

	@include('admin/users/partials/_table')
@stop
