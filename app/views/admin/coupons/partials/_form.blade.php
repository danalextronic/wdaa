<div class="form-group {{$errors->has('code') ? 'has-error' : ''}}">
	{{Form::label('code', 'Coupon Code', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::text('code', null, ['class' => 'form-control'])}}
		<span class="help-block">
			@if($errors->has('code'))
				{{$errors->first('code')}}
			@else
				This is the coupon code that users will enter in order to receive their discount
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
	{{Form::label('name', 'Coupon Name', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::text('name', null, ['class' => 'form-control'])}}
		@if($errors->has('name'))
			<span class="help-block">{{$errors->first('name')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
	{{Form::label('description', 'Coupon Description', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::textarea('description', null, ['class' => 'form-control wysiwyg'])}}
		<span class="help-block">
			@if($errors->has('description'))
				{{$errors->first('description')}}
			@else
				Provide a short description about the coupon for other admins to see
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('expired_at') ? 'has-error' : ''}}">
	{{Form::label('expired_at', 'Expiration Date', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-4">
		{{Form::text('expired_at', (isset($coupon->expired_at)) ? $coupon->expired_at->format('m/d/Y') : '', ['class' => 'form-control datepicker'])}}
		<span class="help-block">
			@if($errors->has('expired_at'))
				{{$errors->first('expired_at')}}
			@else
				Once this date passes, this coupon will no longer be valid
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('package_id') ? 'has-error' : ''}}">
	{{Form::label('package_id', 'Package', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-6">
		{{Form::select('package_id', ['' => '--'] + $packages, null, ['class' => 'form-control'])}}
		<span class="help-block">
			@if($errors->has('package_id'))
				{{$errors->first('package_id')}}
			@else
				Set this to restrict the package that can use this coupon
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('user_id') ? 'has-error' : ''}}">
	{{Form::label('user_id', 'User', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-6">
		{{Form::text('user_id', (isset($coupon->owner->display_name)) ? $coupon->owner->id . ' - ' . $coupon->owner->display_name : '', ['class' => 'form-control'])}}
		<span class="help-block">
			@if($errors->has('user_id'))
				{{$errors->first('user_id')}}
			@else
				Restrict the user that can use this coupon
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('discount') ? 'has-error' : ''}}">
	{{Form::label('discount', 'Discount', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-3">
		{{Form::text('discount', null, ['class' => 'form-control'])}}
			@if($errors->has('discount'))
				<span class="help-block">
					{{$errors->first('discount')}}
				</span>
			@endif
		</span>
	</div>
</div>

<div class="form-group {{$errors->has('discount_type') ? 'has-error' : ''}}">
	{{Form::label('discount_type', 'Discount Type', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-3">
		{{Form::select('discount_type', ['' => '--'] + $discount_types, null, ['class' => 'form-control'])}}
			@if($errors->has('discount_type'))
				<span class="help-block">
					{{$errors->first('discount_type')}}
				</span>
			@endif
		</span>
	</div>
</div>

<div class="form-group">
	{{Form::label('active', 'Active?', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-3">
		<label class="checkbox">
			{{Form::hidden('active', 0)}}
			{{Form::checkbox('active', 1, true)}}
		</label>
	</div>
</div>

<div class="form-group">
	{{Form::label('unique', 'Unique?', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		<label class="checkbox">
			{{Form::hidden('unique', 0)}}
			{{Form::checkbox('unique', 1, true)}}
		</label>
		<span class="help-block">
			If this is checked, the coupon may only be used by any user once
		</span>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{Form::submit((isset($buttonText) ? $buttonText : 'Create Coupon'), ['class' => 'btn btn-primary'])}}
	</div>
</div>
