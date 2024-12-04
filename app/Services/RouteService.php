<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Volunteer;

class RouteService
{
    public function calculateRoute(Delivery $delivery)
    {
        // Here you would integrate with a mapping service like Google Maps
        // For now, we'll use a simple distance calculation
        return [
            'distance' => $this->calculateDistance(
                $delivery->pickup_address,
                $delivery->delivery_address
            ),
            'estimated_duration' => 30, // minutes
            'route_points' => []
        ];
    }

    public function findEligibleVolunteers(Delivery $delivery)
    {
        return Volunteer::query()
            ->where('status', 'active')
            ->where('background_check_passed', true)
            ->when($delivery->meal_type === 'hot', function ($query) use ($delivery) {
                // Additional checks for hot meal delivery
                return $query->where('has_vehicle', true);
            })
            ->get()
            ->filter(function ($volunteer) use ($delivery) {
                return $this->isVolunteerAvailable($volunteer, $delivery);
            });
    }

    private function isVolunteerAvailable(Volunteer $volunteer, Delivery $delivery)
    {
        // Check if volunteer is available during delivery time
        $deliveryDay = strtolower(date('l', strtotime($delivery->pickup_time)));
        
        return $volunteer->availabilities()
            ->where('day_of_week', $deliveryDay)
            ->where('start_time', '<=', date('H:i', strtotime($delivery->pickup_time)))
            ->where('end_time', '>=', date('H:i', strtotime($delivery->delivery_time)))
            ->exists();
    }

    private function calculateDistance($from, $to)
    {
        // Implement actual distance calculation
        // For now, return dummy value
        return rand(1, 15);
    }
} 