<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MemberController;
use App\Models\User;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // For Member register, credential will be store in user table
    // Additonal info will be stored in Member table
    
    protected function register(Request $request, String $role){
        $fields = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $fields['password'] = Hash::make($fields['password']); 
        $fields['role'] = $role;
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
        $user = $this->register($request, "member");
        
        $member = new MemberController();
        #Insert data to member table
        $result = $member->store($request, $user);
        
        #token generation
        $token = $user->createToken($request->email);
        return [
            'message' => 'Member Registeration is successful',
            'result' => $result,
            'token' => $token->plainTextToken
        ];
    }

    public function registerCaregiver(Request $request){
        //Just for documentation
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:16', // Adjust min age as needed
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'experience' => 'required|string',
            'availability' => 'required|in:part-time,full-time',
        ]);

        #Insert user data and get 
        $user = $this->register($request, 'caregiver');
        
        $caregiver = new CaregiverController();
        #Insert data to member table
        $result = $caregiver->store($request, $user);
        
        #token generation
        $token = $user->createToken($request->email);
        return [
            'message' => 'Caregiver Registeration is successful',
            'result' => $result,
            'token' => $token->plainTextToken
        ];
    }

    public function registerPartner(Request $request){
        //Just for documentation
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email',
            'phone' => 'required|string|min:10|max:15',
            'location' => 'required|string',
            'country' => 'required|string',
            'business_type' => 'required|string',
            'service_offer' => 'required|string',
        ]);

        #Insert user data and get 
        $user = $this->register($request, 'partner');
        
        $partner = new PartnerController();
        #Insert data to member table
        $result = $partner->store($request, $user);
        
        #token generation
        $token = $user->createToken($request->email);
        return [
            'message' => 'Partner Registeration is successful',
            'result' => $result,
            'token' => $token->plainTextToken
        ];
    }

    public function registerVolunteer(Request $request){
        //Just for documentation
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18', 
            'gender' => 'required|in:male,female,other',
            'location' => 'required|string',
            'phone' => 'required|string|min:10|max:15',
            'experience' => 'required|string',
            'availability' => 'required|in:part-time,full-time',
        ]);

        #Insert user data and get 
        $user = $this->register($request, 'volunteer');
        
        $volunteer = new VolunteerController();
        #Insert data to member table
        $result = $volunteer->store($request, $user);
        
        #token generation
        $token = $user->createToken($request->email);
        return [
            'message' => 'Volunteer Registeration is successful',
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
