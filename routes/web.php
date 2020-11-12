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

Route::get('/', 'HomeController@show');

Route::group(['prefix' => 'home'], function() { 
    Route::get('/', 'HomeController@show');
});

Route::group(['prefix' => 'user-management'], function() { 
    Route::get('/', 'UserController@show');
});

Route::get('get-floor-plan-columns', 'HomeController@getFloorPlanColumns');
Route::get('get-floor-plans', 'HomeController@getFloorPlans');
Route::post('insert-floor-plan', 'HomeController@postFloorPlan');
Route::post('update-floor-plan', 'HomeController@putFloorPlan');
Route::post('delete-floor-plan', 'HomeController@deleteFloorPlan');