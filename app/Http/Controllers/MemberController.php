<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\DietaryRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use App\Models\MealPlan;
use App\Models\Order;

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
        $mealPlans = MealPlan::where('member_id', Auth::user()->member->id)
                             ->where('status', 'scheduled')
                             ->get();

        return view('dashboard.member', compact('mealPlans'));
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

    public function createOrder(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'meal_plan_id' => 'required|exists:meal_plans,id'
            ]);

            // Get the meal plan
            $mealPlan = MealPlan::with(['caregiver','partner'])->findOrFail($request->meal_plan_id);
            
            // Check if order already exists
            $existingOrder = Order::where('meal_plan_id',$mealPlan->id)
                ->where('member_id', Auth::user()->member->id)
                ->first();

            if ($existingOrder) {
                return back()->with('error', 'An order already exists for this mealplan.');
            }

            // Create new order
            $order = Order::create([
                'member_id' => $mealPlan->member_id,
                'caregiver_id' => $mealPlan->caregiver_id,
                'partner_id' => $mealPlan->partner_id,
                'meal_plan_id' => $mealPlan->id,
                'delivery_status' => 'pending',
                'delivery_meal_type' => $mealPlan->deliver_meal_type
            ]);

            return back()->with('success', 'Order requested successfully!');
        } catch (\Exception $e) {
            Log::error('Order creation error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create order. Please tryagain.');
        }
    }

    public function confirmDelivery(Request $request, Order $order)
    {
        try {
            // Validate request
            $request->validate([
                'confirmation_code' => 'required|string'
            ]);

            // Check if the order belongs to the authenticated user
            if ($order->member_id !== Auth::user()->member->id) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Update the delivery confirmation code
            $order->update([
                'delivery_confirmation_code' => $request->confirmation_code
            ]);

            return back()->with('success', 'Delivery confirmed successfully!');
        } catch (\Exception $e) {
            Log::error('Delivery confirmation error: ' . $e->getMessage());
            return back()->with('error', 'Unable to confirm delivery. Please try again.');
        }
    }
}
