<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Cart Totals
		</h3>
	</div>
	<div class="panel-body prices">
		<p class="cart_subtotal {{(number_format($order->subtotal, 2) == number_format($order->total, 2)) ? 'hide' : 'strike-out'}}">
			Subtotal:
			<span class="checkoutSubTotal"><sup>$</sup><span class="price">{{number_format($order->subtotal, 2)}}</span></span>
		</p>

		<p class="cart_total">
			Total:
			<span class="checkoutTotal"><sup>$</sup><span class="price">{{number_format($order->total, 2)}}</span></span>
		</p>
	</div>
</div>
