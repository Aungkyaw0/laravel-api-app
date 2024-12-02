<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use App\Models\MealPlan;
use App\Models\DietaryRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $member;

    protected function setUp(): void
{
    parent::setUp();
    
    // Create test user
    $this->user = User::create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
        'role' => 'member'
    ]);

    // Create test member using relationship
    $this->member = $this->user->members()->create([
        'name' => 'Test Member',
        'gender' => 'male',
        'location' => 'Test Location',
        'phone' => '1234567890',
        'dietary_requirement' => 'vegetarian',
        'prefer_meal' => 'asian'
    ]);
}

    public function test_member_can_view_meal_plans()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/member/meal-plans');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'meal_plans',
                    'current_preferences' => [
                        'dietary_requirement',
                        'prefer_meal'
                    ]
                ]);
    }

    public function test_member_can_update_preferences()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/member/preferences', [
            'dietary_requirement' => 'vegan',
            'prefer_meal' => 'western'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Preferences updated successfully'
                ]);

        $this->assertDatabaseHas('members', [
            'id' => $this->member->id,
            'dietary_requirement' => 'vegan',
            'prefer_meal' => 'western'
        ]);
    }

    public function test_member_can_submit_diet_request()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/member/diet-request', [
            'reason' => 'Health concerns',
            'new_dietary_requirement' => 'gluten-free',
            'new_prefer_meal' => 'mediterranean',
            'additional_notes' => 'Doctor recommended'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Dietary request submitted successfully'
                ]);

        $this->assertDatabaseHas('dietary_requests', [
            'member_id' => $this->member->id,
            'status' => 'pending'
        ]);
    }
} 