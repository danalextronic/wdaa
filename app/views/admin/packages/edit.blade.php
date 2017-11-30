@include('partials/packages/chosen')
@include('partials/packages/wysiwyg')

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.packages.index', 'Return to Package Listing', [], ['class' => 'btn btn-info'])}}
	</div>
	<div class="page-header">
		<h1>
			Edit Package
			<small>{{$package->name}}</small>
		</h1>
	</div>

	{{Form::model($package, ['method' => 'PATCH', 'route' => ['admin.packages.update', $package->id], 'class' => 'form-horizontal'])}}
		@include('admin/packages/partials/_form', ['buttonText' => 'Save Package'])
	{{Form::close()}}
@stop
