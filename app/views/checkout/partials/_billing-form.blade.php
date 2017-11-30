<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Billing Information
		</h3>
	</div>
	<div class="panel-body">
		{{Form::model(Auth::user(), ['route' => 'cart.checkout', 'class' => 'form-horizontal', 'id' => 'paymentForm'])}}
			<div class="alert alert-danger hide text-center" id="paymentErrors"></div>

			<p class="lead">
				Please provide your payment information below. If any of your billing information below is incorrect, please update it here
			</p>

			<p class="lead">
				<span class="required_marker">*</span> = required field
			</p>

			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('address', 'Address', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-9">
						{{Form::text('address', null, ['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					{{Form::label('address2', 'Apt/Suite #', ['class' => 'col-sm-3 form-label'])}}
					<div class="col-sm-4">
						{{Form::text('address2', null, ['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('city', 'City', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-9">
						{{Form::text('city', null, ['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('country', 'Country', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-5">
						{{Form::select('country', Config::get('site.countries'), null, ['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('state', 'State', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-5">
						{{Form::selectState('state', null, ['class' => 'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('zipcode', 'Zip Code', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-3">
						{{Form::text('zipcode', null, ['class' => 'form-control', 'maxlength' => '5'])}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-3">
						{{Form::label('phone', 'Phone #', ['class' => 'form-label'])}}
						<span class="required_marker">*</span>
					</div>
					<div class="col-sm-4">
						{{Form::text('phone', null, ['class' => 'form-control phone'])}}
					</div>
				</div>
			</div>

			<div class="col-sm-6 cardInformation {{($order->total == 0) ? 'hide' : ''}}">
				<div class="form-group">
					{{Form::label(null, 'Card Number', ['class' => 'control-label col-sm-3'])}}
					<div class="col-md-8 col-sm-8">
						{{Form::text(null, null, ['class' => 'form-control', 'id' => 'card_number'])}}
					</div>
				</div>
				
				<div class="form-group">
					{{Form::label(null, 'Month', ['class' => 'control-label col-sm-3'])}}
					<div class="col-md-5 col-sm-5">
						{{Form::selectMonth(null, null, ['class' => 'form-control', 'id' => 'exp_month'])}}
					</div>
				</div>

				<div class="form-group">
					{{Form::label(null, 'Year', ['class' => 'control-label col-sm-3'])}}
					<div class="col-md-5 col-sm-5">
						{{Form::selectYear(null, date("Y"), date("Y") + 10, null, ['class' => 'form-control', 'id' => 'exp_year'])}}
					</div>
				</div>

				<div class="form-group">
					{{Form::label(null, 'CVC', ['class' => 'control-label col-sm-3'])}}
					<div class="col-md-3 col-sm-3">
						{{Form::text(null, null, ['class' => 'form-control', 'id' => 'cvc', 'maxlength' => '4'])}}
					</div>
				</div>

				<div class="col-md-offset-2 col-sm-offset-1">
					<ul class="cards">
						<li class="mastercard"></li>
						<li class="visa"></li>
						<li class="discover"></li>
						<li class="amex"></li>
					</ul>
				</div>
			</div>

			<div class="clearfix"></div>
			<div class="divider"></div>

			<div class="submitForm">
				{{Form::submit('Complete Checkout', ['class' => 'btn btn-primary btn-lg'])}}
			</div>

		{{Form::close()}}
	</div>
</div>
