@section('external_css')
	{{HTML::style('vendor/chosen/chosen.css')}}
@stop

@section('external_js')
	@parent
	{{HTML::script('vendor/chosen/chosen.jquery.min.js')}}
@stop

@section('internal_js')
	@parent
	<script>
		$(document).ready(function() {
			$(".chzn-select").chosen();
		});
	</script>
@stop
