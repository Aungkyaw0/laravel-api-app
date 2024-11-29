<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MemberController extends Controller implements HasMiddleware
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
        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'dietary_requirement' => 'required|string',
            'prefer_meal' => 'required|string',
        ]);
        //$post = Member::create($fields);
        //$post = $request->user()->members()->create($fields);
        $post = $user->members()->create($fields);
        return $post; #return json data
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return $member;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
