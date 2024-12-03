<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Caregiver;
use App\Models\Member;
use App\Models\MealPlan;
use App\Models\DietaryRequest;
use App\Models\Menu;
use App\Models\FoodService;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $caregiver = $request->user()->caregivers()->firstOrFail();
        // return Member::whereHas('mealPlans', function($query) use ($caregiver) {
        //     $query->where('caregiver_id', $caregiver->id);
        // })->get();
        return Member::all();
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

    ///
    /**
    * View available food services and their meals
    */
    public function viewFoodServices()
    {
        return FoodService::with(['meals' => function($query) {
            $query->where('is_available', true);
        }])->where('status', 'active')->get();
    }



    /**
     * Create menu from food service meals
     */
    public function createMenu(Request $request)
    {
        $request->validate([
            'food_service_id' => 'required|exists:food_services,id',
            'meal_ids' => 'required|array',
            'meal_ids.*' => 'exists:meals,id',
            'meal_type' => 'required|in:breakfast,lunch,dinner',
            'available_date' => 'required|date|after:today',
            'description' => 'required|string'
        ]);
    
        $caregiver = $request->user()->caregivers()->firstOrFail();
        $foodService = FoodService::findOrFail($request->food_service_id);
        
        // Verify all meals belong to the food service
        $meals = $foodService->meals()
            ->whereIn('id', $request->meal_ids)
            ->where('is_available', true)
            ->get();
    
        if ($meals->count() !== count($request->meal_ids)) {
            return response()->json([
                'message' => 'Invalid meal selection'
            ], 422);
        }
    
        $menu = DB::transaction(function() use ($caregiver, $request, $meals) {
            $menu = Menu::create([
                'caregiver_id' => $caregiver->id,
                'meal_type' => $request->meal_type,
                'description' => $request->description,
                'available_date' => $request->available_date,
                'menu_items' => $meals->map(function($meal) {
                    return [
                        'meal_id' => $meal->id,
                        'name' => $meal->name,
                        'description' => $meal->description,
                        'nutritional_info' => $meal->nutritional_info,
                        'dietary_flags' => $meal->dietary_flags
                    ];
                })->toArray(),
                'status' => 'draft'
            ]);
    
            // Create relationship between menu and meals
            $menu->meals()->attach($meals->pluck('id'));
    
            return $menu;
        });
    
        return response()->json([
            'message' => 'Menu created successfully',
            'menu' => $menu->load('meals')
        ]);
    }

    /**
     * Create menu from food service meals
     */
    public function viewMenu(Request $request)
    {
        $caregiver = $request->user()->caregivers()->firstOrFail();
        $menus = $caregiver->menus()->with('meals')->get();

        return response()->json([
            'menus' => $menus
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
            'meal_date' => 'required|date|after:today',
            'dietary_category' => 'nullable|string|in:vegetarian,vegan,gluten-free,dairy-free,halal,kosher,regular',
        ]);

        $caregiver = $request->user()->caregivers()->firstOrFail();
        
        // Verify menu belongs to caregiver
        $menu = $caregiver->menus()->findOrFail($request->menu_id);
        $member = Member::findOrFail($request->member_id);

        // Check if menu items match member's dietary requirements
        $memberDietaryRequirement = $request->dietary_category ?? $member->dietary_requirement;
        
        // Verify menu items are suitable for member's dietary requirements
        // foreach ($menu->menu_items as $item) {
        //     if (!in_array($memberDietaryRequirement, $item['dietary_flags'])) {
        //         return response()->json([
        //             'message' => 'Menu contains items not suitable for member\'s dietary requirements'
        //         ], 422);
        //     }
        // }

        $mealPlan = MealPlan::create([
            'member_id' => $member->id,
            'caregiver_id' => $caregiver->id,
            'menu_id' => $menu->id,
            'meal_type' => $menu->meal_type,
            'meal_date' => $request->meal_date,
            'dietary_category' => $memberDietaryRequirement,
            'status' => 'scheduled'
        ]);

        return response()->json([
            'message' => 'Meal plan published successfully',
            'meal_plan' => $mealPlan->load(['menu', 'member'])
        ]);
    }
}
