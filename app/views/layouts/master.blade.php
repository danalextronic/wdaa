@include('layouts/partials/_head')

<div class="container main-layout">
	@include('layouts/partials/_flash')
	
	@yield('content')
</div>

@include('layouts/partials/_footer')
