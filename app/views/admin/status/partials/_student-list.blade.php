@include('partials/packages/datatables')

<div class="panel panel-default">
	<div class="panel-heading mb10">
		<h3 class="panel-title">
			Current Status
		</h3> 
	</div>

	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th>Student Name</th>
				<th>Email</th>
				<th>Package</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($students as $s)
				<tr>
					<td>
						@if ($cur_status == 'inprogress' )
							{{link_to_route('profile', $s->display_name, $s->username)}}
						@else
							{{link_to_route('verification.single', $s->display_name, $s->ordersid)}}
						@endif
					</td>
					
					<td>
						{{HTML::mailto($s->email)}}
					</td>

					<td>
						{{link_to_route('admin.packages.show', $s->package_name, $s->package_id)}}
					</td>
					
					<td>
						
						@if ($completed == 1 || $completed == '1' || $s->vrycompleted == 1 || $s->vrycompleted == '1' )
							{{$s->status }}
						@elseif( $cur_status == 'satisfactory' || $cur_status == 'unsatisfactory' )
							<input class="btn btn-success verifycompleted" type="button" data-order-id="{{$s->ordersid}}" data-verification-id="{{$s->scorecard_verify_id}}" value="Completed">
						@else
							<div class="progress">
								<div class="progress-bar" style="width: {{$s->percentage}}%;"></div>
							</div>
							<p class="lead">
								{{$s->complete}} of {{$s->total}} tests completed
							</p>
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>