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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', function () {
    return \App\User::find(2)->add_friend(5);
});
Route::get('/accept', function () {
    return \App\User::find(5)->accept_friend(2);
});

Route::get('/friends', function () {
    return \App\User::find(1)->friends();
});

Route::get('/pending_friends', function () {
    return \App\User::find(5)->pending_friend_requests();
});

Route::get('/ids', function () {
    return \App\User::find(1)->frinds_ids();
});

Route::get('/is', function () {
    return \App\User::find(1)->is_friends_with(2);
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>'auth'], function(){
	Route::get('/profile/{slug}',[
		'uses'=>'ProfileController@index',
		'as' => 'profile'
		]);
	Route::get('/profile/edit/profile',[
		'uses'=>'ProfileController@edit',
		'as' => 'profile.edit'
		]);
	Route::post('/profile/update/profile',[
		'uses'=>'ProfileController@update',
		'as' => 'profile.update'
		]);
});