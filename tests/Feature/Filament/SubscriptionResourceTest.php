<?php

namespace Tests\Feature\Filament;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_subscriptions_list(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin_sub@dicemadly.com',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);

        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'sub_user@example.com',
            'phone' => '1234567890',
            'gender' => 'Male',
        ]);

        $package = Package::create([
            'name' => 'Gold Package',
            'price' => 99.99,
            'duration_days' => 30,
            'contact_limit' => 10,
            'interest_limit' => 20,
            'chat_access' => true,
            'view_contact' => true,
        ]);

        $sub = Subscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'Active',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/subscriptions');
        $response->assertStatus(200);
        $response->assertSee('sub_user@example.com');
        $response->assertSee('Gold Package');
    }

    public function test_admin_can_view_create_subscription_page(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin_create_sub@dicemadly.com',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/subscriptions/create');
        $response->assertStatus(200);
    }

    public function test_admin_can_view_edit_subscription_page(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin_edit_sub@dicemadly.com',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);

        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'sub_edit_user@example.com',
            'phone' => '1234567891',
            'gender' => 'Female',
        ]);

        $package = Package::create([
            'name' => 'Silver Package',
            'price' => 49.99,
            'duration_days' => 15,
            'contact_limit' => 5,
            'interest_limit' => 10,
            'chat_access' => true,
            'view_contact' => false,
        ]);

        $sub = Subscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'start_date' => now(),
            'end_date' => now()->addDays(15),
            'status' => 'Active',
        ]);

        $response = $this->actingAs($admin, 'admin')->get("/admin/subscriptions/{$sub->id}/edit");
        $response->assertStatus(200);
    }
}
