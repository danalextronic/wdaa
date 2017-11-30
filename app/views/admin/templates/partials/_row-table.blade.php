<?php $label = "{$type}_rows_label"; ?>
<!-- sheepIt Form -->
<div class="panel panel-default" id="{{$type}}rows">
	<div class="panel-heading">
		<h3 class="panel-title">
			{{$template->$label}}
		</h3>
	</div>

	<div class="panel-body">
		<div class="row sc-header">
			<div class="col-sm-{{($template->use_ideas) ? 1 : 2}}">

			</div>

			<div class="col-sm-{{($template->use_ideas) ? 4 : 6}}">
				{{$type == 'test' ? 'Markers' : 'Overall' }}
			</div>

			@if($template->use_ideas)
				<div class="col-sm-4">
					Judging
				</div>
			@endif

			<div class="col-sm-3">
				{{($template->use_coef) ? 'Coefficient' : ''}}
			</div>
		</div>
		<div class="divider"></div>

		@include('admin/templates/partials/_row-item')
	</div>
	<!-- Controls -->
	<div id="{{$type}}rows_controls" class="panel-footer row-controls">
		<div id="{{$type}}rows_add">
			<a class="btn btn-success">
				<span>
					<i class="glyphicon glyphicon-plus"></i> 
					Add Row
				</span>
			</a>
		</div>
		<div id="{{$type}}rows_remove_last">
			<a class="btn btn-danger btn-small">
				<span>
					<i class="glyphicon glyphicon-minus"></i>
					Remove
				</span>
			</a>
		</div>
	</div>
	<!-- /Controls -->
</div>
<!-- /sheepIt Form -->
