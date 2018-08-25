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



Auth::routes();

Route::get('/', 'Web\IndexController@index');
Route::group(['middleware' => ['auth'],'namespace'=>'Web'], function () {

    if (!Request::ajax()) {
        Route::get('{path?}', ['uses' => 'IndexController@index'])->where('path', '[\/\w\.-]*');
    }

    Route::group(['prefix'=>'user'],function(){
		Route::get('list','UserController@getList');
		Route::get('info', 'UserController@info');
		Route::post('add', 'UserController@postAdd');
		Route::delete('del/{id}', 'UserController@del')->where('id','[1-9](\d+)?');
	});
	Route::group(['prefix'=>'node'],function(){
		Route::get('list','PermissionController@getNodeTree');
		Route::post('add','PermissionController@addNode');
		Route::post('edit','PermissionController@editNode');
	});

	Route::group(['prefix'=>'role'],function(){
		Route::get('list','PermissionController@getRoleList');
		Route::post('detail', 'PermissionController@roleDetail');
		Route::post('edit','PermissionController@editRole');
		Route::delete('del','PermissionController@delRole');
		
	});
	Route::post('/fileUp', 'UserController@fileUp');

});