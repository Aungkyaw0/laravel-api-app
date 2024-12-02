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
                'dietary_requirement' => $dietaryRequest->requested_dietary_requirement,
                'prefer_meal' => $dietaryRequest->requested_prefer_meal
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
            'menu_items' => 'required|array|min:1'
        ]);
    
        $caregiver = $request->user()->caregivers()->firstOrFail();
        
        // Create menu with all required fields
        $menu = $caregiver->menus()->create([
            'meal_type' => $fields['meal_type'],
            'description' => $fields['description'],
            'available_date' => $fields['available_date'],
            'menu_items' => json_encode($fields['menu_items']),
            'status' => 'draft'
        ]);
    
        // Decode JSON string for the response
        $menu->menu_items = json_decode($menu->menu_items);
    
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
            'menu_id' => 'required|exists:menus,id',
            'meal_date' => 'required|date',
            'dietary_category' => 'nullable|string|in:vegetarian,vegan,gluten-free,dairy-free,halal,kosher,regular', // Add validation
        ]);
    
        $caregiver = $request->user()->caregivers()->firstOrFail();
        $menu = $caregiver->menus()->findOrFail($request->menu_id);
        $member = Member::findOrFail($request->member_id);
    
        // Get dietary category from request or member's dietary requirement
        $dietaryCategory = $request->dietary_category ?? $member->dietary_requirement;
    
        $mealPlan = MealPlan::create([
            'member_id' => $request->member_id,
            'caregiver_id' => $caregiver->id,
            'menu_id' => $menu->id,
            'meal_type' => $menu->meal_type,
            'meal_date' => $request->meal_date,
            'dietary_category' => $dietaryCategory, // Add this field
            'status' => 'scheduled',
        ]);

        // Load the related menu data
        $mealPlan->load('menu');

        return response()->json([
            'message' => 'Meal plan published successfully',
            'meal_plan' => $mealPlan
        ]);
    }
}
