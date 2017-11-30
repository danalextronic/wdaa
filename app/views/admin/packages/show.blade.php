@section('header_scripts')
	@include('partials/packages/jwplayer')
@stop

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.packages.index', 'Return to Package Listing', [], ['class' => 'btn btn-info'])}}
		{{link_to_route('admin.packages.edit', 'Edit Package', $package->id, ['class' => 'btn btn-success'])}}
	</div>

	<div class="page-header">
		<h1>
			View Package
			<small>
				&raquo; {{$package->name}}
			</small>
		</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Package Details
			</h3>
		</div>

		<div class="panel-body">
			@if($package->owner)
				<p>Created by: {{$package->owner->display_name}}</p>
			@endif
			
			<p>Date Created: {{$package->created_at->format('m/d/Y')}}</p>
			<p>Date Updated: {{$package->updated_at->format('m/d/Y')}}</p>
			<p>
				Cost: ${{$package->cost}}
			</p>
		</div>
	</div>

	@if(!$package->templates->isEmpty())
		@include('admin.packages.partials._template_list', ['templates' => $package->templates])
	@endif
@stop
