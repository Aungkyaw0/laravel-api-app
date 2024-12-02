<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use App\Models\Member;
use App\Models\MealPlan;
use App\Models\User;
use App\Models\DietaryRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class CaregiverController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Caregiver::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:16', // Adjust min age as needed
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'experience' => 'required|string',
            'availability' => 'required|in:part-time,full-time',
        ]);
        $post = $user->caregivers()->create($fields);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Caregiver $caregiver)
    {
        return $caregiver;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caregiver $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caregiver $member)
    {
        //
    }

    /**
     * Fetch all members assigned to the caregiver
     */
    public function viewMembers(Request $request)
    {
        $caregiver = $request->user()->caregivers()->firstOrFail();
        return Member::whereHas('mealPlans', function($query) use ($caregiver) {
            $query->where('caregiver_id', $caregiver->id);
        })->get();
    }

    /**
     * Update dietary preferences for a specific member
     */
    public function updateMemberNeeds(Request $request, Member $member)
    {
        $fields = $request->validate([
            'dietary_requirement' => 'required|string', 
            'prefer_meal' => 'required|string'
        ]);

        $member->update($fields);
        return response()->json([
            'message' => 'Member dietary needs updated successfully',
            'member' => $member
        ]);
    }

    /**
     * Manage dietary update requests
     */
    public function manageDietaryRequests(Request $request, $requestId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $dietaryRequest = DietaryRequest::findOrFail($requestId);
        $caregiver = $request->user()->caregivers()->firstOrFail();

        $dietaryRequest->update([
            'status' => $request->status,
            'caregiver_id' => $caregiver->id
        ]);

        if ($request->status === 'approved') {
            $member = Member::findOrFail($dietaryRequest->member_id);
            $member->update([
                'dietary_requirement' => $dietaryRequest->new_dietary_preferences
            ]);
        }

        return response()->json([
            'message' => "Dietary request {$request->status}",
            'request' => $dietaryRequest
        ]);
    }

    /**
     * Manage meal menus
     */
    public function manageMenu(Request $request)
    {
        $fields = $request->validate([
            'meal_type' => 'required|string',
            'description' => 'required|string',
            'available_date' => 'required|date',
            'menu_items' => 'required|json',
            'nutritional_info' => 'required|json'
        ]);

        $caregiver = $request->user()->caregivers()->firstOrFail();
        $menu = $caregiver->menus()->create($fields);

        return response()->json([
            'message' => 'Menu created successfully',
            'menu' => $menu
        ]);
    }

    /**
     * Publish meal plans for members
     */
    public function publishMealPlans(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'meal_type' => 'required|string',
            'meal_date' => 'required|date',
        ]);

        $caregiver = $request->user()->caregivers()->firstOrFail();
        
        $mealPlan = MealPlan::create([
            'member_id' => $request->member_id,
            'caregiver_id' => $caregiver->id,  // Add this line
            'meal_type' => $request->meal_type,
            'meal_date' => $request->meal_date,
            'status' => 'scheduled'
        ]);

        return response()->json([
            'message' => 'Meal plan published successfully',
            'meal_plan' => $mealPlan
        ]);
    }
}
