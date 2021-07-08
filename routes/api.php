<?php

use App\Http\Controllers\UserAuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
   // return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('posts',[App\Http\Controllers\PostController::class,'index']);
    Route::get('posts/show/{post}',[App\Http\Controllers\PostController::class,'show']);
    Route::post('posts/store',[App\Http\Controllers\PostController::class,'store']);
    Route::put('posts/update/{id}',[App\Http\Controllers\PostController::class,'update']);
    Route::delete('posts/delete/{id}',[App\Http\Controllers\PostController::class,'delete']);



    Route::get('comments',[App\Http\Controllers\CommentController::class,'index']);
    Route::get('comments/show/{id}',[App\Http\Controllers\CommentController::class,'show']);
    Route::post('comments/store',[App\Http\Controllers\CommentController::class,'store']);
    Route::put('comments/update/{id}',[App\Http\Controllers\CommentController::class,'update']);
    Route::delete('comments/delete/{id}',[App\Http\Controllers\CommentController::class,'delete']);

    
});




/*User Auth Using Sanctum */
Route::post('login',[UserAuthController::class,'login']);