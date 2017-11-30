<div class="panel panel-body">
	<div class="page-header">
		<h1>{{$name}} Verifications</h1>
	</div>

	<div class="container-narrow">
		@include('scorecards.verifications.table', ['tab' => $tab, 'orders' => $orders])
		{{$orders->appends(Request::only('tab'))->links()}}
	</div>
</div>
