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

Route::get('/getClasses','HomeController@getClasses');
Route::get('/', 'HomeController@index');


Auth::routes();

Route::get('/register','RegistrationController@index');
Route::post('/register','RegistrationController@register')->name('register');

Route::get('/logout','DHomeController@index');

Route::get('/cours','HomeController@cours');
Route::get('/form',function(){
    return view('form');
});
Route::get('/notif',function(){
    return view('nots');
});

Route::get("/delete", "HomeController@supprimerCours");

Route::get('/forms', function() {
    echo Form::open(array('url' => 'test'));
    echo Form::close();
});
//Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/save', 'HomeController');
Route::get('/search', 'HomeController@search');
Route::get('/lecture', 'HomeController@lecture');

Route::resource('/users','UserController');
//Route::resource('/notifications','NotificationController');
Route::get('nots',function (){
    return view('notification');
});
Route::get('/cours/navigation', 'NavigationController@lectureNavigation');

Route::resource('/*', ' ErrorController@lectureNavigation');

Route::post('/send/mail', 'NotificationController@send')->name("sendMail");


