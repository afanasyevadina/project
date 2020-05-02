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
    return redirect()->route('home');
});
Route::group(['middleware' => ['auth', 'can:admin']], function () {
	Route::get('/admin/users', 'Admin\UserController@index')->name('admin/users');
	Route::get('/admin/users/create', 'Admin\UserController@create')->name('admin/users/create');
	Route::post('/admin/users/register', 'Admin\UserController@register');
	Route::post('/admin/users', 'Admin\UserController@store');
});

Route::group(['middleware' => ['auth', 'can:manager']], function () {
	Route::get('/specializations', 'SpecializationController@index')->name('specializations');
	Route::get('/groups', 'GroupController@index')->name('groups');
	Route::get('/students', 'StudentController@index')->name('students');
	Route::get('/students/{id}/edit', 'StudentController@edit')->name('students');
	Route::get('/students/create', 'StudentController@create')->name('students');
	Route::get('/graphic', 'GraphicController@index')->name('graphic');
	Route::get('/cikls', 'CiklController@index')->name('cikls');
	Route::get('/subjects', 'SubjectController@index')->name('subjects');
	Route::get('/teachers', 'TeacherController@index')->name('teachers');
	Route::get('/teachers/{id}/edit', 'TeacherController@edit')->name('teachers');
	Route::get('/teachers/create', 'TeacherController@create')->name('teachers');
	Route::get('/cabs', 'CabController@index')->name('cabs');
	Route::get('/plans', 'PlanController@index')->name('plans');
	Route::get('/rup', 'RupController@index')->name('rup');
	
	Route::post('/subjects/upload', 'SubjectController@upload');
	Route::post('/teachers/upload', 'TeacherController@upload');
	Route::post('/plans/upload', 'PlanController@upload');
	Route::post('/students/upload', 'StudentController@upload');

	Route::post('/specializations', 'SpecializationController@store');
	Route::post('/groups', 'GroupController@store');
	Route::post('/graphic', 'GraphicController@store');
	Route::post('/cikls', 'CiklController@store');
	Route::post('/subjects', 'SubjectController@store');
	Route::post('/teachers', 'TeacherController@store');
	Route::post('/cabs', 'CabController@store');
	Route::post('/plans', 'PlanController@store');
	Route::post('/plans/{id}', 'PlanController@update');
	Route::post('/rup/{group}/{kurs}', 'RupController@store');
	Route::post('/students', 'StudentController@store');

	Route::post('/graphic/{id}', 'GraphicController@update');
	Route::post('/specializations/{id}', 'SpecializationController@update');
	Route::post('/groups/{id}', 'GroupController@update');
	Route::post('/cikls/{id}', 'CiklController@update');
	Route::post('/subjects/{id}', 'SubjectController@update');
	Route::post('/teachers/{id}', 'TeacherController@update');
	Route::post('/students/{id}', 'StudentController@update');
	Route::post('/cabs/{id}', 'CabController@update');

	Route::get('/specializations/{id}/delete', 'SpecializationController@destroy');
	Route::get('/groups/{id}/delete', 'GroupController@destroy');
	Route::get('/graphic/{id}/delete', 'GraphicController@destroy');
	Route::get('/cikls/{id}/delete', 'CiklController@destroy');
	Route::get('/subjects/{id}/delete', 'SubjectController@destroy');
	Route::get('/teachers/{id}/delete', 'TeacherController@destroy');
	Route::get('/students/{id}/delete', 'StudentController@destroy');
	Route::get('/plans/{id}/delete', 'PlanController@destroy');
	Route::get('/cabs/{id}/delete', 'CabController@destroy');
	Route::get('/students/{group}/divide', 'StudentController@divide');
	Route::get('/plans/{group}/reset', 'PlanController@reset');
	Route::get('/plans/copy', 'PlanController@copy');
	Route::get('/rup/{id}/refresh/{kurs}', 'RupController@refresh');
	Route::get('/rup/{id}/export/{kurs}', 'RupController@export');
});

Route::group(['middleware' => ['auth', 'can:dispatcher']], function () {
	Route::get('/holidays', 'HolidayController@index')->name('holidays');
	Route::get('/exams/edit', 'ExamController@edit')->name('exams/edit');
	Route::get('/schedule/edit', 'ScheduleController@edit')->name('schedule/edit');
	Route::get('/changes/edit', 'ChangeController@edit')->name('changes/edit');
	Route::get('/schedule/allowcab/{day}/{num}/{week}', 'ScheduleController@allowcab');
	Route::get('/changes/allowcab/{num}', 'ChangeController@allowcab');
	Route::get('/changes/allowteacher/{num}', 'ChangeController@allowteacher');
	Route::get('/doc/form3', 'DocController@form3')->name('form3');
	Route::get('/doc/form2', 'DocController@form2')->name('form2');

	Route::get('/holidays{id}/delete', 'HolidayController@destroy');

	Route::post('/holidays', 'HolidayController@store');
	Route::post('/exams', 'ExamController@store');
	Route::post('/schedule', 'ScheduleController@store');
	Route::post('/changes', 'ChangeController@store');
	Route::post('/schedule/receive/{day}/{num}/{week}', 'ScheduleController@receive');
	Route::post('/changes/receive/{num}', 'ChangeController@receive');
	Route::get('/schedule/reset', 'ScheduleController@reset');
});

Route::group(['middleware' => ['auth', 'can:teacher']], function () {
	Route::get('/load', 'LoadController@index')->name('load');
	Route::get('/rp', 'RpController@index')->name('rp');
	Route::get('/ktp', 'KtpController@index')->name('ktp');
	Route::get('/journal', 'JournalController@index')->name('journal');
	Route::get('/results', 'ResultController@index')->name('results');
	Route::get('/groups/{id}/students', 'GroupController@students')->name('groups');
	Route::get('/results/{id}/edit', 'ResultController@edit')->name('results');
	Route::get('/rp/{groupId}/{subjectId}', 'RpController@view')->name('rp');
	Route::get('/ktp/{groupId}/{subjectId}/{kurs}/', 'KtpController@view')->name('ktp');
	Route::get('/journal/{id}', 'JournalController@view');
	Route::get('/journal/report', 'JournalController@report')->name('journal/report');
	Route::get('/rp/{groupId}/{subjectId}/export', 'RpController@export');
	Route::get('/rp/{groupId}/{subjectId}/reset', 'RpController@reset');
	Route::get('/ktp/{groupId}/{subjectId}/{kurs}/export', 'KtpController@export');

	Route::post('/rp/{groupId}/{subjectId}', 'RpController@store');
	Route::post('/rp/{groupId}/{subjectId}/copy', 'RpController@copy');
	Route::post('/journal', 'JournalController@store');
	Route::post('/results', 'ResultController@store');

	Route::post('/journal/{id}/refresh', 'JournalController@refresh');
	Route::get('/load/{id}/export/{year}', 'LoadController@export');
});

Route::group(['middleware' => ['auth', 'can:forum']], function () {
	Route::get('/forum', 'ForumController@index')->name('forum');
	Route::get('/forum/{id}', 'ForumController@view')->name('forum');
	Route::get('/forum/{id}/edit', 'ForumController@edit')->name('forum');

	Route::post('/forum', 'ForumController@store');
	Route::post('/forum/{id}', 'ForumController@update');
});

Route::group(['middleware' => ['auth']], function () {
	Route::get('/exams', 'ExamController@index')->name('exams');
	Route::get('statistic/top', 'StatisticController@top')->name('statistic/top');
	Route::get('/schedule', 'ScheduleController@index')->name('schedule');
	Route::get('/schedule/group', 'ScheduleController@group')->name('schedule');
	Route::get('/schedule/teacher', 'ScheduleController@teacher')->name('schedule');
	Route::get('/schedule/cab', 'ScheduleController@cab')->name('schedule');
	Route::get('/schedule/export', 'ScheduleController@export');
	Route::get('/changes', 'ChangeController@index')->name('changes');
	Route::get('/changes/group', 'ChangeController@group')->name('changes');
	Route::get('/changes/teacher', 'ChangeController@teacher')->name('changes');
	Route::get('/results/{id}', 'ResultController@view')->name('zachetka');

	Route::post('/forum', 'ForumController@store');
	Route::post('/forum/{id}', 'ForumController@update');
});

Route::group(['middleware' => ['auth', 'can:student']], function () {
	Route::get('statistic/dynamic', 'StatisticController@dynamic')->name('statistic/dynamic');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');