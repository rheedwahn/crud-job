<?php
	Route::post('auth/register', [
	'uses' => 'AuthController@register']);
	
	// here is the controller for the login
	Route::post('auth/login', [
	'uses' => 'AuthController@login']);

	// and this is controller for displaying the user details
	Route::get('/hostel', [
		'uses'=> 'AuthController@hostel',
		// 'middleware' => 'jwt.auth'
	]);

	Route::get('/admin/views', ['uses'=> 'adminController@students']);



	Route::get('/home', ['uses'=> 'AuthController@home']);
	
	Route::get('/contact', ['uses'=> 'AuthController@contact']);


	Route::get('admin/index', ['uses'=> 'adminController@index']);
	Route::post('/slider', ['uses' => 'adminController@upload']);
	Route::post('/upload', ['uses' => 'adminController@hostel']);
	Route::post('/hostel', ['uses' => 'adminController@saveImage']);


	Route::get('/users', 'AuthController@getUser');

	Route::get('/slider', function () {
    return view('admin/slider');
	});

	Route::get('/admin/views', function () {
    return view('admin/views');
	});

	Route::get('/admin/upload', function () {
    return view('admin/upload');
	});

	Route::get('/admin/hostel', function () {
    return view('admin/hostel');
	});


Auth::routes();
