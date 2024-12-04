<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Services\RouteService;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $volunteer = auth()->user()->volunteer;
        $upcomingDeliveries = $volunteer->deliveries()
            ->where('status', '!=', 'delivered')
            ->orderBy('pickup_time')
            ->get();

        return response()->json([
            'volunteer' => $volunteer,
            'upcoming_deliveries' => $upcomingDeliveries,
            'stats' => $this->getVolunteerStats($volunteer)
        ]);
    }

    public function updateAvailability(Request $request)
    {
        $validated = $request->validate([
            'availabilities' => 'required|array',
            'availabilities.*.day_of_week' => 'required|string',
            'availabilities.*.start_time' => 'required|date_format:H:i',
            'availabilities.*.end_time' => 'required|date_format:H:i|after:start_time'
        ]);

        $volunteer = auth()->user()->volunteer;
        $volunteer->availabilities()->delete();
        $volunteer->availabilities()->createMany($validated['availabilities']);

        return response()->json(['message' => 'Availability updated successfully']);
    }

    public function acceptDelivery(Request $request, Delivery $delivery)
    {
        $volunteer = auth()->user()->volunteer;
        
        if ($delivery->status !== 'pending') {
            return response()->json(['message' => 'Delivery no longer available'], 422);
        }

        $delivery->update([
            'volunteer_id' => $volunteer->id,
            'status' => 'assigned'
        ]);

        return response()->json(['message' => 'Delivery assigned successfully']);
    }

    private function getVolunteerStats(Volunteer $volunteer)
    {
        return [
            'total_deliveries' => $volunteer->deliveries()->where('status', 'delivered')->count(),
            'total_distance' => $volunteer->deliveries()->where('status', 'delivered')->sum('distance'),
            'on_time_rate' => $this->calculateOnTimeRate($volunteer)
        ];
    }

    private function calculateOnTimeRate(Volunteer $volunteer)
    {
        $completed = $volunteer->deliveries()->where('status', 'delivered');
        $total = $completed->count();
        if ($total === 0) return 100;

        $onTime = $completed->where('delivery_time', '<=', 'expected_delivery_time')->count();
        return ($onTime / $total) * 100;
    }
}
