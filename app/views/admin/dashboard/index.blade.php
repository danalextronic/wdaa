@section('content')
	<div class="page-header">
		<h1>Admin Dashboard</h1>
	</div>

	@unless($users->isEmpty())
		@include('admin.dashboard.partials._user-list')
	@endunless

	<div class="divider"></div>

	@unless(empty($students))
		@include('admin.dashboard.partials._student-list')
	@endunless
@stop
