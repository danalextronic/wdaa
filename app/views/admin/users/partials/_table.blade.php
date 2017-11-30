<table class="table table-bordered table-striped datatable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Full Name</th>
			<th>Email Address</th>
			@if(!isset($hide_roles) || $hide_roles === FALSE)
				<th>User Roles</th>
			@endif
			<th>Last Updated</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@if(empty($users))
			<tr class="danger text-center">
				<td colspan="7">No Users Found!</td>
			</tr>
		@else
			@foreach($users as $u)
				<tr>
					<td>{{$u->id}}</td>
					<td>{{$u->username}}</td>
					<td>
						{{link_to_route('profile', $u->display_name, $u->username, ['target' => '_blank'])}}
						({{link_to_route('profile.settings', 'Edit', $u->username, ['target' => '_blank'])}})
					</td>
					<td>{{HTML::mailto($u->email)}}</td>
					@if(!isset($hide_roles) || $hide_roles === FALSE)
						<td>
							{{implode(", ", array_map(function($role) {return HTML::linkRoute('admin.roles.show', $role['name'], $role['id']); }, $u->roles->toArray()))}}
						</td>
					@endif
					<td>{{$u->updated_at->diffForHumans()}}</td>
					<td>
						<a class="btn btn-success" target="_blank" href="{{URL::route('profile.settings', $u->username)}}">
							<i class="glyphicon glyphicon-edit"></i>
							Edit
						</a>
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
