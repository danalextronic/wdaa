{{Form::open(['route' => 'coupons.add', 'id' => 'add_coupon_form', 'class' => 'form-horizontal'])}}
	<div class="form-group">
		<div class="col-sm-8 col-xs-6">
			{{Form::text('code', null, ['class' => 'form-control', 'placeholder' => 'Enter a Coupon Code', 'id' => 'couponCode'])}}
		</div>
		<div class="col-sm-4">
			<button type="submit" class="btn btn-success">
				<i class="glyphicon glyphicon-plus"></i> Add Coupon
			</button>
		</div>
	</div>
{{Form::close()}}
