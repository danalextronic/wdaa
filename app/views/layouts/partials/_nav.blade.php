
<div class="header">

<nav class="navbar navbar-default site-navbar">
	<div class="container">
		<div class="navbar-header header-logo">
			<a href="/">
				{{Config::get('site.header_image')}}
			</a>

			 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav nav-pills navbar-right">
				@if(Auth::check())

					@if($incomplete_items = Auth::user()->getIncompleteItems())
						<li class="outlined-nav-item">
							<a href="{{URL::route('cart')}}">
								<i class="glyphicon glyphicon-shopping-cart"></i>
								Cart
								<span class="badge badge-info" id="numCartItems">{{$incomplete_items}}</span>
							</a>
						</li>
					@endif

					{{buildDashboardList()}}

					<li>
						<a href="{{URL::route('profile', Auth::user()->username)}}">
							 My Dashboard
						</a>
						<!--<a href="#" class="dropdown-toggle avatar-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-user"></i> Admin Dashboard<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{URL::route('profile', Auth::user()->username)}}">
									 Admin Dashboard
								</a>
							</li>
							<li>
								{{link_to_route('admin.status.inprogress', 'Status')}}
							</li>
						</ul>-->
					</li>
					<li class="dropdown outlined-nav-item">
						<a href="#" class="dropdown-toggle avatar-toggle" data-toggle="dropdown">
							{{Auth::user()->display_name}} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{URL::route('profile.settings', Auth::user()->username)}}">
									<i class="glyphicon glyphicon-cog"></i> Settings
								</a>
							</li>
							<li>
								<a href="{{URL::route('profile.billing', Auth::user()->username)}}">
									<i class="glyphicon glyphicon-list-alt"></i> Billing
								</a>
							</li>
							<li>
								<a href="{{URL::route('logout')}}">
									<i class="glyphicon glyphicon-log-out"></i> Logout
								</a>
							</li>
						</ul>
					</li>
				@else
					<li class="outlined-nav-item">
						{{link_to_route('login', 'Login', ['modal' => true], ['id' => 'login_header_link', 'data-fancybox-type' => 'iframe'])}}
					</li>

					<li class="outlined-nav-item">
						{{link_to_route('signup', 'Signup')}}
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
</div>
