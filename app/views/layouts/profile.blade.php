@include('layouts/partials/_head', ['styles' => ['assets/css/profile.css']])

<div class="container main-layout">
	<div class="col-sm-3 profile-sidebar">
		<div class="list-group">
			{{link_to_route('profile', 'Profile', $user->username, ['class' => 'list-group-item' . (is_null($current_page) ? ' active ' : '')])}}
		</div>

		<div class="list-group">
			
			{{link_to_route('profile.settings', 'Account Settings', $user->username, ['class' => 'list-group-item' . ($current_page == 'settings' ? ' active ' : '')])}}

			{{link_to_route('profile.billing', 'Billing History', $user->username, ['class' => 'list-group-item' . ($current_page == 'billing' ? ' active ' : '')])}}
		</div>
	</div>

	<div class="col-sm-9 profile-content">
		<div class="page-header">
			<h1>
				{{$user->display_name}}
				@if(isset($page_title))
					<small>{{$page_title}}</small>
				@endif
			</h1>
		</div>

		@include('layouts/partials/_flash')

		
		@yield('content')
	</div>
</div>
@include('layouts/partials/_footer')
