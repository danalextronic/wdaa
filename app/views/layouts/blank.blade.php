@include('layouts.partials._head', ['no_wrapper' => true])

<div id="modal_wrapper">
	@yield('content')
</div>

@include('layouts.partials._footer', ['no_wrapper' => true])
