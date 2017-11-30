

@section('content')
{{HTML::script('assets/js/status.js')}}
{{HTML::script('assets/js/verification.js')}}

	<div class="page-header">
		<ul class="student-status">
			<!--<li{{($cur_status == 'inprogress') ? ' 		class="active"' : ''}}>{{link_to_route('admin.status.inprogress', 'In Progress')}}</li>
			<li{{($cur_status == 'pending') ? ' 		class="active"' : ''}}>{{link_to_route('admin.status.pending', 'Pending')}}</li>
			<li{{($cur_status == 'satisfactory') ? ' 	class="active"' : ''}}>{{link_to_route('admin.status.satisfactory', 'Satisfactory')}}</li>
			<li{{($cur_status == 'unsatisfactory') ? ' 	class="active"' : ''}}>{{link_to_route('admin.status.unsatisfactory', 'Unsatisfactory')}}</li>
			<li{{($cur_status == 'completed') ? ' 	    class="active"' : ''}}>{{link_to_route('admin.status.completed', 'Completed')}}</li>
			<li class="ajaxtesting"><a href="javascript:;">Ajax Testing</a></li>-->

			<li class="active inprogress-st">
				<a href="javascript:;">In Progress</a>
			</li>
			<li {{($cur_status == 'pending') ? ' 		class="active pending-st"' : 'class="pending-st"'}}>
				<a href="javascript:;">Pending</a>
			</li>
			<li {{($cur_status == 'satisfactory') ? ' 	class="active satisfactory-st"' : 'class="satisfactory-st"'}}>
				<a href="javascript:;">Satisfactory</a>
			</li>
			<li {{($cur_status == 'unsatisfactory') ? ' 	class="active unsatisfactory-st"' : 'class="unsatisfactory-st"'}}>
				<a href="javascript:;">Unsatisfactory</a>
			</li>
			<li {{($cur_status == 'completed') ? ' 	    class="active completed-st"' : 'class="completed-st"'}}>
				<a href="javascript:;">Completed</a>
			</li>
			
		</ul> 
	</div>

	@unless(empty($students))
		@include('admin.status.partials._student-list')
	@endunless
@stop
