<?php
/*
Route::get('/', function()
{
	return View::make('frontend');
});

Route::get('login','AuthController@showLogin');
Route::post('login','AuthController@login');

*/

Route::get('time','TradingController@getOfficaleBayTime');

Route::post('file','EbayController@fileUpload');
Route::get('file',function(){
	return View::make('ebay/file');
});

Route::get('call','EbayController2@call');

Route::get('/keyword','SimpleKeywordSearchController@start');

Route::get('/','GetOfficalEbayTimeController@start');
