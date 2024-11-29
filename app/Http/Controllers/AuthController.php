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
        #Insert user data and get 
        $user = $this->register($request);
        
        $member = new MemberController();
        // //insert data to member table
        $result = $member->store($request, $user);
        $token = $user->createToken($request->email);
        return [
            'result' => $result,
            'token' => $token->plainTextToken
        ];
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
