<!DOCTYPE html>
<html>
<head>
	<title>
        @section('title')
        @show

		@if(isset($title))
			{{$title}} - 
		@endif
		{{Config::get('site.site_name')}}
	</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta_tags')

     {{HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css')}}
     {{HTML::style('vendor/bootstrap/dist/css/bootstrap.min.css')}}
     {{HTML::style('vendor/font-awesome/css/font-awesome.css')}}
     {{HTML::style('vendor/fancybox/source/jquery.fancybox.css')}}
     {{HTML::style('vendor/jquery-ui/themes/excite-bike/jquery-ui.css')}}
     {{HTML::style('vendor/jquery-ui/themes/excite-bike/jquery.ui.theme.css')}}
     {{HTML::style('assets/css/main.css')}}
     @section('external_css')
     @show


     @section('internal_css')
     @show

     @if(isset($styles))
     	@foreach($styles as $link)
     		{{HTML::style($link)}}
     	@endforeach
     @endif

    {{HTML::script('vendor/jquery/jquery.min.js')}}
    {{HTML::script('vendor/jquery-ui/ui/minified/jquery-ui.min.js')}}
    {{HTML::script('vendor/bootstrap/dist/js/bootstrap.min.js')}}
    {{HTML::script('vendor/fancybox/source/jquery.fancybox.pack.js')}}

     @section('header_scripts')
     @show
     
</head>
<body>
    @if(!isset($no_wrapper) || $no_wrapper === false)
	<div id="wrapper">
		@include('layouts/partials/_nav')
    @endif
