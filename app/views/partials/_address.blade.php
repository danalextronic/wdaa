<div class="form-group {{$errors->has('address') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('address', 'Address', ['class' => ' control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-9">
			{{Form::text('address', null, ['class' => 'form-control'])}}
			@if($errors->has('address'))
				<span class="help-block">{{$errors->first('address')}}</span>
			@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-3">
			{{Form::label('address_2', 'Apt/Suite #', ['class' => ' control-label'])}}
		</div>

		<div class="col-sm-9">
			{{Form::text('address_2', null, ['class' => 'form-control'])}}
		</div>
	</div>

	<div class="form-group {{$errors->has('city') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('city', 'City', ['class' => ' control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-9">
			{{Form::text('city', null, ['class' => 'form-control'])}}
			@if($errors->has('city'))
				<span class="help-block">{{$errors->first('city')}}</span>
			@endif
		</div>
	</div>

	<div class="form-group {{$errors->has('country') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('country', 'Country', ['class' => ' control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-9">
			{{Form::select('country', Config::get('site.countries'), null, ['class' => 'form-control'])}}
			@if($errors->has('country'))
				<span class="help-block">{{$errors->first('country')}}</span>
			@endif
		</div>
	</div>

	<div class="form-group {{$errors->has('state') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('state', 'State', ['class' => ' control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-9">
			{{Form::selectState('state', null, ['class' => 'form-control'])}}
			@if($errors->has('state'))
				<span class="help-block">{{$errors->first('state')}}</span>
			@endif
		</div>
	</div>

	<div class="form-group {{$errors->has('zipcode') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('zipcode', 'Zip Code', ['class' => 'control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-3">
			{{Form::text('zipcode', null, ['class' => 'form-control'])}}
			@if($errors->has('zipcode'))
				<span class="help-block">{{$errors->first('zipcode')}}</span>
			@endif
		</div>
	</div>

	<div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
		<div class="col-sm-3">
			{{Form::label('phone', 'Phone Number', ['class' => ' control-label'])}}
			<span class="required_marker">*</span>
		</div>

		<div class="col-sm-3">
			{{Form::text('phone', null, ['class' => 'form-control'])}}
			@if($errors->has('phone'))
				<span class="help-block">{{$errors->first('phone')}}</span>
			@endif
		</div>
	</div>
