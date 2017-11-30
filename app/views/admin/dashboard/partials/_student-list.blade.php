<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Current Students
		</h3>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>Student Name</th>
				<th>Email</th>
				<th>Package</th>
				<th>Progress</th>
			</tr>
		</thead>
		<tbody>
			@foreach($students as $s)
				<tr>
					<td>
						{{link_to_route('profile', $s->display_name, $s->username)}}
					</td>
					
					<td>
						{{HTML::mailto($s->email)}}
					</td>

					<td>
						{{link_to_route('admin.packages.show', $s->package_name, $s->package_id)}}
					</td>

					<td>
						<div class="progress">
							<div class="progress-bar" style="width: {{$s->percentage}}%;"></div>
						</div>
						<p class="lead">
							{{$s->complete}} of {{$s->total}} tests completed
						</p>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
