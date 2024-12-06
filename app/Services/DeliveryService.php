<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\MealPlan;
use App\Services\RouteService;

class DeliveryService
{
    protected $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    public function createDeliveryFromMealPlan(MealPlan $mealPlan)
    {
        $member = $mealPlan->member;
        $kitchen = $member->preferredKitchen;

        if (!$kitchen) {
            throw new \Exception('No preferred kitchen found for member');
        }

        return Delivery::create([
            'pickup_address' => $kitchen->address,
            'delivery_address' => $member->address,
            'pickup_time' => $mealPlan->meal_date->subHours(1),
            'delivery_time' => $mealPlan->meal_date,
            'meal_type' => $mealPlan->meal_type,
            'status' => 'pending',
            'distance' => $member->kitchenDistances()
                ->where('food_service_id', $kitchen->id)
                ->first()
                ->distance
        ]);
    }
} 