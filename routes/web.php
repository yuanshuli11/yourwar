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
//聊天
Route::group(['prefix' => 'sysadmin','namespace'=>'Admin'], function () {
    Route::group(['prefix' => 'object'], function () {
        Route::post('/add', 'ObjectController@post_add');
        Route::get('/add', 'ObjectController@add');
        Route::get('/list', 'ObjectController@list');
        Route::get('/edit/{id}', 'ObjectController@edit');
        Route::post('/addDetail/{id}', 'ObjectController@addDetail');
    });
    Route::get('/', 'HomeController@index');
  
});
//聊天
Route::group(['prefix' => 'chat'], function () {
    Route::get('/', 'ChatController@index');
});
//邮件
Route::group(['prefix' => 'mail'], function () {
    Route::get('/', 'MailController@index');
});
//军报
Route::group(['prefix' => 'report'], function () {
    Route::get('/', 'ReportController@index');
});
//任务
Route::group(['prefix' => 'task'], function () {
    Route::get('/', 'TaskController@index');
});
//功能区
Route::group(['prefix' => 'part'], function () {
    Route::get('/army', 'HomeController@army');
    Route::get('/resource', 'HomeController@resource');
    Route::get('/map', 'HomeController@map');
    Route::get('/trade', 'HomeController@trade');
    Route::get('/tech', 'HomeController@tech');
    Route::get('/', 'HomeController@index');
});
Route::get('/begin','HomeController@begin');
Route::post('/beginSetting','HomeController@beginSetting');
Route::get('/','HomeController@index');

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/', 'HomeCo');

// });

Auth::routes();


