<?php
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('getjson', 'DataController@getJson');
Route::get('saveRanking/{nombre}/{numero_identificacion}/{score}', 'DataController@saveRanking');
Route::get('getRanking', 'DataController@getRanking');
Route::get('getPreguntas', 'DataController@getPreguntas');
Route::post('getestrategias', 'DataController@getEstrategias');
//Route::get('getestrategias/{str}', 'DataController@getEstrategias')->middleware("cors");

//Route::match(['post'], "getestrategias", "DataController@getEstrategias")->middleware("cors");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
