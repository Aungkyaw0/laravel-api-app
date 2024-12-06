<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Volunteer;

class RouteService
{
    const MAX_HOT_MEAL_DISTANCE = 10; // 10 kilometers threshold

    public function calculateRoute(Delivery $delivery)
    {
        $distance = $this->calculateDistance(
            $delivery->pickup_address,
            $delivery->delivery_address
        );

        // Determine meal type based on distance
        $recommendedMealType = $distance <= self::MAX_HOT_MEAL_DISTANCE ? 'hot' : 'frozen';

        return [
            'distance' => $distance,
            'estimated_duration' => $this->estimateDuration($distance),
            'recommended_meal_type' => $recommendedMealType,
            'is_within_hot_meal_range' => $distance <= self::MAX_HOT_MEAL_DISTANCE
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

    public function calculateDistance($from, $to)
    {
        // Simplified distance calculation for demonstration
        // This simulates a basic point-to-point distance calculation
        
        // Convert addresses to coordinates (simplified for demo)
        $fromCoords = $this->mockGeocoding($from);
        $toCoords = $this->mockGeocoding($to);
        
        // Calculate distance using Haversine formula
        return $this->haversineDistance(
            $fromCoords['lat'], 
            $fromCoords['lng'],
            $toCoords['lat'], 
            $toCoords['lng']
        );
    }

    private function mockGeocoding($address)
    {
        // Mock geocoding by generating coordinates within a reasonable area
        // For demonstration, using KL coordinates as center point
        $klLat = 3.1390;  // Kuala Lumpur latitude
        $klLng = 101.6869; // Kuala Lumpur longitude
        
        // Generate random coordinates within roughly 20km of KL
        return [
            'lat' => $klLat + (rand(-15, 15) / 100),
            'lng' => $klLng + (rand(-15, 15) / 100)
        ];
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Earth's radius in kilometers
        $r = 6371;
        
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        
        $dlon = $lon2 - $lon1;
        $dlat = $lat2 - $lat1;
        
        $a = sin($dlat/2)**2 + cos($lat1) * cos($lat2) * sin($dlon/2)**2;
        $c = 2 * asin(sqrt($a));
        
        return $r * $c; // Distance in kilometers
    }

    private function estimateDuration($distance)
    {
        // Rough estimate: 2 minutes per kilometer plus 10 minutes buffer
        return ceil($distance * 2) + 10;
    }


} 