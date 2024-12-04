<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PartnerFoodServiceController;
use App\Http\Controllers\VolunteerController;


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
    
    //View Avaiable Food Service
    Route::get('/caregiver/food-services', [CaregiverController::class, 'viewFoodServices']);

    // Create menu
    Route::post('/caregiver/menus', [CaregiverController::class, 'createMenu']);
    
    //View Menu which is created by specific caregiver
    Route::get('/caregiver/menus',[CaregiverController::class, 'viewMenu']);

    // Publish meal plans
    Route::post('/caregiver/meal-plans', [CaregiverController::class, 'publishMealPlans']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    // Food Service Management
    Route::post('/partner/food-service', [PartnerFoodServiceController::class, 'createFoodService']);
    Route::get('/partner/food-services/{foodService}/meals', [PartnerFoodServiceController::class, 'getMeals']);
    Route::post('/partner/food-services/{foodService}/meals', [PartnerFoodServiceController::class, 'addMeal']);
    Route::put('/partner/food-services/{foodService}/meals/{meal}', [PartnerFoodServiceController::class, 'updateMeal']);
    Route::put('/partner/food-services/{foodService}/status', [PartnerFoodServiceController::class, 'updateServiceStatus']);
});

//Donor Routes
Route::prefix('donations')->group(function () {
    // Step 1: Initialize donation
    Route::post('/', [DonationController::class, 'processDonation']);
    
    // Step 2: Process payment
    Route::post('/payment', [DonationController::class, 'processPayment']);
});

Route::middleware(['auth:sanctum', 'role:volunteer'])->group(function () {
    Route::get('/volunteer/dashboard', [VolunteerController::class, 'dashboard']);
    Route::post('/volunteer/availability', [VolunteerController::class, 'updateAvailability']);
    Route::post('/volunteer/deliveries/{delivery}/accept', [VolunteerController::class, 'acceptDelivery']);
    Route::post('/volunteer/deliveries/{delivery}/status', [VolunteerController::class, 'updateDeliveryStatus']);
});
