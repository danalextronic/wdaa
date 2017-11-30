<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			@if(count($order->coupons) == 0)
				Have a Coupon Code?
			@else
				Applied Coupon(s):
			@endif
		</h3>
	</div>
	<div class="panel-body">
		@if(count($order->coupons) > 0)
			@foreach($order->coupons as $c)
				@include('checkout/partials/coupons/_list-item')
			@endforeach
		@else
			@include('checkout/partials/coupons/_form')
		@endif
	</div>
</div>
