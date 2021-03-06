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
Route::post('/registerusers','Controllers\Usercontroller@register');
Route::post('/registerbyfacebook','Controllers\Usercontroller@registerbyfacebook');
Route::post('/loginuser','Controllers\Usercontroller@login');
Route::post('/updateprofile','Controllers\Usercontroller@updateprofile');
Route::post('/saveToken','Controllers\Usercontroller@saveToken');
Route::post('/getSearchResults','Controllers\Usercontroller@getSearchResults');
Route::post('/profile','Controllers\Usercontroller@profile');
Route::post('/userpagination','Controllers\Usercontroller@userpagination');
Route::post('/userpagination2','Controllers\Usercontroller@userpagination2');
Route::get('/cat','Controllers\CategoriesController@getcat');
Route::post('/posttpagination','Controllers\Postcontroller@index');
Route::post('/posttpagination2','Controllers\Postcontroller@index2');
Route::post('/updatepost','Controllers\Postcontroller@updatepost');
Route::post('/PosttPaginationByUserId','Controllers\Postcontroller@postpagination');
Route::post('/searchPost','Controllers\Postcontroller@getSearchResults');
Route::post('/postById','Controllers\Postcontroller@postById');
Route::post('/commentpagination','Controllers\CommentsController@commentpagination');
Route::post('/addposts','Controllers\Postcontroller@addposts');
Route::post('/addcomment','Controllers\CommentsController@addcomment');
Route::post('/deletecomment','Controllers\CommentsController@deletecomment');
Route::post('/deletepost','Controllers\Postcontroller@deletepost');
Route::post('/updateviews','Controllers\Postcontroller@updateviews');
Route::post('/block_user','Controllers\Usercontroller@block_user');
Route::post('/unblock_user','Controllers\Usercontroller@unblock_user');
Route::post('/all_block_user','Controllers\Usercontroller@all_block_user');
