<?php

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
Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});
	Route::post('forum', 'Api\ForumController@store');
	Route::get('forum/{id}', 'Api\ForumController@show');
	Route::get('forum/{id}/delete', 'Api\ForumController@destroy');
	Route::get('forum/{id}/refresh', 'Api\ForumController@refresh');
});
Route::get('groups', 'Api\GroupController@index');
Route::get('schedule', 'Api\ScheduleController@index');
Route::get('schedule/group', 'Api\ScheduleController@group');
Route::get('schedule/teacher', 'Api\ScheduleController@teacher');
Route::get('schedule/cab', 'Api\ScheduleController@cab');
Route::get('changes', 'Api\ChangeController@index');
Route::get('changes/group', 'Api\ChangeController@group');
Route::get('changes/teacher', 'Api\ChangeController@teacher');
