<?php

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
    
Route::apiResource("posts",PostController::class);

#This route is for managing the Member
Route::apiResource("admin/member",
MemberController::class);

#This route is for member registeration
Route::post('/registers/member',
 [AuthController::class, 'registerMember']);

#This route is for login
Route::post('/login',
 [AuthController::class, 'login']);

//Protected route with middleware
Route::get('/logout', 
[AuthController::class, 'logout'])->middleware('auth:sanctum');
