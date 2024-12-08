<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminMemberController;

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
        Route::post('/create-order', [MemberController::class, 'createOrder'])->name('member.create-order');
        Route::post('/orders/{order}/confirm-delivery', [MemberController::class, 'confirmDelivery'])
            ->name('member.confirm-delivery');
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
    Route::post('/orders/{order}/accept', [PartnerController::class, 'acceptOrder'])->name('partner.accept-order');
});

// Volunteer Routes
Route::prefix('volunteer')->group(function () {
    Route::get('/dashboard', [VolunteerController::class, 'dashboard'])->name('volunteer.dashboard');
    Route::post('/availability', [VolunteerController::class, 'updateAvailability'])->name('volunteer.update-availability');
    Route::post('/deliveries/{delivery}/accept', [VolunteerController::class, 'acceptDelivery'])->name('volunteer.accept-delivery');
    Route::post('/deliveries/{delivery}/reject', [VolunteerController::class, 'rejectDelivery'])->name('volunteer.reject-delivery');
    Route::post('/deliveries/{delivery}/status', [VolunteerController::class, 'updateDeliveryStatus'])->name('volunteer.update-delivery-status');
    Route::get('/deliveries/{delivery}/route', [VolunteerController::class, 'getDeliveryRoute'])->name('volunteer.delivery-route');
    Route::post('/deliveries/{delivery}/complete', [VolunteerController::class, 'completeDelivery'])->name('volunteer.complete-delivery');
    Route::post('/orders/{order}/accept', [VolunteerController::class, 'acceptOrder'])->name('volunteer.accept-order');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/members/{id}', [AdminController::class, 'updateMember'])->name('admin.members.update');
    Route::put('/caregivers/{id}', [AdminController::class, 'updateCaregiver'])->name('admin.caregivers.update');
    Route::put('/partners/{id}', [AdminController::class, 'updatePartner'])->name('admin.partners.update');
    Route::put('/volunteers/{id}', [AdminController::class, 'updateVolunteer'])->name('admin.volunteers.update');
    Route::delete('/members/{id}', [AdminController::class, 'destroyMember'])->name('admin.members.destroy');
    Route::delete('/caregivers/{id}', [AdminController::class, 'destroyCaregiver'])->name('admin.caregivers.destroy');
    Route::delete('/partners/{id}', [AdminController::class, 'destroyPartner'])->name('admin.partners.destroy');
    Route::delete('/volunteers/{id}', [AdminController::class, 'destroyVolunteer'])->name('admin.volunteers.destroy');
    Route::put('/food-services/{id}/activate', [AdminController::class, 'activateFoodService'])->name('admin.food-services.activate');
});





