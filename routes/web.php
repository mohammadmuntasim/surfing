<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
//Route::post('/home', 'AjaxPostController@ajaxrequest');
Route::any('/home', 'HomeController@index');
Route::get('/updatepost', 'AjaxPostController@updateajaxrequest');
Route::get('/reviews/{reviews?}', 'ReviewController@indexname');
Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
Route::any('/profile', ['middleware' => 'auth', 'uses' => 'UserController@index']);
Route::any('/profile/edit', ['middleware' => 'auth', 'uses' => 'UserController@edit']);
Route::any('/removeconnection', ['as' => 'removeconnection', 'uses' => 'ConnectionController@removeConnection']);
Route::any('/ajax-request-like/{likeid?}', ['as' => 'home', 'uses' => 'AjaxPostController@likePost']);
Route::any('/sharepost/{shareid?}', ['as' => 'home', 'uses' => 'TimelinePostController@createNewSharePost']);

Route::any('/sharepostdata/{getdata?}', ['as' => 'home', 'uses' => 'AjaxPostController@postdatabyid']);
Route::any('/allreviews', ['as' => 'allreviews', 'uses' => 'ReviewController@index']);
Route::get('/reviewsaction/{delr?}', ['as' => 'user.reviewsconfrimation', 'uses' => 'ReviewController@approvereviews']);
Route::get('/reviewsaction/{approved?}', ['as' => 'user.reviewsconfrimation', 'uses' => 'ReviewController@approvereviews']);
Route::any('/photos', ['middleware' => 'auth', 'uses' => 'UserPhotosController@index']);
Route::any('/appointments', ['middleware' => 'auth', 'uses' => 'ShowAppointmentController@index']);
Route::get('/patients', 'ShowCalendarController@showpatients');
Route::get('/profile/{uploads?}', ['middleware' => 'auth', 'uses' => 'UserController@index']);
Route::get("autocomplete",array('as'=>'autocomplete','uses'=> 'AjaxControllerRequest@autocomplete'));
Route::get("searchconnectname",array('as'=>'searchconnectname','uses'=> 'ConnectionController@searchconnectname'));
Route::get("/referuser/{getdata?}",array('as'=>'referuser','uses'=> 'UserReferController@referuser'));
Route::get("/connectionlist",array('as'=>'connectionlist','uses'=> 'ConnectionController@connectionlist'));
Route::get("/userfollow/{getdata?}",array('as'=>'userfollow','uses'=> 'FollowsController@followuser'));
Route::get("/deletemedia/{imgid?}",array('as'=>'deletemedia','uses'=> 'AjaxControllerRequest@deletemediaimage'));
//Route::get('/', ['as' => 'welcome', 'uses' => 'HomeController@index']);
Route::get('/following', 'FollowsController@followings');
Route::get('/followers', 'FollowsController@followers');
Route::get('pages/{slug?}', 'HomeController@pages');
Route::any('/appointments/{date}', 'BookingController@index');
Route::post('/contact', ['as' => 'contact-us', 'uses' => 'HomeController@inquirypost']);
Route::get('jquery-loadmore',['as'=>'jquery-loadmore','uses'=>'FileController@loadMore']);
Route::get('notifications/{name?}',['as'=>'notifications','uses'=>'NotificationController@showRecords']);
Route::get('states/{name?}',['as'=>'states','uses'=>'AjaxController@getCounty']);
Route::get('plans/{name?}',['as'=>'states','uses'=>'AjaxController@getPlans']);
Route::get('makeplans/{name?}',['as'=>'states','uses'=>'AppointmentController@makeAppointmentInsuPlans']);

Route::get('removetags/{name?}',['as'=>'states','uses'=>'AjaxController@removeTags']);
Route::any('ajax-cover',['as'=>'ajax-cover','uses'=>'AjaxController@removeCover']);
Route::get('makeappointment/{colour?}',['as'=>'makeappointment','uses'=>'AppointmentController@getTimeSchedule']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::any('newsearch',['as'=>'newsearch','uses'=>'NewSearchController@index']);
//available
Route::get('/schedule/{dayname?}',['as'=>'states','uses'=>'ShowAppointmentController@showAvailTimes']);

Route::group(array('before' => 'auth'), function() {

    /*
     | Sign Out (GET)
     | --
     */
    Route::get('/account/sign-out', array(
        'as' => 'account-sign-out',
        'uses' => 'AjaxController@getSignOut'
    ));

});

Auth::routes();
Route::get('/filetest','FiletestController@testfile');
Route::get('/search','SearchController@index');
Route::any('/search','SearchController@searchvalue');
Route::any('/search/{userid}/{name}', [   'as'   => 'user.shortprofileview', 'uses' => 'SearchViewController@index']);
Route::post('/test',  'ReviewController@indexname');
/****view request **/
Route::get('/connections','ConnectionController@index');
/*Route::get('/connections/{uid?}',[ 'as'   => 'user.viewrequest', 'uses' => 'ConnectionController@ajaxrequestsreposnse']);*/
/*****request send and accept***/
Route::any('/posts/{postid}', ['as' => 'home', 'uses' => 'SinglePostController@index']);
Route::get('/ajaxrequest/{id?}', [   'as'   => 'user.shortprofileview', 'uses' => 'ConnectionController@ajaxrequests']);
Route::get('/ajaxresponserequest/{uid?}', [   'as'   => 'user.shortprofileview', 'uses' => 'ConnectionController@ajaxrequestsreposnse']);
Route::get('/timelinepostajaxrequest/{id?}', [   'as'   => 'timelinepostajaxrequest', 'uses' => 'AjaxPostController@timelinepostajaxrequests']);
Route::get('/timeline-post', ['middleware' => 'auth', 'uses' => 'HomeController@timelinepost']);

Route::post('/timeline-post', ['middleware' => 'auth', 'uses' => 'AjaxPostController@timelinepostajaxrequests']);


Route::post('subscribe',['as'=>'subscribe','uses'=>'MailChimpController@subscribe']);

Route::get('/user/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');
Route::any('/claim-profile', 'Auth\ClaimController@update');
Route::get('/user/discountpage/','DiscountController@index');
Route::get('/help','HelpFAQController@index');
Route::get('/download');



Route::get('/contactus', 'ContactUsController@index');
Route::post('/contactus', 'ContactUsController@store');
Route::get('/mapid/{map?}', [   'as'   => 'user.shortprofileview', 'uses' => 'AjaxController@mapaddress']);
Route::get('/privacy', 'ProviderDisclaimController@index');

Route::get('timelinepostcommentajaxrequest/{statusid?}', [   'as'   => 'timelinepostcommentajaxrequest', 'uses' => 'AjaxCommentController@timelinepostcommentajaxrequests']);
Route::get('homecommentajaxrequest/{statusid?}', [   'as'   => 'timelinepostcommentajaxrequest', 'uses' =>'AjaxCommentController@homepostcommentajaxrequests']);

//Route::post('/photoalbum', 'AlbumController@storealbum');
Route::any('email-validate', 'AjaxController@checkEmail');
Route::any('email-resend-verification', 'EmailVerificationController@index');
Route::any('email-resend-verification-send', 'EmailVerificationController@send');

/* Review reply */
Route::any('/profile/review-comment/send', 'ReviewController@reviewComment');
Route::post("/photos/update/",'UserPhotosController@updateAlbum');
//Route::any("/photos/delete-album/",'UserPhotosController@index');

/* Fudugo Chat */
Route::group(['prefix' => 'messages'], function () {
    Route::get('/read', 'MessagesController@readMessage');
    Route::get('/check-online-users', 'MessagesController@checkUserOnline');
    Route::get('/set-online-status', 'MessagesController@setUserOnline');
    Route::post('/create-thread', 'MessagesController@createNewThread');
    Route::any('/delete', 'MessagesController@deleteConversation');
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    //Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::any('/update/{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});


Route::get('message/{id}', 'MessageController@chatHistory')->name('message.read');


Route::any('/ajax/message/send', 'MessageController@ajaxSendMessage')->name('message.new');
Route::delete('/ajax/message/delete/{id}', 'MessageController@ajaxDeleteMessage')->name('message.delete');