<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use App\Models\Caregiver;
use App\Models\Member;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\DietaryRequest;
use App\Models\MealPlan;
use App\Models\Order;
use App\Models\FoodService;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{   
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return view('dashboard.admin');
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $member = Member::all();
        $caregiver = Caregiver::all();
        $partner = Partner::all();
        $volunteer = Volunteer::all();
        $dietaryRequest = DietaryRequest::all();
        $mealPlan = MealPlan::all();
        $order = Order::all();
        $foodService = FoodService::all();

        return view('dashboard.admin', compact(
            'totalUsers',
            'member',
            'caregiver',
            'partner',
            'volunteer',
            'dietaryRequest',
            'mealPlan',
            'order',
            'foodService'
        ));
    }

    public function updateMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'dietary_requirement' => 'required|string'
        ]);

        $member = Member::findOrFail($id);
        
        $member->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'dietary_requirement' => $request->dietary_requirement
        ]);

        return redirect()->back()->with('success', 'Member updated successfully');
    }

    public function updateCaregiver(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:18|max:100',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string',
            'experience' => 'nullable|integer|min:0',
            'availability' => 'nullable|string|in:Full-time,Part-time,On-call'
        ]);

        $caregiver = Caregiver::findOrFail($id);

        if($request->name == null || $request->name == ''){
            $request['name'] = $caregiver->name;
        }

        if($request->age == null || $request->age == ''){
            $request['age'] = $caregiver->age;
        }

        if($request->phone == null || $request->phone == ''){
            $request['phone'] = $caregiver->phone;
        }

        if($request->location == null || $request->location == ''){
            $request['location'] = $caregiver->location;
        }

        if($request->experience == null || $request->experience == ''){
            $request['experience'] = $caregiver->experience;
        }

        if($request->availability == null || $request->availability == ''){
            $request['availability'] = $caregiver->availability;
        }
        
        $caregiver->update([
            'name' => $request->name,
            'age' => $request->age,
            'phone' => $request->phone,
            'location' => $request->location,
            'experience' => $request->experience,
            'availability' => $request->availability
        ]);

        return redirect()->back()->with('success', 'Caregiver updated successfully');
    }

    public function updatePartner(Request $request, $id)
    {   try{
        $request->validate([
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:Restaurant,Catering,Food Supplier',
            'contact_person' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'email' => 'required|email',
            'service_area' => 'required|string'
        ]);

        $partner = Partner::findOrFail($id);
        
        $partner->update([
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'email' => $request->email,
            'service_area' => $request->service_area
            ]);

            return redirect()->back()->with('success', 'Partner updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update partner: ' . $e->getMessage());
        }
    }

    public function updateVolunteer(Request $request, $id)
    {
        try{
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'emergency_contact' => 'required|string|max:255',
            'emergency_number' => 'required|string|max:20',
            'vehicle_type' => 'required|string|in:Motorcycle,Car,Bicycle,Van',
            'license_number' => 'required|string',
            'status' => 'required|string|in:active,inactive'
        ]);

        $volunteer = Volunteer::findOrFail($id);
        
        $volunteer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'emergency_phone' => $request->emergency_number,
            'has_vehicle' => 1,
            'vehicle_type' => $request->vehicle_type,
            'license_number' => $request->license_number,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Volunteer updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update volunteer: ' . $e->getMessage());
        }
    }

    public function destroyMember(Request $request, $id)
    {
        $request->validate([
            'confirm' => 'required|in:1'
        ]);

        try {
            DB::beginTransaction();
            
            $member = Member::findOrFail($id);
            
            // Delete related orders first
            $member->orders()->delete();
            
            // Delete related meal plans
            $member->mealPlans()->delete();
            
            // Delete related dietary requests
            $member->dietaryRequests()->delete();
            
            // Finally delete the member
            $member->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Member deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete member: ' . $e->getMessage());
        }
    }

    public function destroyCaregiver(Request $request, $id)
    {
        $request->validate([
            'confirm' => 'required|in:1'
        ]);

        try {
            DB::beginTransaction();
            
            $caregiver = Caregiver::findOrFail($id);
            
            // Delete related orders/assignments
            $caregiver->orders()->update(['caregiver_id' => null]);
            
            // Delete related meal plans
            $caregiver->mealPlans()->delete();

            $caregiver->dietaryRequests()->delete();
            
            // Delete the caregiver
            $caregiver->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Caregiver deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete caregiver: ' . $e->getMessage());
        }
    }

    public function destroyPartner(Request $request, $id)
    {
        $request->validate([
            'confirm' => 'required|in:1'
        ]);

        try {
            DB::beginTransaction();
            
            $partner = Partner::findOrFail($id);
            
            // Delete related food services and meals
            $partner->foodServices()->each(function($foodService) {
                $foodService->meals()->delete();
                $foodService->delete();
            });
            
            // Update orders to remove partner reference
            $partner->orders()->delete();
            
            // Finally delete the partner
            $partner->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Partner deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete partner: ' . $e->getMessage());
        }
    }

    public function destroyVolunteer(Request $request, $id)
    {
        $request->validate([
            'confirm' => 'required|in:1'
        ]);

        try {
            DB::beginTransaction();
            
            $volunteer = Volunteer::findOrFail($id);
            
            // Update orders to remove volunteer reference
            $volunteer->orders()->update(['volunteer_id' => null]);
            
            // Finally delete the volunteer
            $volunteer->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Volunteer deleted successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete volunteer: ' . $e->getMessage());
        }
    }

    public function activateFoodService(Request $request, $id)
    {
        try {
            $foodService = FoodService::findOrFail($id);
            
            $foodService->update([
                'status' => 'active'
            ]);
            
            return redirect()->back()->with('success', 'Food service activated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to activate food service: ' . $e->getMessage());
        }
    }

} 