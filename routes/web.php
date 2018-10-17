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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get("/home", 'HomeController@index')->name('home');
Route::any("/home_ajax", "HomeController@home_ajax");
Route::any("/file_upload", "HomeController@file_upload");

Route::group(['middleware' => ['UserMiddleWare:canaccess']], function() {
    Route::get("/settings", "SettingsController@index");
    Route::any("/settings_ajax", "SettingsController@settings_ajax");
});

Route::get("/meeting", "MeetingsController@index");
#Logout
Route::get("/logout", function(){
    return View::make("logout");
 });