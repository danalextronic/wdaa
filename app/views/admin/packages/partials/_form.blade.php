<div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
	{{Form::label('name', 'Name', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::text('name', null, ['class' => 'form-control'])}}
		@if($errors->has('name'))
			<span class="help-block">
				{{$errors->first('name')}}
			</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('cost') ? 'has-error' : ''}}">
	{{Form::label('cost', 'Cost', ['class' => 'control-label col-sm-2'])}}
	<div class="input-group col-sm-2" style="padding-left:12px">
		<span class="input-group-addon">$</span>
			{{Form::text('cost', (isset($package->cost) ? intval($package->cost) : null), ['class' => 'form-control text-right'])}}
		<span class="input-group-addon">.00</span>
	</div>
	@if($errors->has('cost'))
		<div class="help-block" style="margin-left:150px">
			{{$errors->first('cost')}}
		</div>
	@endif
</div>

<div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
	{{Form::label('description', 'Description', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::textarea('description', null, ['class' => 'form-control wysiwyg'])}}
		@if($errors->has('description'))
			<span class="help-block">
				{{$errors->first('description')}}
			</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('templates') ? 'has-error' : ''}}">
	{{Form::label('templates', 'Templates', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::select('templates[]', $templates, (isset($current_templates) ? $current_templates : null), ['class' => 'chzn-select', 'multiple' => 'multiple', 'data-placeholder' => 'Select Scorecard Templates', 'style' => 'width:600px'])}}
		@if($errors->has('templates'))
			<span class="help-block">
				{{$errors->first('templates')}}
			</span>
		@else
			<span class="help-block">
				<em>Templates can be assigned to multiple packages</em>
			</span>
		@endif
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{Form::submit((isset($buttonText) ? $buttonText : 'Create Package'), ['class' => 'btn btn-primary'])}}
	</div>
</div>
