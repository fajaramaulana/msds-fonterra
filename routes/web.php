<?php
/**
 * @project     MSDS Fontera
 * @author      Fajar Agus Maulana
 * @copyright   Copyright (c) 2022, https://github.com/fajaramaulana/
 * @link 		https://github.com/fajaramaulana/
*/

use App\Mail\Reminder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomePageController@index')->name('blog');
Route::get('/cronjob', 'WelcomePageController@cronjob');


Route::group(['prefix' => 'msds'], function () {

    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
        'password/reset' => false,
        'password/confirm' => false
    ]);
});

Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('/user', 'UserController');
    Route::resource('/msds', 'MsdsController');
    Route::post('/removepdfmsds', 'MsdsController@removePdfMsds')->name('msds.removePdf');
    Route::get('/getbyid', 'MsdsController@getbyid')->name('msds.getbyid');
    Route::resource('/departement', 'DepartementController');
});
