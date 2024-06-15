<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Share\ShareController;

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
   Route::post('/share-post',[ShareController::class, 'sharePost']);
   Route::get('/get-post/{id}',[PostController::class, 'getPosts']);

});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//profile

// Route::get('/profile/getProfilePhoto', [ProfileController::class, 'getProfilePhoto']);
Route::post('/profile/update-profile',[ProfileController::class,'update_profile'])->middleware('auth:sanctum');



