<ul class="nav nav-tabs verification-tabs">
	@foreach($available_tabs as $name => $count)
		<li{{($name == $current_tab) ? ' class="active"' : ''}}>
			<a href="{{URL::route('verification.dashboard')}}?tab={{$name}}">
				{{ucwords($name)}}
				<span class="badge">{{$count}}</span>
			</a>
		</li>
	@endforeach
</ul>
