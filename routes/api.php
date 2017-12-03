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
Route::group(['namespace'=>'Api'], function () {
    Route::group(['prefix'=>'build/v1','namespace'=>'Build\V1'], function () {
        //建造
        Route::post('/building', 'BuildController@building');
        //获取升级信息
        Route::post('/getBuildUpInfo', 'BuildController@getBuildUpInfo');
        //获取升级科技信息
        Route::post('/getTechUpInfo', 'BuildController@getTechUpInfo');
        //科技升级
        Route::post('/techBuild', 'BuildController@techBuild');
        
    });
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
