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
  Route::get('/csrf_token' , function(){
		return csrf_token();
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
    Route::post('/upload/albumimage', 'Data\ImageController@uploadalbumimage');
    Route::post('/upload/coverimage', 'Data\ImageController@uploadcoverimage');

    Route::get('/uploaded/videos','VideoController@getuploaded');
    Route::post('/upload/video','VideoController@upload');
    Route::get('/uploaded/audios','AudioController@getuploaded');
    Route::post('/upload/audio','AudioController@upload');
    //Route::get('/uploaded/audios','VideoController@getuploaded');

		Route::post('/postnewevent/', 'EventController@postnewevent');
		Route::get('/bookmarkedevents/', 'EventController@getbookmarkedevents');
		Route::get('/bookmarkevent/{eid}', 'EventController@bookmarkevent');
    Route::get('/unbookmarkevent/{eid}', 'EventController@unbookmarkevent');

    // Route::get('/postedevents/', 'EventController@getpostedevents');
    Route::get('/postedevents/', 'EventController@getpostedevents');
    Route::get('/deleteevent/{id}', 'EventController@deleteevent');


    Route::get('/myprojects/', 'ProjectController@getmyprojects');
		Route::post('/newproject/', 'ProjectController@postnewproject');
    Route::get('/deleteproject/{id}', 'ProjectController@deleteproject');

    Route::post('/newjob/', 'ProjectController@postnewjob');//new or edit job
		Route::get('/myjobpostings/', 'ProjectController@myjobpostings');
    Route::get('/appliedjobs', 'JobController@getappliedjobs');
    Route::get('/applyforjob/{jobid}', 'JobController@applyforjob');
    Route::get('/removeapplication/{jobid}', 'JobController@removeapplication');

		Route::post('/deleteimage','Data\ImageController@deleteimage');
    Route::get('/deleteprojectimage/{id}','Data\ImageController@deleteprojectimage');

		//Route::get('/appliedjobs', 'ProjectController@appliedjobs');
    Route::get('/deletejob/{id}', 'ProjectController@deletejob');

    Route::get('/myalbumimages','Data\ImageController@albumimages');
		/*MEssage*/
		Route::post('/sendmessage', 'MessageController@send');
		Route::get('/get_inbox', 'MessageController@get_inbox');
		Route::get('/get_sent', 'MessageController@get_sent');
		Route::get('/get_msg/{uuid}', 'MessageController@get_msg');
		Route::post('/delete_msg', 'MessageController@del_msg');
    // Script
    Route::get('/myscripts', 'ScriptController@getmyscripts');
		Route::get('/delete_script/{id}', 'ScriptController@deleteScript');
		Route::post('/savescript', 'ScriptController@saveScript');
		Route::post('/updatescript', 'ScriptController@updateScript');

		/*POSTS*/
		Route::get('/myposts', 'PostController@getmyposts');
		Route::get('/delete_post/{uuid}', 'PostController@delete');
		Route::post('/post', 'PostController@post');
		Route::post('/edit_post', 'PostController@edit_post');

		Route::post('/connect', 'ProfileController@connect');
    Route::get('/disconnect/{id}', 'ProfileController@disconnect');
		Route::get('/acceptconnect/{id}', 'ProfileController@acceptconnect');
		Route::get('/get_connect_requests', 'ProfileController@connect_requests');

    Route::get('/delete/audio/{name}','AudioController@delete');
    Route::get('/delete/video/{name}','VideoController@delete');


      Route::get('/get_accepted_requests', function ()
    {
      return \Auth::user()->connections_accepted();
    });

});

  Route::get('/asset/audio/{name}','AudioController@get');
  Route::get('/asset/video/{name}','VideoController@get');

	Route::get('asset/image/{type}/{file}','Data\ImageController@getimage');
	Route::post('/search', 'SearchController@search');

	Route::get('auth/{platform}', 'SocialAuthController@redirectToProvider');
	Route::get('auth/{platform}/callback', 'SocialAuthController@handleProviderCallback');
});
