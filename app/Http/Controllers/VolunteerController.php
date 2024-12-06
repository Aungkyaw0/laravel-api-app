<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Delivery;
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

            // Get delivery statistics
            $stats = [
                'pending' => Delivery::where('volunteer_id', $volunteer->id)
                    ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
                    ->count(),
                'completed' => Delivery::where('volunteer_id', $volunteer->id)
                    ->where('status', 'delivered')
                    ->count()
            ];

            // Get available and active deliveries
            $availableDeliveries = Delivery::where('status', 'pending')->get();
            $activeDeliveries = Delivery::where('volunteer_id', $volunteer->id)
                ->whereIn('status', ['assigned', 'picked_up', 'in_transit'])
                ->get();

            return view('dashboard.volunteer', compact(
                'volunteer',
                'stats',
                'availableDeliveries',
                'activeDeliveries'
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

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully'
        ]);
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
}
