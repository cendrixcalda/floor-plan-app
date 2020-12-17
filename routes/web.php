<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth', 'floorplan.access']], function() {
    Route::get('/', function(){
    	return redirect('/floorplans');	
    });
});

Route::group(['prefix' => 'login'], function() {
    Route::get('/', [
        'uses' => 'LoginController@login',
        'as' => 'login',
    ]);
    Route::post('/submit', [
        'uses' => 'LoginController@submit',
        'as' => 'login.submit',
    ]);
});

Route::group(['middleware' => 'auth', 'prefix' => 'logout'], function() {
    Route::get('/', [
        'uses' => 'LoginController@logout',
        'as' => 'logout',
    ]);
});

Route::group(['middleware' => ['auth', 'floorplan.access'], 'prefix' => 'floorplans'], function() {
    Route::get('/', [
        'uses' => 'FloorPlanController@show',
        'as' => 'floorplans',
    ]);

    Route::get('/columns', [
        'uses' => 'FloorPlanController@getColumns',
        'as' => 'floorplans.columns',
    ]);
    Route::get('/data', [
        'uses' => 'FloorPlanController@getFloorPlans',
        'as' => 'floorplans.data',
    ]);

    Route::group(['middleware' => 'floorplan.edit'], function() {
        Route::post('/insert', [
            'uses' => 'FloorPlanController@postFloorPlan',
            'as' => 'floorplans.insert',
        ]);
        Route::post('/update', [
            'uses' => 'FloorPlanController@putFloorPlan',
            'as' => 'floorplans.update',
        ]);
        Route::post('/delete', [
            'uses' => 'FloorPlanController@deleteFloorPlan',
            'as' => 'floorplans.delete',
        ]);
    
        Route::post('/house-image/insert', [
            'uses' => 'FloorPlanController@postHouseImage',
            'as' => 'floorplans.houseimage.insert',
        ]);
        Route::post('/house-image/delete', [
            'uses' => 'FloorPlanController@deleteHouseImage',
            'as' => 'floorplans.houseimage.delete',
        ]);
        Route::post('/floor-plan-image/insert', [
            'uses' => 'FloorPlanController@postFloorPlanImage',
            'as' => 'floorplans.floorplanimage.insert',
        ]);
        Route::post('/floor-plan-image/delete', [
            'uses' => 'FloorPlanController@deleteFloorPlanImage',
            'as' => 'floorplans.floorplanimage.delete',
        ]);
        Route::post('/floor-plan-file/insert', [
            'uses' => 'FloorPlanController@postFloorPlanFile',
            'as' => 'floorplans.floorplanfile.insert',
        ]);
        Route::post('/floor-plan-file/delete', [
            'uses' => 'FloorPlanController@deleteFloorPlanFile',
            'as' => 'floorplans.floorplanfile.delete',
        ]);
    });
});

Route::group(['middleware' => ['auth', 'users.access'], 'prefix' => 'users'], function() { 
    Route::get('/', [
        'uses' => 'UserController@show',
        'as' => 'users',
    ]);
    Route::get('/columns', [
        'uses' => 'UserController@getColumns',
        'as' => 'users.columns',
    ]);
    Route::get('/data', [
        'uses' => 'UserController@getUsers',
        'as' => 'users.data',
    ]);
    Route::post('/insert', [
        'uses' => 'UserController@postUser',
        'as' => 'users.insert',
    ]);
    Route::post('/update', [
        'uses' => 'UserController@putUser',
        'as' => 'users.update',
    ]);
    Route::post('/delete', [
        'uses' => 'UserController@deleteUser',
        'as' => 'users.delete',
    ]);
});