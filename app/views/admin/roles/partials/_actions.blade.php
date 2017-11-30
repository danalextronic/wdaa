{{Form::open(['method' => 'DELETE', 'route' => ['admin.roles.destroy', $role->id], 'class' => 'form-inline'])}}
	<a class="btn btn-success" href="{{URL::route('admin.roles.edit', $role->id)}}">
		<i class="glyphicon glyphicon-edit"></i>
		Edit
	</a>
	<button type="submit" class="btn btn-danger delete-btn">
		<i class="glyphicon glyphicon-trash"></i>
		Delete
	</button>
{{Form::close()}}
