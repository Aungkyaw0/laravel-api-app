<?php

namespace App\Services;

use App\Models\Member;
use Carbon\Carbon;

class MealTypeService
{
    public function determineAvailableMealTypes(Member $member, $deliveryDate)
    {
        $date = Carbon::parse($deliveryDate);
        $isWeekend = $date->isWeekend();

        // If it's weekend or member is not within range, only frozen meals
        if ($isWeekend || !$member->is_within_delivery_range) {
            return ['frozen'];
        }

        // If weekday and within range, both meal types available
        return ['hot', 'frozen'];
    }

    public function validateMealPlan($mealType, Member $member, $deliveryDate)
    {
        $availableTypes = $this->determineAvailableMealTypes($member, $deliveryDate);
        
        return in_array($mealType, $availableTypes);
    }
} 