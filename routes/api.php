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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('authors', 'AuthorController@author');
    Route::get('authors/{id}', 'AuthorController@authorByID');
    Route::post('authors', 'AuthorController@authorSave');
    Route::put('authors/{id}', 'AuthorController@authorUpdate');
    Route::delete('authors/{id}', 'AuthorController@authorDelete');

    Route::resource('books', 'BookController');

});


Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/users/{id}', 'AuthController@get');
