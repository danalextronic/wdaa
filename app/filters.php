<?php

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	Analytics::record($request, $response);
});



Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login')->with('message', 'Please log in before proceeding');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('verify.ssl', function() {
	/*if( App::environment() == 'production' && ! Request::secure())
    {
        return Redirect::secure(Request::getRequestUri());
    } */
});


Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		$message = "An unexpected error occurred!";
		if(Request::ajax())
		{
			return jsonResponse(false, $message);
		}

		return Redirect::back()->with('error', $message);
	}
});

Route::filter('can_view_profile', function($route, $request) {
	$requested_username = $request->segment(2);
	$current_username = Auth::user()->username;

	if($requested_username != $current_username && !Auth::user()->isAdmin()) {
		return Redirect::home()->with('error', 'Profile Not Found!');
	}
});

Route::Filter('can_verify', function($route, $request) {
	if(!Auth::user()->belongsToRole(['evaluate', 'review'])) {
		return Redirect::home();
	}
});

Route::filter('is_master_judge', function($route, $segment) {
	if(!Auth::user()->belongsToRole('judge')) {
		return Redirect::home();
	}
});

Route::filter('is_admin', function() {
	if(!Auth::check() || !Auth::user()->isAdmin()) {
		return Redirect::home();
	}
});
