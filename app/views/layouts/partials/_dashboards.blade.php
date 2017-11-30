<li class="outlined-nav-item {{(count($dashboards) > 0) ? 'dropdown' : ''}}">
	@if(count($dashboards) > 1)
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<i class="glyphicon glyphicon-home"></i>
			Admin Dashboards <span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			@foreach($dashboards as $dashboard)
				<li>
					<a href="{{URL::route($dashboard['route'])}}">
						<i class="glyphicon glyphicon-list-alt"></i>
						{{$dashboard['name']}}
					</a>
				</li> 
			@endforeach
			<li>
				<a href="https://judge.wdaa.org/admin/status/inprogress"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Status</a>
			</li>
		</ul>
	@else
		<a href="{{URL::route(current($dashboards)['route'])}}">
			<i class="glyphicon glyphicon-home"></i>
			{{current($dashboards)['name']}}
		</a>
	@endif
</li>
