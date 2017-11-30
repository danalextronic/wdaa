<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
	{{Form::label('name', 'Role Name', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::text('name', null, ['class' => 'form-control'])}}
		@if($errors->has('name'))
			<span class="help-block">{{$errors->first('name')}}</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('level') ? 'has-error' : ''}}">
	{{Form::label('level', 'Role Level', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::select('level', ['' => '--'] + array_reverse(array_combine(range(-1, 10), range(-1, 10)), true), null, ['class' => 'form-control'])}}
		@if($errors->has('level'))
			<span class="help-block">{{$errors->first('level')}}</span>
		@endif
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{Form::submit((isset($buttonText) ? $buttonText : 'Create Role'), ['class' => 'btn btn-primary'])}}
	</div>
</div>
