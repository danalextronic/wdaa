@if(isset($is_settings_page) && $is_settings_page === true && !Auth::user()->isAdmin())
	<div class="form-group {{$errors->has('current_password') ? ' has-error ' : ''}}">
		{{Form::label('current_password', 'Current Password', ['class' => 'control-label col-sm-2'])}}
		<div class="col-sm-10">
			{{Form::password('current_password', ['class' => 'form-control'])}}
			@if($errors->has('current_password'))
				<span class="help-block">
					{{$errors->first('current_password')}}
				</span>
			@endif
		</div>
	</div>
@endif

<div class="form-group {{$errors->has('password') ? ' has-error ' : ''}}">
	{{Form::label('password', 'New Password', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::password('password', ['class' => 'form-control'])}}
		@if($errors->has('password'))
			<span class="help-block">
				{{$errors->first('password')}}
			</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('password_confirmation') ? ' has-error ' : ''}}">
	{{Form::label('password_confirmation', 'Confirm New Password', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::password('password_confirmation', ['class' => 'form-control'])}}

		@if($errors->has('password_confirmation'))
			<span class="help-block">
				{{$errors->first('password_confirmation')}}
			</span>
		@endif
	</div>
</div>
