<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\FriendRequestController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/user',[AuthController::class,'user'])->middleware('auth:sanctum');

Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::post('/forgot_password',[NewPasswordController::class,'forgotpassword']);

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
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('register');