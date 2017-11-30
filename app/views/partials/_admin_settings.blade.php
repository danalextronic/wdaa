<div class="form-group">
	<div class="col-md-offset-2 col-md-10">
		<div class="well">
			<h4>Admin Settings</h4>

			<div class="form-group">
				{{Form::label('roles', 'User Roles', ['class' => 'control-label col-sm-2'])}}
				<div class="col-sm-10">
					{{Form::select('roles[]', $role_list, $current_roles, ['class' => 'chzn-select', 'data-placeholder' => 'Select Role', 'multiple' => 'multiple', 'style' => 'width:300px'])}}
				</div>
			</div>
		</div>
	</div>
</div>
