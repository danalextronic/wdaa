<!-- Form template-->
<div id="{{$type}}rows_template">
	<div class="col-sm-{{($template->use_ideas) ? 1 : 2}}">
		<a id="{{$type}}rows_remove_current">
			<i class="glyphicon glyphicon-remove"></i>
		</a>
	</div>

	<div class="col-sm-{{($template->use_ideas) ? 4 : 6}}">
		@if($type == 'test' && $template->use_markers)
			<input id="{{$type}}rows_#index#_text" name="rows[{{$index}}][#index#][text]" type="hidden" />
			@include('admin/templates/partials/_markers')
		@else
			{{Form::text("rows[{$index}][#index#][text]", null, ['class' => 'form-control required', 'id' => "{$type}rows_#index#_text", 'placeholder' => ucfirst($type)])}}
		@endif
	</div>
	@if($template->use_ideas)
		<div class="col-sm-4">
			{{Form::text("rows[$index][#index#][ideas]", null, ['class' => 'form-control', 'id' => "{$type}rows_#index#_ideas"])}}
		</div>
	@endif

	<div class="col-sm-3">
		<input id="{{$type}}rows_#index#_id" name="rows[{{$index}}][#index#][id]" type="hidden" />
		@if(!$template->use_coef)
			<input id="{{$type}}rows_#index#_coef" name="rows[{{$index}}][#index#][coef]" type="hidden" value="1" />
		@else
		{{Form::text("rows[{$index}][#index#][coef]", '1.00', ['class' => 'form-control required number', 'id' => "{$type}rows_#index#_coef"])}}
		@endif
	</div>

	<div class="clearfix"></div>
</div>
<!-- /Form template-->

<!-- No forms template -->
<div id="{{$type}}rows_noforms_template">
	No {{$template->$label}}
</div>
<!-- /No forms template-->
