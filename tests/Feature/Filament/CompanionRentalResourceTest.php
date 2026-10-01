<?php

namespace Tests\Feature\Filament;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\CompanionRental;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanionRentalResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_companion_rentals_list(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin@dicemadly.com',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);

        $rental = CompanionRental::create([
            'reference_no' => 'DM-RGF-TEST01',
            'type' => 'client',
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+919999988888',
            'gender' => 'Male',
            'rent_target' => 'girlfriend',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/companion-rentals');
        $response->assertStatus(200);
        $response->assertSee('DM-RGF-TEST01');
        $response->assertSee('Test Client');
    }

    public function test_admin_can_view_companion_rental_edit_page(): void
    {
        $admin = Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin2@dicemadly.com',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);

        $rental = CompanionRental::create([
            'reference_no' => 'DM-PTR-TEST02',
            'type' => 'partner',
            'name' => 'Test Partner',
            'email' => 'partner@example.com',
            'phone' => '+919999977777',
            'gender' => 'Female',
            'rent_target' => 'girlfriend',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin, 'admin')->get("/admin/companion-rentals/{$rental->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Test Partner');
    }
}
