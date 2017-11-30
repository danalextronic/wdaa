@unless($orders->isEmpty())
	@section('external_css')
		{{HTML::style('assets/css/verification.css')}}
	@stop
@endunless

@section('content')
	@if($orders->isEmpty())
		<div class="alert alert-danger">
			There are no scorecards available for evaluation
		</div>
	@else
		<h3>Scorecards</h3>
		<p class="text-info">Please choose a scorecard from the list below to begin your evaluation</p>

		@if($orders->count() == 1)
			@include('scorecards/learner/wrapper', ['item' => $orders->first()])
		@else
			@include('scorecards/learner/accordion-wrapper')
		@endif
	@endif
@stop
