@if(!isset($no_wrapper) || $no_wrapper === FALSE)
</div>

<footer>
	<div class="container">
		<div class="pull-left">
			{{link_to(Config::get('site.contact_link'), 'Support', ['id' => 'contact_link', 'data-fancybox-type' => 'iframe'])}}
		</div>

		<div class="pull-right">
			Copyright &copy; {{date("Y")}}
		</div>
	</div>
</footer>
@endif

<script>
	var script_data = {};
</script>


{{HTML::script('assets/js/global.js')}}
@if(isset($scripts))
	@foreach($scripts as $src)
		{{HTML::script($src)}}
	@endforeach
@endif

@section('external_js')
@show

@if(!Auth::check())
	<script>
		$("a#login_header_link").fancybox({
			scrolling: 'no',
			autoSize: false,
			width:992,
			height: 350,
			padding: 0
		});	
	</script>
@endif

<script>
	$("#contact_link").fancybox({padding: 0});
</script>

@section('internal_js')
@show


</body>
</html>
