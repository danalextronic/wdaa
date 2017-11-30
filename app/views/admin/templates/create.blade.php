@include('partials/packages/chosen')
@include('partials/packages/wysiwyg')

@section('content')
	<div class="page-header">
		<h1>Create Scorecard Template</h1>
	</div>

	{{Form::open(['route' => 'admin.templates.store', 'class' => 'form-horizontal'])}}
		@include('admin.templates.partials._form')
	{{Form::close()}}
@stop

@section('external_js')
	{{HTML::script('assets/js/admin/templates.js')}}
	<script>
		script_data.ajax_url = "{{URL::route('videos.check_url')}}";
	</script>
@stop
