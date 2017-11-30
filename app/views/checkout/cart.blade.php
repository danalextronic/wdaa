@extends('layouts.master')

@section('title')
	Your Cart |
@stop

@section('external_css')
	{{HTML::style('assets/css/checkout.css')}}
@stop

@section('meta_tags')
	<meta name="removeItem" content="{{URL::route('order.remove')}}" />
	<meta name="addCoupon" content="{{URL::route('coupons.add')}}" />
	<meta name="removeCoupon" content="{{URL::route('coupons.remove')}}" />
	<meta name="stripe_key" content="{{Config::get('stripe.public_key')}}" />
@stop

@section('external_js')
	{{HTML::script('vendor/js/jquery.creditCardValidator.js')}}
	{{HTML::script('vendor/jquery.maskedinput/jquery.maskedinput.min.js')}}
	{{HTML::script('https://js.stripe.com/v2/')}}
	{{HTML::script('assets/js/cart.js')}}
	{{HTML::script('assets/js/localization.js')}}
@stop

@section('content')
	<div class="page-header">
		<h1>Your Cart</h1>
	</div>

	@if($order->items->isEmpty())
		<div class="alert alert-danger text-center">
			There are no items in your cart!
		</div>
	@else

<div class="row cartItems">
	<div class="col-sm-8 items">
		@include('checkout/partials/_item-table')
	</div>

	<div class="col-sm-4 totals">
		@include('checkout/partials/_totals')
	</div>
</div>
		<div class="row cartTotals">
			<div class="col-sm-8 coupons">
				@include('checkout/partials/coupons/_wrapper')
			</div>

		</div>

		<div class="divider"></div>

		@include('checkout/partials/_billing-form')

	@endif
@stop
