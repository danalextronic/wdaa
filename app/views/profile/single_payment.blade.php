@section('content')
	@if(!$orders->isEmpty())
		@include('profile/partials/_orders')
	@endif

	@if(!$coupons->isEmpty())
		@include('profile/partials/_coupons')
	@endif

	@include('partials/_payment', ['hide_user' => true])
@stop
