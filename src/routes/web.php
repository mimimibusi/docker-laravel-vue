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

// Route::get('/Google_Calendar', function () {
//     $client = new Google\Client();
//     $client->setClientId(config('services.google.client_id'));
//     $client->setClientSecret(config('services.google.client_secret'));
//     $client->setRedirectUri(config('services.google.redirect'));
//     $client->addScope(config('services.google.scopes'));

//     $authUrl = $client->createAuthUrl();

//     return redirect($authUrl);
// });

// Route::get('/callback', function () {
//     $client = new Google\Client();
//     $client->setClientId(config('services.google.client_id'));
//     $client->setClientSecret(config('services.google.client_secret'));
//     $client->setRedirectUri(config('services.google.redirect'));
//     $client->addScope(config('services.google.scopes'));

//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $client->setAccessToken($token);

//     return $token;
// });

Route::get('/hello', function(){
    return view('index');
})->middleware('auth');

Route::get('/index', 'UsersController@getData')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{any?}', function () {
    return view('index');
})->where('any',
    '.*'
)->middleware('auth');
