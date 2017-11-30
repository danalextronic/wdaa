@extends('layouts.master')
@include('partials/packages/datatables')

@section('title')
	@lang('site.master') Dashboard |
@stop

@section('external_css')
	{{HTML::style('assets/css/master.css')}}
@stop

@section('content')
	<div class="page-header">
		<h1>@lang('site.master') Dashboard</h1>
	</div>

	@if($packages->isEmpty())
		<div class="alert alert-danger">
			No Scorecards Avaiable!
		</div>
	@elseif($packages->count() == 1)
		@include('scorecards/master/list', ['scorecards' => $packages->first()->scorecards])
	@else
		@include('scorecards/master/accordion-list')
	@endif
@stop
