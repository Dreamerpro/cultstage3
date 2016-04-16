<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/iq', ['uses'=>'WelcomeCtrl@index']);

Route::group(['middleware' => 'web'], function () {
    Route::auth();
	Route::post('/login','CultstageAuthController@login');
	//Route::post('/register','Auth\AuthController@postRegister');
	//Route::get('/logout','CultstageAuthController@logout');
    //Route::get('/home', 'HomeController@index');

    Route::get('/', function () {
    	return view('holder')->with('user',false);
	});
	/*Route::get('/magazine', function () {
	    return view('magazine');
	});*/
	Route::get('/send-entry', function () {
	    return view('entry');
	});
	Route::get('/user' , function(){
		return \Auth::user();
	});
	Route::get('/userdetails/{id}', 'ProfileController@getdetails');
	Route::get('/availableroles/', 'Data\RawDataController@getavailableroles');
	Route::get('/availablelocations/', 'Data\RawDataController@getavailablelocations');
	Route::get('/availablelanguages/', 'Data\RawDataController@getavailablelanguages');
	Route::get('/availableeventtypes/', 'Data\RawDataController@getavailableeventtypes');
	Route::get('/availableproductionstages/', 'Data\RawDataController@getavailableproductionstages');
	Route::get('/availableprojecttypes/', 'Data\RawDataController@getavailableprojecttypes');


Route::group(['middleware'=>'auth'], function(){
		Route::get('/get/profiledetails', 'ProfileController@getdetails');
		Route::post('/post/profiledetails', 'ProfileController@savedetails');
		Route::get('/connectedpeople', 'ProfileController@getconnectedpeople');
		Route::post('/filteredconnectedpeople', 'ProfileController@getfilteredconnectedpeople');

		Route::post('/uploadeventimage/', 'Data\ImageController@uploadeventimage');
		Route::post('/uploadprojectimage/', 'Data\ImageController@uploadprojectimage');
    Route::post('/upload/profileimage', 'Data\ImageController@uploadprofileimage');

		Route::post('/postnewevent/', 'EventController@postnewevent');
		Route::get('/bookmarkedevents/', 'EventController@getbookmarkedevents');
		Route::get('/postedevents/', 'EventController@getpostedevents');

		Route::get('/postedevents/', 'EventController@getpostedevents');

		Route::get('/myprojects/', 'ProjectController@getmyprojects');
		Route::post('/newproject/', 'ProjectController@postnewproject');
		Route::post('/newjob/', 'ProjectController@postnewjob');
		Route::get('/myjobpostings/', 'ProjectController@myjobpostings');

		Route::post('/deleteimage/','Data\ImageController@deleteimage');

		Route::get('/appliedjobs', 'ProjectController@appliedjobs');

		/*MEssage*/
		Route::post('/sendmessage', 'MessageController@send');
		Route::get('/get_inbox', 'MessageController@get_inbox');
		Route::get('/get_sent', 'MessageController@get_sent');
		Route::get('/get_msg/{uuid}', 'MessageController@get_msg');
		Route::post('/delete_msg', 'MessageController@del_msg');

		/*POSTS*/
		Route::get('/myposts', 'PostController@getmyposts');
		Route::get('/delete_post/{uuid}', 'PostController@delete');
		Route::post('/post', 'PostController@post');
		Route::post('/edit_post', 'PostController@edit_post');

		Route::post('/connect', 'ProfileController@connect');
		Route::get('/acceptconnect/{id}', 'ProfileController@acceptconnect');
		Route::get('/get_connect_requests', 'ProfileController@connect_requests');
});

	Route::get('asset/image/{type}/{file}','Data\ImageController@getimage');
	Route::post('/search/{query}/{category}', 'SearchController@search');

	Route::get('auth/{platform}', 'SocialAuthController@redirectToProvider');
	Route::get('auth/{platform}/callback', 'SocialAuthController@handleProviderCallback');
});
