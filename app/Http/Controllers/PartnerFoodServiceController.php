<?php

namespace App\Http\Controllers;

use App\Models\FoodService;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerFoodServiceController extends Controller
{
    public function createFoodService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'cuisine_type' => 'required|string',
            'service_area' => 'required|string',
            'operating_hours' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foodService = FoodService::create([
            'partner_id' => $request->user()->id,
            ...$validator->validated()
        ]);

        return response()->json([
            'message' => 'Food service created successfully',
            'food_service' => $foodService
        ], 201);
    }

    public function addMeal(Request $request, FoodService $foodService)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|array',
            'nutritional_info' => 'required|array',
            'meal_type' => 'required|in:breakfast,lunch,dinner',
            'dietary_flags' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $meal = $foodService->meals()->create($validator->validated());

        return response()->json([
            'message' => 'Meal added successfully',
            'meal' => $meal
        ], 201);
    }

    public function updateMeal(Request $request, FoodService $foodService, Meal $meal)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'ingredients' => 'array',
            'nutritional_info' => 'array',
            'meal_type' => 'in:breakfast,lunch,dinner',
            'dietary_flags' => 'array',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $meal->update($validator->validated());

        return response()->json([
            'message' => 'Meal updated successfully',
            'meal' => $meal
        ]);
    }

    public function getMeals(FoodService $foodService)
    {
        return response()->json([
            'meals' => $foodService->meals()->paginate(perPage: 10)
        ]);
    }

    public function updateServiceStatus(Request $request, FoodService $foodService)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foodService->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Service status updated successfully',
            'food_service' => $foodService
        ]);
    }
} 