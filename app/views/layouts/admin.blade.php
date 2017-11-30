@include('layouts.partials._head', ['styles' => ['/assets/css/admin.css']])
<div class="container main-layout">
	<div class="col-sm-3 admin-sidebar">
		<div class="well">
			<ul class="nav nav-pills nav-stacked">
				<li>
					<a href="#" {{(!empty($current_page) && $current_page != 'status' ) ? ' class="toggle"' : ' class="no-toggle"'}}>Dashboard</a>
					<ul class="nav nav-pills nav-toggle {{(empty($current_page) ||  $current_page == 'status' ) ? 'open' : ''}}">
						<li{{empty($current_page) ? ' class="active"' : ''}}>{{link_to_route('admin.dashboard', 'Dashboard')}}</li>
						<li{{($current_page == 'status') ? ' class="active"' : ''}}>{{link_to_route('admin.status', 'Status')}}</li>
					</ul>
				</li>
				<!--<li{{empty($current_page) ? ' class="active" ' : ''}}>
					{{link_to_route('admin.dashboard', 'Dashboard')}}
				</li>-->

				<li class="divider"></li>

				<li>
					<a href="#" {{($current_page != 'users' && $current_page != 'roles') ? ' class="toggle"' : ' class="no-toggle"'}}>Users</a>
					<ul class="nav nav-pills nav-toggle {{($current_page == 'users' || $current_page == 'roles') ? 'open' : ''}}">
						<li{{($current_page == 'users') ? ' class="active"' : ''}}>{{link_to_route('admin.users.index', 'All Users')}}</li>
						<li{{($current_page == 'roles') ? ' class="active"' : ''}}>{{link_to_route('admin.roles.index', 'All Roles')}}</li>
					</ul>
				</li>

				<li class="divider"></li>

				<li{{($current_page == 'packages') ? ' class="active"' : ''}}>
					{{link_to_route('admin.packages.index', 'Packages')}}
				</li>

				<li class="divider"></li>

				<li{{($current_page == 'templates') ? ' class="active"' : ''}}>
					{{link_to_route('admin.templates.index', 'Scorecard Templates')}}
				</li>

				<li class="divider"></li>

				<li>
					<a href="#" {{($current_page != 'orders' && $current_page != 'coupons' && $current_page != 'payments') ? ' class="toggle"' : ' class="no-toggle"'}}>Orders</a>
					<ul class="nav nav-pills nav-toggle {{($current_page == 'orders' || $current_page == 'coupons' || $current_page == 'payments') ? 'open' : ''}}">
						<li{{($current_page == 'orders') ? ' class="active"' : ''}}>{{link_to_route('admin.orders.index', 'Recent Orders')}}</li>
						<li{{($current_page == 'coupons') ? ' class="active"' : ''}}>{{link_to_route('admin.coupons.index', 'Coupons')}}</li>
						<li{{($current_page == 'payments') ? ' class="active"' : ''}}>{{link_to_route('admin.payments.index', 'Payments')}}</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>

	<div class="col-sm-9 admin-content">
		@include('layouts.partials._flash')
		@yield('content')
	</div>
