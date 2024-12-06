<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\VolunteerController;


// Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/donate', [PageController::class, 'donate'])->name('donate');
Route::post('/contact/submit', [PageController::class, 'submitContact'])->name('contact.submit');
Route::post('/donation/process', [DonationController::class, 'process'])->name('donation.process');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registers/member', [AuthController::class, 'registerMember'])->name('registers.member');
Route::post('/registers/caregiver', [AuthController::class, 'registerCaregiver'])->name('registers.caregiver');
Route::post('/registers/partner', [AuthController::class, 'registerPartner'])->name('registers.partner');
Route::post('/registers/volunteer', [AuthController::class, 'registerVolunteer'])->name('registers.volunteer');

// Donation Routes
Route::prefix('donations')->group(function () {
    Route::post('/', [DonationController::class, 'processDonation']);
    Route::post('/payment', [DonationController::class, 'processPayment']);
});

// Member Routes
Route::prefix('member')->group(function () {
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
        Route::put('/update-preferences', [MemberController::class, 'updatePreferences'])->name('member.update-preferences');
        Route::post('/special-request', [MemberController::class, 'specialRequest'])->name('member.special-request');
        Route::post('/contact-support', [MemberController::class, 'contactSupport'])->name('member.contact-support');
        Route::get('/meal-plans', [MemberController::class, 'viewMealPlans'])->name('member.meal-plans');
    });

// Caregiver Routes
Route::prefix(prefix: 'caregiver')->group(function () {
    Route::get('/dashboard', [CaregiverController::class, 'dashboard'])->name('caregiver.dashboard');
    Route::get('/members', [CaregiverController::class, 'viewMembers'])->name('caregiver.members');
    Route::post('/member/{member}/update-needs', [CaregiverController::class, 'updateMemberNeeds'])->name('caregiver.member.update-needs');
    Route::get('/food-services', [CaregiverController::class, 'viewFoodServices'])->name('caregiver.food-services');
    Route::post('/menu/create', [CaregiverController::class, 'createMenu'])->name('caregiver.menu.create');
    Route::get('/member/{member}', [CaregiverController::class, 'viewMember'])->name('caregiver.member.view');
    Route::get('/dietary-requests', [CaregiverController::class, 'viewPendingDietaryRequests'])
        ->name('caregiver.dietary-requests');
    Route::post('/dietary-requests/{requestId}', [CaregiverController::class, 'manageDietaryRequests'])
        ->name('caregiver.manage-dietary-requests');
    Route::get('/food-services/{service}/meals', [CaregiverController::class, 'viewMeals'])
        ->name('caregiver.food-services.meals');
    Route::post('/meal-plan/publish', [CaregiverController::class, 'publishMealPlans'])
        ->name('caregiver.publish-meal-plan');
});

// Partner Routes
Route::prefix('partner')->group(function () {
    Route::get('/dashboard', [PartnerController::class, 'dashboard'])->name('partner.dashboard');
    Route::post('/food-service', [PartnerController::class, 'createFoodService'])->name('partner.food-services.store');
    Route::get('/food-services/{foodService}/meals', [PartnerController::class, 'getMeals'])->name('partner.food-service.meals');
    Route::post('/food-services/{foodService}/meals', [PartnerController::class, 'addMeal'])->name('partner.food-service.add-meal');
    Route::put('/food-services/{foodService}/meals/{meal}', [PartnerController::class, 'updateMeal'])->name('partner.food-service.update-meal');
    Route::put('/food-services/{foodService}/status', [PartnerController::class, 'updateServiceStatus'])->name('partner.food-service.update-status');
    Route::post('/profile/update', [PartnerController::class, 'updateProfile'])->name('partner.profile.update');
});

// Volunteer Routes
Route::prefix('volunteer')->group(function () {
    Route::get('/dashboard', [VolunteerController::class, 'dashboard'])->name('volunteer.dashboard');
    Route::post('/availability', [VolunteerController::class, 'updateAvailability'])->name('volunteer.update-availability');
    Route::post('/deliveries/{delivery}/accept', [VolunteerController::class, 'acceptDelivery'])->name('volunteer.accept-delivery');
    Route::post('/deliveries/{delivery}/status', [VolunteerController::class, 'updateDeliveryStatus'])->name('volunteer.update-delivery-status');
});



