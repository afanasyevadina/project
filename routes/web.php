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
    return redirect()->route('groups');
});
Route::get('/groups', 'GroupController@index')->name('groups');
Route::get('/schedule', 'ScheduleController@index')->name('schedule');
Route::get('/changes', 'ChangeController@index')->name('changes');
Route::get('/graphic', 'GraphicController@index')->name('graphic');
Route::get('/subjects', 'SubjectController@index')->name('subjects');
Route::get('/teachers', 'TeacherController@index')->name('teachers');
Route::get('/plans', 'PlanController@index')->name('plans');

Route::get('/schedule/upload', function() {
	return view('schedule.upload');
});
Route::get('/changes/upload', function() {
	return view('changes.upload');
});

Route::post('/schedule/upload', 'ScheduleController@upload');
Route::post('/changes/upload', 'ChangeController@upload');
Route::post('/subjects/upload', 'SubjectController@upload');
Route::post('/teachers/upload', 'TeacherController@upload');
Route::post('/plans/upload', 'PlanController@upload');

Route::post('/groups', 'GroupController@store');
Route::post('/graphic', 'GraphicController@store');
Route::post('/subjects', 'SubjectController@store');
Route::post('/teachers', 'TeacherController@store');
Route::post('/plans', 'PlanController@store');

Route::post('/graphic/{id}', 'GraphicController@update');
Route::post('/groups/{id}', 'GroupController@update');
Route::post('/subjects/{id}', 'SubjectController@update');
Route::post('/teachers/{id}', 'TeacherController@update');


Route::get('/groups/{id}/delete', 'GroupController@destroy');
Route::get('/graphic/{id}/delete', 'GraphicController@destroy');
Route::get('/subjects/{id}/delete', 'SubjectController@destroy');
Route::get('/teachers/{id}/delete', 'TeacherController@destroy');


