<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MemberController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    // For Member register, credential will be store in user table
    // Additonal info will be stored in Member table
    
    protected function register(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $fields['password'] = Hash::make($fields['password']); 
        
        #Insert user creadential
        $user = User::create(attributes: $fields);
        return $user;
    }
    
    public function registerMember(Request $request){
        //Just for documentation
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'dietary_requirement' => 'required|string',
            'prefer_meal' => 'required|string',
        ]);

        #Insert user data and get 
        $user = $this->register($request);
        
        $member = new MemberController();
        #Insert data to member table
        $result = $member->store($request, $user);
        
        #token generation
        $token = $user->createToken($request->email);
        return [
            'result' => $result,
            'token' => $token->plainTextToken
        ];
    }

    public function registerCaregiver(Request $request){
        return 'register caregiver';
    }

    public function registerPartner(Request $request){
        return 'register caregiver';
    }

    public function registerVolunteer(Request $request){
        return 'register caregiver';
    }

    
    // Login process
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required'

        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                'message' => 'The provided credentials are incorrect.'
            ];
        }

        $token = $user->createToken($user->email);

        return [
            'user' => $user,
            'token' => $token->plainTextToken

        ];

    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return[
            'message' => 'You are log out'
        ];
    }
}
