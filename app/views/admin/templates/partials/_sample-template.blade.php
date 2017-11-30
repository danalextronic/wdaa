<div class="pull-right">
	{{link_to_route('admin.templates.rows', 'Edit Rows', $template->id, ['class' => 'btn btn-info'])}}
</div>

<div class="page-header">
	<h2>Sample Template</h2>
</div>

@include('admin/templates/partials/_sample', ['type' => 'T'])

<div class="divider"></div>

@include('admin/templates/partials/_sample', ['type' => 'O'])
