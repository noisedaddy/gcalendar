<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CalendarController@create')->name('gcalendar.welcome');
Route::post('store', 'CalendarController@store')->name('gcalendar.store');
Route::get('refresh_captcha', 'CalendarController@refreshCaptcha')->name('refresh_captcha');

//Route::get('/', function () {
//    return view('welcome');
//});
