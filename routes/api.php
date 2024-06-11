<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Comment\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {

   Route::post('/add-post',[PostController::class, 'addPost']);
   Route::post('/add-comment',[CommentController::class, 'addComment']);
   Route::post('/add-like',[PostController::class, 'addLike']);

   Route::get('/get-post/{id}',[PostController::class, 'getPosts']);
});
