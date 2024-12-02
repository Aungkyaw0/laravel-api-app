<?php

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
    
Route::apiResource("posts",PostController::class);
=======
use App\Http\Controllers\CaregiverController;
use App\Models\Caregiver;

>>>>>>> bra

#This route is for managing the Member
Route::apiResource("admin/member",
MemberController::class);

<<<<<<< HEAD
=======
#This route is for managing the Member
Route::apiResource("admin/caregiver",
CaregiverController::class);


>>>>>>> bra
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
<<<<<<< HEAD
=======


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/member/meal-plans', [MemberController::class, 'viewMealPlans']);
    Route::put('/member/preferences', [MemberController::class, 'updatePreferences']);
    Route::post('/member/diet-request', [MemberController::class, 'submitDietRequest']);
});

//Caregiver
// Additional caregiver routes - should be protected with auth:sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // View assigned members
    Route::get('/caregiver/members', [CaregiverController::class, 'viewMembers']);
    
    // Update member dietary needs
    Route::put('/caregiver/member/{member}/needs', [CaregiverController::class, 'updateMemberNeeds']);
    
    // Manage dietary requests
    Route::put('/caregiver/dietary-requests/{requestId}', [CaregiverController::class, 'manageDietaryRequests']);
    
    // Manage menu
    Route::post('/caregiver/menu', [CaregiverController::class, 'manageMenu']);
    
    // Publish meal plans
    Route::post('/caregiver/meal-plans', [CaregiverController::class, 'publishMealPlans']);
});
>>>>>>> bra
