<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'meal_type' => 'required|string',
            'description' => 'required|string',
            'available_date' => 'required|date',
            'menu_items' => 'required|array|min:1',
            'menu_items.*.name' => 'required|string|max:255|distinct',
            'menu_items.*.availability_status' => 'required|in:available,unavailable',
            'menu_items.*.safety_check_status' => 'required|in:passed,pending,failed',
            'menu_items.*.description' => 'nullable|string|max:1000',
            'menu_items.*.dietary_flags' => 'nullable|array',
            'menu_items.*.dietary_flags.*' => 'string|in:vegetarian,vegan,halal,kosher,gluten-free,dairy-free'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'menu_items.required' => 'At least one menu item is required',
            'menu_items.*.name.required' => 'Each menu item must have a name',
            'menu_items.*.name.distinct' => 'Duplicate menu item names are not allowed',
            'menu_items.*.availability_status.required' => 'Each menu item must have an availability status',
            'menu_items.*.availability_status.in' => 'Invalid availability status. Must be either available or unavailable',
            'menu_items.*.safety_check_status.required' => 'Each menu item must have a safety check status',
            'menu_items.*.safety_check_status.in' => 'Invalid safety check status. Must be passed, pending, or failed',
            'menu_items.*.dietary_flags.*.in' => 'Invalid dietary flag provided',
        ];
    }
} 