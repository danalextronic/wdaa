@section('external_css')
	{{HTML::style('vendor/datatables/media/css/jquery.dataTables.css')}}
	{{HTML::style('vendor/datatables-bootstrap3/BS3/assets/css/datatables.css')}}
@stop

@section('external_js')
	{{HTML::script('vendor/datatables/media/js/jquery.dataTables.js')}}
	{{HTML::script('vendor/datatables-bootstrap3/BS3/assets/js/datatables.js')}}
@stop

@section('internal_js')
	<script>
		$(document).ready(function() {
			$(".datatable").dataTable({
				"sPaginationType" : "bs_normal"
			});
		});
	</script>
@stop
