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

Route::get('/google', function () {
    return view('google');
});

Route::middleware('auth')->group(function(){
    Route::get('/login/google-oauth', 'OAuthLoginController@getGoogleAuth');
    Route::get('/login/google-oauth/callback', 'OAuthLoginController@authGoogleCallback');
    Route::get('/judgeHaveAccessToken', 'OAuthLoginController@judgeHaveAccessToken');

    Route::get('/googleCalendar', 'GoogleCalendarController@getEvents');
    Route::post('/createEvent', 'GoogleCalendarController@createEvent');
    Route::delete('/deleteEvent', 'GoogleCalendarController@deleteEvent');
    Route::get('/getEditEvent', 'GoogleCalendarController@getEditEvent');
    
    Route::get('/hello', function(){
        return view('index');
    });
    
    Route::get('/index', 'UsersController@getData');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any?}', function () {
    return view('index');
})->where('any',
    '.*'
)->middleware('auth');
