<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class CaregiverController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Caregiver::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:16', // Adjust min age as needed
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'experience' => 'required|string',
            'availability' => 'required|in:part-time,full-time',
        ]);
        $post = $user->caregivers()->create($fields);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Caregiver $caregiver)
    {
        return $caregiver;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caregiver $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caregiver $member)
    {
        //
    }
}
