@include('partials/packages/datatables')

@section('content')
	<div class="page-header">
		<h1>All Orders</h1>
	</div>

	@unless($orders->isEmpty())
		<p class="lead">
			<span class="text-danger">RED = Incomplete(in the cart)</span><br />
			<span class="text-success">GREEN = Complete(ready for completion)</span>
		</p>
	@endunless

	<div class="table-responsive">
		@include('admin/orders/partials/_table', ['datatables' => true])
	</div>
@stop
