@include('partials/packages/chosen')
@include('partials/packages/wysiwyg')

@section('content')
	<div class="page-header">
		<h1>Create Package</h1>
	</div>

	{{Form::open(['route' => 'admin.packages.store', 'class' => 'form-horizontal'])}}
		@include('admin/packages/partials/_form')
	{{Form::close()}}
@stop
