<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use App\Models\MealPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
class CaregiverControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $caregiver;
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user without name field
        $this->user = User::create([
            'email' => 'caregiver@example.com',
            'password' => bcrypt('password123'),
            'role' => 'caregiver'
        ]);

        // Create test caregiver
        $this->caregiver = $this->user->caregivers()->create([
            'name' => 'Test Caregiver',
            'age' => 25,
            'gender' => 'male',
            'location' => 'Test Location',
            'phone' => '1234567890',
            'experience' => '5 years',
            'availability' => 'full-time'
        ]);
    }

    public function test_caregiver_can_view_assigned_members()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/caregiver/members');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'name',
                        'dietary_requirement',
                        'prefer_meal'
                    ]
                ]);
    }


    public function test_caregiver_can_update_member_dietary_needs()
    {
        Sanctum::actingAs($this->user);

        // Create member user first
        $memberUser = User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        // Then create member through the relationship
        $member = $memberUser->members()->create([
            'name' => 'Test Member',
            'gender' => 'female',
            'location' => 'Test Location',
            'phone' => '0987654321',
            'dietary_requirement' => 'vegetarian',
            'prefer_meal' => 'asian'
        ]);

        $response = $this->putJson("/api/caregiver/member/{$member->id}/needs", [
            'dietary_requirement' => 'vegan',
            'prefer_meal' => 'western'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Member dietary needs updated successfully'
                ]);

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'dietary_requirement' => 'vegan',
            'prefer_meal' => 'western'
        ]);
    }

    public function test_caregiver_can_manage_meal_plans()
    {
        Sanctum::actingAs($this->user);

        // Create member user first
        $memberUser = User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);
    
        // Then create member through the relationship
        $member = $memberUser->members()->create([
            'name' => 'Test Member',
            'gender' => 'male',
            'location' => 'Test Location',
            'phone' => '1122334455',
            'dietary_requirement' => 'halal',
            'prefer_meal' => 'local'
        ]);
    
        $response = $this->postJson('/api/caregiver/meal-plans', [
            'member_id' => $member->id,
            'meal_type' => 'lunch',
            'meal_date' => '2024-12-25'
        ]);
    
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Meal plan published successfully'
                ]);
    
        $this->assertDatabaseHas('meal_plans', [
            'member_id' => $member->id,
            'meal_type' => 'lunch',
            'meal_date' => '2024-12-25',
            'status' => 'scheduled'
        ]);
    }
    public function test_caregiver_can_manage_menu()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/caregiver/menu', [
            'meal_type' => 'dinner',
            'description' => 'Healthy dinner options',
            'available_date' => '2024-12-26',
            'menu_items' => json_encode([
                [
                    'name' => 'Grilled Chicken',
                    'availability_status' => 'available',
                    'safety_check_status' => 'passed',
                    'description' => 'Healthy grilled chicken breast',
                    'dietary_flags' => ['gluten-free']
                ]
            ]),
            'nutritional_info' => json_encode([
                'calories' => 500,
                'protein' => '20g',
                'carbs' => '60g',
                'fat' => '15g'
            ])
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Menu created successfully'
                ]);
    }

    public function test_unauthorized_user_cannot_access_caregiver_endpoints()
    {
        $response = $this->getJson('/api/caregiver/members');
        $response->assertStatus(401);
    }
} 