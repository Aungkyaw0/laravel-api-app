<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\FoodService;
use App\Models\Meal;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\HasMiddleware;   
use Illuminate\Routing\Controllers\Middleware;

class PartnerController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware(function($request, $next) {
                if (Auth::user()->role !== 'partner') {
                    return redirect('/login')->with('error', 'Unauthorized access.');
                }
                return $next($request);
            })
        ];
    }

    public function dashboard()
    {
        try {
            $partner = Auth::user()->partner;
            
            if (!$partner) {
                Log::error('Partner not found for user: ' . Auth::id());
                return redirect()->route('login')->with('error', 'Partner profile not found.');
            }
            
            // Fetch statistics
            $activeFoodServices = FoodService::where('partner_id', $partner->id)
                ->where('status', 'active')
                ->count();

            // Fetch food services
            $foodServices = FoodService::where('partner_id', $partner->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Fetch pending orders
            $pendingOrders = Order::where('partner_id', $partner->id)
                ->where('partner_status', 'pending')
                ->with(['member', 'mealPlan', 'menu'])
                ->get();

            // Fetch accepted orders
            $acceptedOrders = Order::where('partner_id', $partner->id)
                ->where('partner_status', 'accepted')
                ->where('delivery_status', 'assigned')
                ->with(['member', 'mealPlan', 'menu'])
                ->get();

            return view('dashboard.partner', compact(
                'activeFoodServices',
                'foodServices',
                'partner',
                'pendingOrders',
                'acceptedOrders'
            ));
        } catch (\Exception $e) {
            Log::error('Partner Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to access partner dashboard. Please try again.');
        }
    }

    public function createFoodService(Request $request)
    {
        $fields = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'cuisine_type' => 'required|string',
            'service_area' => 'required|string',
            'operating_hours' => 'required|array'
        ]);

        $partner = Auth::user()->partner;
    

        $fields['partner_id'] = $partner->id;
        $fields['status'] = 'pending';

        $foodService = FoodService::create($fields);

        return redirect()->route('partner.dashboard')
            ->with('success', 'Food service created successfully and pending approval');
    }

    public function getMeals(FoodService $foodService)
    {
        if ($foodService->partner_id !== Auth::user()->partner->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($foodService->meals);
    }

    public function addMeal(Request $request, FoodService $foodService)
    {
        try {
            if ($foodService->partner_id !== Auth::user()->partner->id) {
                return back()->with('error', 'Unauthorized action.');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ingredients' => 'required|string', // Will split by lines later
                'nutritional_info' => 'required|array',
                'meal_type' => 'required|in:breakfast,lunch,dinner',
                'dietary_flags' => 'required|array'
            ]);

            // Convert ingredients textarea to array
            $validated['ingredients'] = array_filter(explode("\n", $validated['ingredients']));

            $meal = $foodService->meals()->create($validated);

            return back()->with('meal_success', 'Meal added successfully');

        } catch (\Exception $e) {
            Log::error('Add Meal Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create meal. ' . $e->getMessage()]);
        }
    }

    public function updateMeal(Request $request, FoodService $foodService, Meal $meal)
    {
        if ($foodService->partner_id !== Auth::user()->partner->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'ingredients' => 'array',
            'nutritional_info' => 'array',
            'meal_type' => 'in:breakfast,lunch,dinner',
            'dietary_flags' => 'array',
            'is_available' => 'boolean'
        ]);

        $meal->update($validated);
        return response()->json($meal);
    }

    public function updateServiceStatus(Request $request, FoodService $foodService)
    {
        if ($foodService->partner_id !== Auth::user()->partner->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $foodService->update($validated);
        return response()->json($foodService);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email',
            'phone' => 'required|string',
            'location' => 'required|string',
            'business_type' => 'required|string|in:restaurant,catering,food_bank,other',
            'service_offer' => 'required|string'
        ]);

        $partner = Auth::user()->partner;
        $partner->update($validated);

        return redirect()->route('partner.dashboard')
            ->with('success', 'Profile updated successfully');
    }

    public function acceptOrder(Order $order)
    {
        try {
            if ($order->partner_id !== Auth::user()->partner->id) {
                return back()->with('error', 'Unauthorized action.');
            }

            $order->update([
                'partner_status' => 'accepted',
                'delivery_start_date' => now()
            ]);

            return redirect()->route('partner.dashboard')
            ->with('success', 'Order Accepted Successfully');
            
        } catch (\Exception $e) {
            Log::error('Accept Order Error: ' . $e->getMessage());
            return redirect()->route('partner.dashboard')
            ->with('error', 'Failed to accept order. Please try again.');
        }
    }
}