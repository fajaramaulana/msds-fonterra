<?php
/**
 * @project     MSDS Fontera
 * @author      Fajar Agus Maulana
 * @copyright   Copyright (c) 2022, https://github.com/fajaramaulana/
 * @link 		https://github.com/fajaramaulana/
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomePageController@index')->name('blog');

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
    Route::resource('/banner', 'BannerController');
    Route::post('/removeimagebanner', 'BannerController@removeImageBanner')->name('banner.removeImage');
    Route::resource('/listjasa', 'ListjasaController');
    Route::post('/removeimagejasa', 'ListjasaController@removeImageListJasa')->name('listjasa.removeImage');
    Route::resource('/portofoliomanagement', 'PortofolioController');
    Route::post('/removeimageportofolio', 'PortofolioController@removeImagePortofolio')->name('portofoliomanagement.removeImage');
    Route::resource('/pola', 'PolaController');
    Route::post('/removeimagepola', 'PolaController@removeImagePortofolio')->name('pola.removeImage');
    Route::resource('/testimoni', 'TestimoniController');
    Route::resource('/msds', 'MsdsController');
    Route::post('/removepdfmsds', 'MsdsController@removePdfMsds')->name('msds.removePdf');
    Route::get('/getbyid', 'MsdsController@getbyid')->name('msds.getbyid');
    Route::resource('/departement', 'DepartementController');
    Route::resource('/partner', 'PartnerController');
});
