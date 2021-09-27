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
	return view('auth.login');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('project', 'ProjectController');
	Route::resource('users', 'UserController');
	Route::resource('client', 'ClientController');
	Route::resource('db', 'DBController');
	Route::resource('encuesta', 'SurveyController');
	Route::get('/survey/{idHash}', 'SurveyController@survey')->name('survey');
	Route::post('/encuesta/storeCliente', 'SurveyController@surveyClient')->name('survey_client');
	Route::post('/project/savefield', 'ProjectController@savefield')->name('save_field');
	Route::get('/project/getfield/{id}', 'ProjectController@getField')->name('get_field_project');
	Route::post('/db/savedb/{id}', 'DBController@saveDB')->name('save_db_project');
	Route::post('/db/savedbimport', 'DBController@saveDBImport')->name('save_db_project_import');
	Route::get('/db/getdatadb/{id}', 'DBController@getDataDB')->name('get_data_db');
	//	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
