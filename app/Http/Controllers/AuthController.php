<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show registration page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Show login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Register Member
    public function registerMember(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'name' => 'required|string|max:255',
                'gender' => 'required|string|in:male,female,other',
                'phone' => 'required|string|min:10',
                'address' => 'required|string',
                'dietary_requirement' => 'required|string|in:none,vegetarian,vegan,halal,gluten-free',
                'prefer_meal' => 'required|string|in:hot,frozen,both',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180'
     
            ], [
                'email.unique' => 'This email is already registered',
                'password.min' => 'Password must be at least 8 characters',
                'password.confirmed' => 'Passwords do not match',
                'phone.min' => 'Please enter a valid phone number',
                'dietary_requirement.in' => 'Please select a valid dietary requirement',
                'prefer_meal.in' => 'Please select a valid meal preference'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member'
            ]);

            // Create member profile
            $user->member()->create([
                'name' => $request->name,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'dietary_requirement' => $request->dietary_requirement,
                'prefer_meal' => $request->prefer_meal,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please login.',
                'redirect' => route('login')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Member Registration Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    // Register Caregiver
    public function registerCaregiver(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'name' => 'required|string|max:255',
                'gender' => 'required|string',
                'age' => 'required|integer|min:18',
                'phone' => 'required|string',
                'location' => 'required|string',
                'experience' => 'required|string',
                'availability' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'caregiver'
            ]);

            $user->caregiver()->create([
                'name' => $request->name,
                'gender' => $request->gender,
                'age' => $request->age,
                'phone' => $request->phone,
                'location' => $request->location,
                'experience' => $request->experience,
                'availability' => $request->availability
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please login.',
                'redirect' => route('login')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Caregiver Registration Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    // Register Partner
    public function registerPartner(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
                'company_name' => 'required|string',
                'company_email' => 'required|email',
                'phone' => 'required|string',
                'location' => 'required|string',
                'business_type' => 'required|string',
                'service_offer' => 'required|string',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $request->company_email,
                'password' => Hash::make($request->password),
                'role' => 'partner'
            ]);

            // Create partner profile
            $user->partner()->create([
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'phone' => $request->phone,
                'location' => $request->location,
                'business_type' => $request->business_type,
                'service_offer' => $request->service_offer,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please login.',
                'redirect' => route('login')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Partner Registration Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    // Register Volunteer
    public function registerVolunteer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'address' => 'required|string',
                'emergency_contact' => 'required|string',
                'emergency_phone' => 'required|string',
                'has_vehicle' => 'boolean',
                'vehicle_type' => 'required_if:has_vehicle,1|string|nullable',
                'license_number' => 'required_if:has_vehicle,1|string|nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'volunteer'
            ]);

            // Create volunteer profile
            $user->volunteer()->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'emergency_contact' => $request->emergency_contact,
                'emergency_phone' => $request->emergency_phone,
                'has_vehicle' => $request->has_vehicle ? true : false,
                'vehicle_type' => $request->has_vehicle ? $request->vehicle_type : null,
                'license_number' => $request->has_vehicle ? $request->license_number : null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please login.',
                'redirect' => route('login')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Volunteer Registration Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    // Login
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();
                
                Log::info('User logged in successfully', [
                    'user_id' => $user->id, 
                    'email' => $user->email, 
                    'role' => $user->role
                ]);

                // Check user role and redirect accordingly
                switch ($user->role) {
                    case 'member':
                        return redirect()->route('member.dashboard');
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'caregiver':
                        return redirect()->route('caregiver.dashboard');
                    case 'volunteer':
                        return redirect()->route('volunteer.dashboard');
                    case 'partner':
                        if (!$user->partner) {
                            Auth::logout();
                            return back()->withErrors([
                                'email' => 'Partner profile not found. Please contact support.',
                            ]);
                        }
                        return redirect()->route('partner.dashboard');
                    default:
                        Auth::logout();
                        return back()->withErrors([
                            'email' => 'Invalid user role.',
                        ]);
                }
            }

            Log::warning('Failed login attempt', ['email' => $request->email]);
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));

        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'An error occurred during login. Please try again.',
            ])->withInput($request->only('email'));
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
