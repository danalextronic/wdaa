@section('external_js')
	{{HTML::script('vendor/jquery-validation/jquery.validate.min.js')}}
	{{HTML::script('vendor/sheepit/jquery.sheepItPlugin.js')}}

	<script>
		var script_data = {
			'use_test_rows' : '{{$template->use_test_rows}}',
			'use_overall_rows' : '{{$template->use_overall_rows}}'
		};
		@if($template->use_markers)
		script_data.use_markers = true;
		@endif

		@if(isset($rows['T']) && !empty($rows['T']))
			script_data.test_rows = '{{json_encode($rows["T"], JSON_HEX_APOS)}}';
		@endif

		@if(isset($rows['O']) && !empty($rows['O']))
			script_data.overall_rows = '{{json_encode($rows["O"], JSON_HEX_APOS)}}';
		@endif
	</script>


	{{HTML::script('assets/js/admin/templates.js')}}

@stop

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.templates.index', 'Return to Template Listing', [], ['class' => 'btn btn-info'])}}
		{{link_to_route('admin.templates.edit', 'Edit Template', $template->id, ['class' => 'btn btn-success'])}}
	</div>

	<div class="page-header">
		<h1>
			Manage Scorecard Rows<br />
			<small>{{$template->name}}</small>
		</h1>
	</div>

	{{Form::open(['route' => ['admin.templates.submitRows', $template->id], 'id' => 'template_builder'])}}

		@if($template->use_test_rows)
			@include('admin/templates/partials/_row-table', ['type' => 'test', 'index' => 'T'])
		@endif

		<div class="divider"></div>

		@if($template->use_overall_rows)
			@include('admin/templates/partials/_row-table', ['type' => 'overall', 'index' => 'O'])
		@endif

		<div class="divider"></div>

		<div class="submitForm">
			{{Form::submit('Save Scorecard Rows', ['class' => 'btn btn-primary'])}}
		</div>

	{{Form::close()}}
@stop
