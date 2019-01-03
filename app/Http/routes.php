<?php
Route::get('/', 'AdminAuth\AuthController@adminLogin');
Route::post('admin-login', ['as'=>'admin-login','uses'=>'AdminAuth\AuthController@adminLoginPost']);
Route::group(['middleware' => ['auth','locale'] ], function() {
	Route::get('dashboard', 'AdminPanelController@index');
	Route::get('logout', 'AdminAuth\AuthController@logout');
	Route::get('corporates', 'AdminPanelController@managecorporates');
	Route::post('corporates/save', 'AdminPanelController@savecorporate');
	Route::post('corporates/update', 'AdminPanelController@updatecorporate');
	Route::post('corporates/delete', 'AdminPanelController@deletecorporate');
	Route::post('invoices', 'AdminPanelController@invoices');
	Route::get('banks', 'AdminPanelController@managebanks');
	Route::post('banks/save', 'AdminPanelController@savebank');
	Route::post('banks/update', 'AdminPanelController@updatebank');
	Route::post('banks/delete', 'AdminPanelController@deletebank');
	Route::get('vendorrequest', 'AdminPanelController@vendorrequest');
	Route::post('vendorrequest/changestatus', 'AdminPanelController@updaterequeststatus');
	Route::get('404', 'AdminPanelController@errorpage');
});