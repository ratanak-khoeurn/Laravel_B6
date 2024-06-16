<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Comment\CommentShareController;
use App\Http\Controllers\Like\LikeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user',[AuthController::class,'user'])->middleware('auth:sanctum');

// ROUTE FOR SEND FRIEND REQUEST
    Route::post('/send-friend-request', [FriendRequestController::class, 'sendFriendRequest']);
    Route::put('accept-friend-request/{id}', [FriendRequestController::class, 'acceptFriendRequest']);
    Route::delete('reject-friend-request/{id}', [FriendRequestController::class, 'rejectFriendRequest']);

    Route::middleware('auth:sanctum')->group(function () {
        // Route for fetching friend requests
        Route::get('/friend-requests', [FriendRequestController::class, 'index']);
        // Route for sending a friend request
        Route::post('/send-friend-request', [FriendRequestController::class, 'addfriend']);
        // Route for updating a friend request (accept or reject)
        Route::put('/friend-accept/{id}', [FriendRequestController::class, 'acceptfriend']);
        // Route for deleting a friend request
        Route::delete('/friend-requests/{id}', [FriendRequestController::class, 'rejectfriend']);
        // Route for fetching the list of friends
        Route::get('/friends-list', [FriendRequestController::class, 'friendsList']);
    });

// THIS ROUT FOR SWAGGER
Route::get('users/list', [AuthController::class, 'index'])->name('user.profile.list');
Route::middleware('auth:sanctum')->group(function() {
   Route::post('/add-post',[PostController::class, 'addPost']);
   Route::post('/add-comment-post',[CommentController::class, 'addComment']);
   Route::post('/add-comment-share',[CommentShareController::class, 'CommentShare']);
   Route::post('/add-like',[PostController::class, 'addLike']);
   Route::post('/like-share',[LikeController::class, 'likeShare']);
   Route::post('/share-post',[ShareController::class, 'sharePost']);
   Route::get('/get-post/{id}',[PostController::class, 'getPosts']);
   Route::get('/get-share/{id}', [ShareController::class, 'getShare']);
});
  
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//profile
Route::post('/profile/update-profile',[ProfileController::class,'update_profile'])->middleware('auth:sanctum');

