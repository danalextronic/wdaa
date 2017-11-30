<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Recent User Signups
		</h3>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Signup Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $u)
				<tr>
					<td>{{$u->id}}</td>
					<td>{{link_to_route('profile', $u->display_name, $u->username)}}</td>
					<td>{{HTML::mailto($u->email)}}</td>
					<td>{{$u->created_at->format('m/d/Y \a\t g:iA')}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="panel-footer">
		<div class="pull-right">
			{{link_to_route('admin.users.index', 'More Users', [], ['class' => 'btn btn-info'])}}
		</div>
		<div class="clearfix"></div>
	</div>
</div>
