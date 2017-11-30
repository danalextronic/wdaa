<div class="row coupon-item">
	<div class="col-sm-8">
		<h4>{{$c->coupon->name}}</h4>
		<p>
			{{$c->coupon->discountString()}} off
			(${{$c->discount}})
		</p>
	</div>

	<div class="col-sm-4">
		<button data-coupon-id="{{$c->id}}" class="btn btn-warning deleteCoupon">
			<i class="glyphicon glyphicon-remove"></i> Delete Coupon
		</button>
	</div>
</div>
