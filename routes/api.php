<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::get( 'owners', 'OwnerController@index' );
Route::get( 'owners/{owner}', 'OwnerController@show' );
Route::put( 'owners/{owner}', 'OwnerController@update' );
Route::patch( 'owners/{owner}', 'OwnerController@update' );
Route::post( 'owners', 'OwnerController@store' );
Route::delete( 'owners/{owner}', 'OwnerController@destroy' );

Route::get( 'photos', 'PhotoController@index' );