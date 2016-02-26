<?php

Route::get('/', function()
{
	return View::make('frontend');
});

Route::get('login','AuthController@showLogin');
Route::post('login','AuthController@login');

Route::post('admin', function()
{
	return View::make('admin/admin_dashboard');
});
Route::post('member', function()
{
	return View::make('members/member_dashboard');
});
/*Route::get('member', function()
{
	return View::make('members/member_dashboard');
});*/

Route::get('adminPanel',['as'=>'admin','uses'=>'AuthController@gotoadmin']);
Route::get('memberPanel',['as'=>'member','uses'=>'AuthController@gotomember']);


/*
	*** Book ***
*/
Route::get('addbook', function(){
	return View::make('admin/add_book');
});
Route::post('addbook','BookController@create');

/*Route::get('showbook', function(){
	return View::make('admin/view_book');
});*/

Route::get('showbook','BookController@show');
Route::get('displaybook','BookController@membershow');


Route::get('editdeletebook', function(){
	return View::make('admin/editdeletebook');
});
// Route::get('displaybook', function(){
// 	return View::make('members/view_book');
// });

/*
***Register / login
*/
Route::get('register', function(){
	return View::make('register');
});
Route::post('register','AuthController@register');

/*
*** logout
*/
Route::get('/logout','AuthController@logout');
