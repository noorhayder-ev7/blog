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
Route::post('/users','Controllers\Usercontroller@register');
Route::post('/user','Controllers\Usercontroller@login');
Route::post('/profile','Controllers\Usercontroller@profile');
Route::get('/cat','Controllers\CategoriesController@getcat');
Route::get('/posttpagination','Controllers\Postcontroller@index');
Route::post('/posttpagination','Controllers\Postcontroller@index2');
Route::post('/commentpagination','Controllers\CommentsController@commentpagination');
Route::post('/getpost','Controllers\Postcontroller@getposts');
Route::post('/getcomment','Controllers\CommentsController@getcomment');
Route::post('/deletecomment','Controllers\CommentsController@deletecomment');
Route::post('/deletepost','Controllers\Postcontroller@deletepost');
Route::post('/updateviews','Controllers\Postcontroller@updateviews');
