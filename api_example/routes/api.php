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

Route::get('/articles',['uses' => 'ApiControllers\ArticleController@show' , 'as' => 'articles.get']);
Route::get('/articles/{id}/comments',['uses' => 'ApiControllers\ArticleController@comments' , 'as' => 'articles.comments']);
Route::get('/tags',['uses' => 'ApiControllers\TagController@show' , 'as' => 'tags']);
Route::get('/tags/{id}/articles',['uses' => 'ApiControllers\TagController@articlesByTag' , 'as' => 'tag.articles']);