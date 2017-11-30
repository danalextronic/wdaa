@include('partials/packages/chosen')
@include('partials/packages/wysiwyg')
@include('partials/packages/jwplayer')

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.templates.index', 'Return to Template Listing', [], ['class' => 'btn btn-info'])}}
		@if($template->type == 'S')
			{{link_to_route('admin.templates.rows', 'Edit Template Rows', $template->id, ['class' => 'btn btn-warning'])}}
		@endif
	</div>
	<div class="page-header">
		<h1>Edit Scorecard Template</h1>
	</div>

	{{Form::model($template, ['method' => 'PATCH', 'route' => ['admin.templates.update', $template->id], 'class' => 'form-horizontal'])}}
		@include('admin.templates.partials._form', ['buttonText' => 'Save Template'])
	{{Form::close()}}
@stop

@section('external_js')
	{{HTML::script('assets/js/admin/templates.js')}}
	<script>
		script_data.ajax_url = "{{URL::route('videos.check_url')}}";
	</script>
@stop
