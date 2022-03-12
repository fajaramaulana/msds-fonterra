<?php

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

Route::group(['middleware' => ['auth', 'prevent-back-history']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    /* Admin */
    Route::group(['middleware' =>'akses.admin'], function(){
    Route::resource('/user','UserController');
    Route::resource('/banner','BannerController');
    Route::post('/removeimagebanner', 'BannerController@removeImageBanner')->name('banner.removeImage');
    Route::resource('/listjasa', 'ListjasaController');
    Route::post('/removeimagejasa', 'ListjasaController@removeImageListJasa')->name('listjasa.removeImage');
    Route::resource('/portofoliomanagement', 'PortofolioController');
    Route::post('/removeimageportofolio', 'PortofolioController@removeImagePortofolio')->name('portofoliomanagement.removeImage');
    Route::resource('/pola', 'PolaController');
    Route::post('/removeimagepola', 'PolaController@removeImagePortofolio')->name('pola.removeImage');
    Route::resource('/testimoni', 'TestimoniController');
    Route::resource('/bahan', 'BahanController');
    Route::post('/removeimagebahan', 'BahanController@removeImageBahan')->name('bahan.removeImage');
    Route::resource('/faqbackend', 'FaqController');
    Route::resource('/partner', 'PartnerController');
    });
    
});






