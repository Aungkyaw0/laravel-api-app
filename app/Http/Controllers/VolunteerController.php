<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class VolunteerController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware(function($request, $next) {
                if (Auth::user()->role !== 'volunteer') {
                    return redirect('/login')->with('error', 'Unauthorized access.');
                }
                return $next($request);
            })
        ];
    }

    public function dashboard()
    {
        try {
            $volunteer = Auth::user()->volunteer;
            
            if (!$volunteer) {
                Log::error('Volunteer not found for user: ' . Auth::id());
                return redirect()->route('login')->with('error', 'Volunteer profile not found.');
            }

            // Get order statistics
            $stats = [
                'pending' => Order::where('volunteer_id', $volunteer->id)
                    ->whereIn('delivery_status', ['assigned', 'picked_up', 'in_transit'])
                    ->count(),
                'completed' => Order::where('volunteer_id', $volunteer->id)
                    ->where('delivery_status', 'delivered')
                    ->count()
            ];

            // Get available and active orders
            $availableOrders = Order::with(['member', 'mealPlan', 'partner'])
                ->where('delivery_status', 'pending')
                ->get();
            
            $activeOrders = Order::with(['member', 'mealPlan', 'partner'])
                ->where('volunteer_id', $volunteer->id)
                ->whereIn('delivery_status', ['assigned', 'picked_up', 'in_transit'])
                ->get();

            // Get completed orders
            $completedOrders = Order::with(['member', 'mealPlan', 'partner'])
                ->where('volunteer_id', $volunteer->id)
                ->where('delivery_status', 'delivered')
                ->orderBy('delivery_end_date', 'desc')
                ->get();

            return view('dashboard.volunteer', compact(
                'volunteer',
                'stats',
                'availableOrders',
                'activeOrders',
                'completedOrders'
            ));
        } catch (\Exception $e) {
            Log::error('Volunteer Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to access volunteer dashboard. Please try again.');
        }
    }

    public function updateAvailability(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,unavailable'
        ]);

        $volunteer = Auth::user()->volunteer;
        $volunteer->update(['status' => $validated['status']]);

        return redirect()
                ->route('volunteer.dashboard')
                ->with('success', 'Volunteer Status uccessfully!');
    }

    public function acceptDelivery(Delivery $delivery)
    {
        if ($delivery->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This delivery is no longer available'
            ], 422);
        }

        $volunteer = Auth::user()->volunteer;
        if ($volunteer->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'You must be available to accept deliveries'
            ], 422);
        }

        $delivery->update([
            'volunteer_id' => $volunteer->id,
            'status' => 'assigned'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Delivery accepted successfully'
        ]);
    }

    public function updateDeliveryStatus(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'status' => 'required|in:picked_up,in_transit,delivered'
        ]);

        if ($delivery->volunteer_id !== Auth::user()->volunteer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this delivery'
            ], 403);
        }

        $delivery->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Delivery status updated successfully'
        ]);
    }

    public function completeDelivery(Request $request, Order $delivery)
    {
        try {
            $validated = $request->validate([
                'confirmation_code' => 'required|string',
                'delivery_notes' => 'nullable|string'
            ]);

            $mealPlan = $delivery->mealPlan;
            
            // Check if volunteer is authorized for this delivery
            if ($delivery->volunteer_id !== Auth::user()->volunteer->id) {
                return redirect()
                    ->route('volunteer.dashboard')
                    ->with('error', 'You are not authorized to complete this delivery.');
            }

            // Case-sensitive confirmation code check
            if ($validated['confirmation_code'] !== $delivery->delivery_confirmation_code) {
                return redirect()
                    ->route('volunteer.dashboard')
                    ->with('error', 'Invalid confirmation code. Please check and try again.');
            }

            // Update the delivery
            $delivery->update([
                'delivery_status' => 'delivered',
                'delivery_end_date' => now(),
                'delivery_notes' => $validated['delivery_notes']
            ]);

            $mealPlan->update([
                'status' => 'completed'
            ]);

            return redirect()
                ->route('volunteer.dashboard')
                ->with('success', 'Delivery completed successfully!');

        } catch (\Exception $e) {
            Log::error('Delivery Completion Error: ' . $e->getMessage());
            return redirect()
                ->route('volunteer.dashboard')
                ->with('error', 'Unable to complete delivery. Please try again.');
        }
    }

    public function acceptOrder(Order $order)
    {
        try {
            // Check if order is still pending
            if ($order->delivery_status !== 'pending') {
                return redirect()
                    ->route('volunteer.dashboard')
                    ->with('error', 'This order is no longer available.');
            }

            $volunteer = Auth::user()->volunteer;
            
            // Check if volunteer is available
            if ($volunteer->status !== 'available') {
                return redirect()
                    ->route('volunteer.dashboard')
                    ->with('error', 'You must be available to accept orders.');
            }

            // Update the order
            $order->update([
                'volunteer_id' => $volunteer->id,
                'delivery_status' => 'assigned'
            ]);

            return redirect()
                ->route('volunteer.dashboard')
                ->with('success', 'Order accepted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Order Accept Error: ' . $e->getMessage());
            return redirect()
                ->route('volunteer.dashboard')
                ->with('error', 'Unable to accept order. Please try again.');
        }
    }
}
