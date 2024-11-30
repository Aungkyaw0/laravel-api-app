<?php

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaregiverController;
use App\Models\Caregiver;


#This route is for managing the Member
Route::apiResource("admin/member",
MemberController::class);

#This route is for managing the Member
Route::apiResource("admin/caregiver",
CaregiverController::class);


#This route is for member registeration
Route::post('/registers/member',
 [AuthController::class, 'registerMember']);

 #This route is for caregiver registeration
Route::post('/registers/caregiver',
[AuthController::class, 'registerCaregiver']);

#This route is for partner registeration
Route::post('/registers/partner',
 [AuthController::class, 'registerPartner']);

#This route is for volunteer registeration
Route::post('/registers/volunteer',
 [AuthController::class, 'registerVolunteer']);

#This route is for login
Route::post('/login',
 [AuthController::class, 'login']);

//Protected route with middleware
Route::get('/logout', 
[AuthController::class, 'logout'])->middleware('auth:sanctum');
