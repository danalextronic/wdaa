@include('layouts/partials/_head', ['styles' => ['assets/css/comparison.css']])
	
	<div class="container">
		@include('layouts/partials/_flash')
		
		@yield('content')
	</div>

@include('layouts/partials/_footer', ['scripts' => ['assets/js/comparison-scorecard.js']])
