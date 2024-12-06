<?php

namespace App\Services;

use App\Models\Member;
use App\Models\FoodService;
use App\Models\MemberKitchenDistance;

class MemberLocationService
{
    protected $routeService;
    const MAX_HOT_MEAL_DISTANCE = 10; // kilometers

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function updateMemberDistances(Member $member)
    {
        // Get all active food services (kitchens)
        $foodServices = FoodService::where('status', 'active')->get();

        foreach ($foodServices as $foodService) {
            $distance = $this->routeService->calculateDistance(
                $foodService->address,
                $member->address
            );

            MemberKitchenDistance::updateOrCreate(
                [
                    'member_id' => $member->id,
                    'food_service_id' => $foodService->id
                ],
                [
                    'distance' => $distance,
                    'is_within_range' => $distance <= self::MAX_HOT_MEAL_DISTANCE
                ]
            );
        }

        // Find and set closest kitchen
        $closestKitchen = $member->kitchenDistances()
            ->orderBy('distance')
            ->first();

        if ($closestKitchen) {
            $member->update([
                'preferred_kitchen_id' => $closestKitchen->food_service_id,
                'is_within_delivery_range' => $closestKitchen->is_within_range
            ]);
        }

        return $member->load('kitchenDistances');
    }
} 