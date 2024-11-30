<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PartnerController extends Controller implements HasMiddleware
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
        return Partner::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email',
            'phone' => 'required|string|min:10|max:15',
            'location' => 'required|string',
            'country' => 'required|string',
            'business_type' => 'required|string',
            'service_offer' => 'required|string',
        ]);
        
        $post = $user->partners()->create($fields);
        return $post; #return json data
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return $partner;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        //
    }
}