<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\MealPlan;
use App\Models\DietaryRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MemberController extends Controller implements HasMiddleware
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
        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'dietary_requirement' => 'required|string',
            'prefer_meal' => 'required|string',
        ]);
        //$post = Member::create($fields);
        //$post = $request->user()->members()->create($fields);
        $post = $user->members()->create($fields);
        return $post; #return json data
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return $member;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

    /**
     * Fetch meal plans for a member
     */
    public function viewMealPlans(Request $request)
    {
        $member = $request->user()->members()->first();
        
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        // Fetch meal plans considering member's dietary requirements
        $mealPlans = MealPlan::where('dietary_category', $member->dietary_requirement)
            ->orWhere('is_general', true)
            ->get();

        return response()->json([
            'meal_plans' => $mealPlans,
            'current_preferences' => [
                'dietary_requirement' => $member->dietary_requirement,
                'prefer_meal' => $member->prefer_meal
            ]
        ]);
    }

    /**
     * Update member's dietary preferences
     */
    public function updatePreferences(Request $request)
    {
        $member = $request->user()->members()->first();
        
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        $fields = $request->validate([
            'dietary_requirement' => 'required|string',
            'prefer_meal' => 'required|string',
        ]);

        $member->update($fields);

        return response()->json([
            'message' => 'Preferences updated successfully',
            'member' => $member
        ]);
    }

    /**
     * Submit a dietary update request
     */
    public function submitDietRequest(Request $request)
    {
        $member = $request->user()->members()->first();
        
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        $fields = $request->validate([
            'reason' => 'required|string',
            'new_dietary_requirement' => 'required|string',
            'new_prefer_meal' => 'required|string',
            'additional_notes' => 'nullable|string'
        ]);

        // Create dietary request
        $dietaryRequest = DietaryRequest::create([
            'member_id' => $member->id,
            'current_dietary_requirement' => $member->dietary_requirement,
            'current_prefer_meal' => $member->prefer_meal,
            'requested_dietary_requirement' => $fields['new_dietary_requirement'],
            'requested_prefer_meal' => $fields['new_prefer_meal'],
            'reason' => $fields['reason'],
            'additional_notes' => $fields['additional_notes'] ?? null,
            'status' => 'pending'
        ]);

        // Here you would typically dispatch a notification to caregivers
        // event(new DietaryRequestSubmitted($dietaryRequest));

        return response()->json([
            'message' => 'Dietary request submitted successfully',
            'request' => $dietaryRequest
        ]);
    }
}
