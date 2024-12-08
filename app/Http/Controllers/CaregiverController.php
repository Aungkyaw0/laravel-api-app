<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Caregiver;
use App\Models\Member;
use App\Models\Partner;
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
use App\Services\DeliveryService;
use App\Services\RouteService;
use App\Services\MealTypeService;   

use Illuminate\Support\Facades\Log;

class CaregiverController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
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
     * Fetch all members assigned to the caregiver
     */
    public function viewMembers(Request $request)
    {
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
        $caregiver = $request->user()->caregiver;

        $dietaryRequest->update([
            'status' => $request->status,
            'caregiver_id' => $caregiver->id
        ]);

        // If approved, update member's dietary preferences
        if ($request->status === 'approved') {
            $member = Member::findOrFail($dietaryRequest->member_id);
            $member->update([
                'dietary_requirement' => $dietaryRequest->requested_dietary_requirement,
                'prefer_meal' => $dietaryRequest->requested_prefer_meal
            ]);
            
            $message = 'Dietary request approved successfully. Member preferences have been updated.';
        } else {
            $message = 'Dietary request rejected successfully.';
        }

        return redirect()->route('caregiver.dashboard')->with('success', $message);
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
        $validated = $request->validate([
            'name' => 'required|string',
            'food_service_id' => 'required|exists:food_services,id',
            'meal_ids' => 'required|array',
            'meal_ids.*' => 'exists:meals,id',
            'meal_type' => 'required|in:breakfast,lunch,dinner',
            'available_date' => 'required|date|after:today',
            'description' => 'required|string'
        ]);

        $caregiver = $request->user()->caregiver;
        $foodService = FoodService::findOrFail($request->food_service_id);
        $meals = $foodService->meals()
            ->whereIn('id', $request->meal_ids)
            ->where('is_available', true)
            ->get();
        try {
            // Create the menu
            $menu = Menu::create([
                'name' => $validated['name'],
                'caregiver_id' => $caregiver->id,
                'partner_id' => $foodService['partner_id'],
                'meal_type' => $validated['meal_type'],
                'description' => $validated['description'],
                'available_date' => $validated['available_date'],
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

            // Attach the selected meals to the menu
            $menu->meals()->attach($validated['meal_ids']);

            // Redirect with success message
            return redirect()
                ->route('caregiver.dashboard')
                ->with('success', 'Menu created successfully!');
                
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()
                ->route('caregiver.dashboard')
                ->with('error', 'Failed to create menu. Please try again.');
        }
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
        ]);

        try {
            $member = Member::findOrFail($request->member_id);
            $menu = Menu::findOrFail($request->menu_id);
            $caregiver = Auth::user()->caregiver;
            
            // Get partner information through the menu
            $partner = Partner::findOrFail($menu->partner_id);

            // Extract city from locations (assuming format includes city)
            $memberCity = explode(',', $member->address)[0];
            $partnerCity = explode(',', $partner->location)[0];

            // Check if cities match (case-insensitive)
            if (strtolower(trim($memberCity)) !== strtolower(trim($partnerCity))) {
                return redirect()
                    ->route('caregiver.dashboard')
                    ->with('error', "Can't Create Meal Plan, Location is Out of Kitchen Service");
            }

            // Calculate distance between member and partner
            $distance = $this->calculateDistance(
                $member->latitude,
                $member->longitude,
                $partner->latitude,
                $partner->longitude
            );

            // Determine delivery meal type based on distance
            $deliverMealType = $distance <= 10 ? 'Hot Meal' : 'Frozen Meal';

            // Create the meal plan
            $mealPlan = MealPlan::create([
                'member_id' => $member->id,
                'caregiver_id' => $caregiver->id,
                'menu_id' => $menu->id,
                'partner_id' => $partner->id,
                'deliver_meal_type' => $deliverMealType,
                'meal_date' => $request->meal_date,
                'is_general' => true,
                'dietary_category' => $member->dietary_requirement,
                'status' => 'scheduled'
            ]);

            $menu->update([
                'status' => 'published'
            ]);


            return redirect()
                ->route('caregiver.dashboard')
                ->with('success', 'Meal plan assigned successfully to ' . $member->name);

        } catch (\Exception $e) {
            Log::error('Meal Plan Creation Error: ' . $e->getMessage());
            return redirect()
                ->route('caregiver.dashboard')
                ->with('error', 'Failed to assign meal plan. Please try again.');
        }
    }

    /**
     * Calculate distance between two points using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in kilometers
    }

    /**
     * View pending dietary requests
     */
    public function viewPendingDietaryRequests()
    {
        $pendingRequests = DietaryRequest::with('member')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'pending_requests' => $pendingRequests
        ]);
    }

    public function dashboard()
    {
        try {
            $caregiver = Auth::user()->caregiver;
            
            $members = Member::all();
            $foodServices = FoodService::with(['meals' => function($query) {
                $query->where('is_available', 1);
            }])->where('status', 'active')->get();

            $partner = 

            $activeMenus = Menu::where('caregiver_id', $caregiver->id)
                ->where('status', 'published')
                ->count();

            $draftMenus = Menu::where('caregiver_id', $caregiver->id)
                ->where('status', 'draft')
                ->count();

            $menus = Menu::where('caregiver_id', $caregiver->id)
                ->orderBy('available_date', 'desc')
                ->take(5)
                ->get();

            // Add this line to fetch pending dietary requests
            $pendingRequests = DietaryRequest::with('member')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('dashboard.caregiver', compact('members', 'foodServices', 'activeMenus', 'draftMenus', 'menus', 'pendingRequests'));
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to access caregiver dashboard.');
        }
    }

    public function viewMeals(FoodService $service)
    {
        $meals = $service->meals()->get();

        return view('dashboard.caregiver.view-meals', compact('service', 'meals'));
    }
}
