<div class="form-group {{$errors->has('name') ? ' has-error ' : ''}}">
	{{Form::label('name', 'Template Name', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::text('name', null, ['class' => 'form-control'])}}
		@if($errors->has('name'))
			<span class="help-block">
				{{$errors->first('name')}}
			</span>
		@endif
	</div>
</div>

<div class="form-group {{$errors->has('packages') ? ' has-error ' : ''}}">
	{{Form::label('packages', 'Packages', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::select('packages[]', $packages, (isset($current_packages) ? $current_packages : null), ['class' => 'form-control chzn-select', 'multiple' => 'multiple', 'data-placeholder' => 'Select Packages'])}}
		@if($errors->has('packages'))
			<span class="help-block">
				{{$errors->first('packages')}}
			</span>
		@endif
	</div>
</div>

<div class="form-group">
	{{Form::label('description', 'Description', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		{{Form::textarea('description', null, ['class' => 'form-control wysiwyg'])}}
	</div>
</div>

<div class="form-group">
	{{Form::label('type', 'Type?', ['class' => 'control-label col-sm-2'])}}
	<div class="col-sm-10">
		<label class="radio-inline">
			{{Form::radio('type', 'R', false, ['id' => 'type-R'])}}
			Drag and Drop
		</label>

		<label class="radio-inline">
			{{Form::radio('type', 'S', true, ['id' => 'type-S'])}}
			Scored
		</label>
	</div>
</div>

<div class="divider"></div>

<div id="type-R-fields" style="display:{{(isset($template->type) && $template->type == 'R') ? 'block' : 'none'}}"></div><!-- End Ranked Settings -->
	
<div id="type-S-fields" style="display:{{(!isset($template->type) || $template->type == 'S') ? 'block' : 'none'}}">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Scored Options</h3>
		</div>
		<div class="panel-body template-options">
			<div class="form-group">
				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_test_rows', 0)}}
						{{Form::checkbox('use_test_rows', 1, true)}}
						<label>Use Test Rows?</label>
					</label>
				</div>
				<div class="col-sm-8">
					{{Form::text('test_rows_label', 'Test Rows', ['class' => 'form-control', 'placeholder' => 'Test Rows Label'])}}
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_overall_rows', 0)}}
						{{Form::checkbox('use_overall_rows', 1, true)}}
						<label>Use Overall Rows?</label>
					</label>
				</div>
				<div class="col-sm-8">
					{{Form::text('overall_rows_label', 'Overall Rows', ['class' => 'form-control', 'placeholder' => 'Overall Rows Label'])}}
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_markers', 0)}}
						{{Form::checkbox('use_markers', 1, true)}}
						<label>Use Row Markers?</label>
					</label>
				</div>

				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_errors', 0)}}
						{{Form::checkbox('use_errors', 1, true)}}
						<label>Use Row Errors?</label>
					</label>
				</div>

				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_coef', 0)}}
						{{Form::checkbox('use_coef', 1, true)}}
						<label>Use Row Coefficients?</label>
					</label>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_ideas', 0)}}
						{{Form::checkbox('use_ideas', 1, true)}}
						<label>Use Row Ideas?</label>
					</label>
				</div>

				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('manual_coef', 0)}}
						{{Form::checkbox('manual_coef', 1)}}
						<label>Manual Coefficients?</label>
					</label>
				</div>

				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_manual_score', 0)}}
						{{Form::checkbox('use_manual_score', 1)}}
						<label>Allow Manual Scoring?</label>
					</label>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('scoring_precision', 'Scoring Precision', ['class' => 'control-label col-sm-3', 'style' => 'text-align:left'])}}
				<div class="col-sm-9">
					{{Form::select('scoring_precision', ['' => '--'] + $scoring_precision, ".5", ['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_row_comment', 0)}}
						{{Form::checkbox('use_row_comment', 1, true)}}
						<label>Row Comment?</label>
					</label>
				</div>

				<div class="col-sm-4">
					<label class="checkbox-inline">
						{{Form::hidden('use_global_comment', 0)}}
						{{Form::checkbox('use_global_comment', 1, true)}}
						<label>Global Comment?</label>
					</label>
				</div>
			</div>

		</div><!-- /.panel-body -->
	</div><!-- /.panel -->
</div><!-- End Scored Settings -->

<div class="divider"></div>

@include('admin/templates/partials/_choose-video')

<div class="form-group">
	<div class="col-sm-offset-1 col-sm-11">
		{{Form::submit((isset($buttonText) ? $buttonText : 'Create Template'), ['class' => 'btn btn-primary'])}}
	</div>
</div>
