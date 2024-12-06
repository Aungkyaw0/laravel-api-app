<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\DietaryRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
class MemberController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware(function($request, $next) {
                if (Auth::user()->role !== 'member') {
                    return redirect('/login')->with('error', 'Unauthorized access.');
                }
                return $next($request);
            })
        ];
    }

    public function dashboard()
    {
        try {
            $member = Auth::user()->member;
            
            // Check if member relationship exists
            if (!$member) {
                Auth::logout();
                return redirect('/login')->with('error', 'Member profile not found.');
            }

            // Fetch meal plans for the member with error handling
            $mealPlans = $member->mealPlans()
                ->with(['caregiver', 'menu'])
                ->orderBy('meal_date', 'desc')
                ->get();

            // Check if relationships are properly loaded
            $mealPlans = $mealPlans->map(function ($mealPlan) {
                if (!$mealPlan->caregiver) {
                    $mealPlan->caregiver = new \App\Models\Caregiver(['name' => 'Unassigned']);
                }
                if (!$mealPlan->menu) {
                    $mealPlan->menu = new \App\Models\Menu(['name' => 'Menu Pending']);
                }
                return $mealPlan;
            });

            return view('dashboard.member', compact('member', 'mealPlans'));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Member dashboard error: ' . $e->getMessage());
            
            // Return to login with error message
            return redirect('/login')->with('error', 'Unable to load dashboard. Please try again.');
        }
    }

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'prefer_meal' => 'required|in:hot,frozen,both',
            'dietary_requirement' => 'required|in:none,vegetarian,vegan,halal,gluten-free'
        ]);

        Auth::user()->member->update($request->only(['prefer_meal', 'dietary_requirement']));

        return back()->with('success', 'Preferences updated successfully!');
    }

    public function specialRequest(Request $request)
    {
        $member = $request->user()->member;

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

        // Add logic to handle special meal requests

        return back()->with('success', 'Special meal request submitted successfully!');
    }

    public function contactSupport(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        // Add logic to handle support requests

        return back()->with('success', 'Support request sent successfully!');
    }

    public function viewMealPlans()
    {
        try {
            $member = Auth::user()->member;
            $mealPlans = $member->mealPlans()
                ->with(['caregiver', 'menu'])
                ->orderBy('meal_date', 'desc')
                ->get();

            return view('dashboard.member', compact('member', 'mealPlans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to fetch meal plans.');
        }
    }
}
