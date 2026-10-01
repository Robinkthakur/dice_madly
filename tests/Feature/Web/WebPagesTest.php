<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Roll Into');
        $response->assertSee('Google Play');
        $response->assertSee('App Store');
    }

    public function test_privacy_policy_loads_successfully(): void
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('Data Retention');
        $response->assertSee('Children');
    }

    public function test_privacy_policy_alias_loads_successfully(): void
    {
        $response = $this->get('/privacy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
    }

    public function test_terms_of_service_loads_successfully(): void
    {
        $response = $this->get('/terms');
        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
        $response->assertSee('Age Restriction');
        $response->assertSee('Dice Roll Matchmaking');
    }

    public function test_delete_account_portal_loads_successfully(): void
    {
        $response = $this->get('/delete-account');
        $response->assertStatus(200);
        $response->assertSee('Account & Data Deletion Portal');
        $response->assertSee('Submit Web Data Deletion Request');
    }

    public function test_submit_delete_account_request_works(): void
    {
        $response = $this->post('/delete-account-request', [
            'identifier_type' => 'email',
            'identifier' => 'testuser@example.com',
            'reason' => 'Testing deletion portal',
            'confirm_checkbox' => '1',
        ]);

        $response->assertRedirect('/delete-account');
        $response->assertSessionHas('success_request');
    }

    public function test_community_guidelines_loads_successfully(): void
    {
        $response = $this->get('/community-guidelines');
        $response->assertStatus(200);
        $response->assertSee('Community Guidelines');
    }

    public function test_refund_policy_loads_successfully(): void
    {
        $response = $this->get('/refund-policy');
        $response->assertStatus(200);
        $response->assertSee('Refund & Cancellation Policy');
    }

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Get In Touch With Us');
        $response->assertSee('Grievance Redressal Officer');
    }

    public function test_submit_contact_inquiry_works(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'category' => 'general',
            'subject' => 'Partnership Inquiry',
            'message' => 'Hello team, I would like to inquire about Dice Madly.',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_success');
    }

    public function test_rent_companion_page_loads_successfully(): void
    {
        $response = $this->get('/rent-partner');
        $response->assertStatus(200);
        $response->assertSee('Rent a');
        $response->assertSee('Boyfriend');
        $response->assertSee('Girlfriend');
        $response->assertSee('Register as Partner');
        $response->assertSee('boy_companion.jpg');
        $response->assertSee('girl_companion.jpg');
    }

    public function test_submit_client_companion_rental_survey_works(): void
    {
        $response = $this->post('/rent-partner', [
            'type' => 'client',
            'name' => 'Rahul Sharma',
            'email' => 'rahul@example.com',
            'phone' => '+919876543210',
            'gender' => 'Male',
            'rent_target' => 'girlfriend',
            'age' => 26,
            'city' => 'Mumbai',
            'duration_hours' => '3 Hours Dinner Date',
            'budget_or_rate' => '₹2,000 / hour',
            'remarks' => 'Looking for sweet conversationalist for evening social dinner.',
            'agree_guidelines' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('rental_success');

        $this->assertDatabaseHas('companion_rentals', [
            'email' => 'rahul@example.com',
            'type' => 'client',
            'rent_target' => 'girlfriend',
            'name' => 'Rahul Sharma',
        ]);
    }

    public function test_submit_partner_rental_registration_works(): void
    {
        $response = $this->post('/rent-partner', [
            'type' => 'partner',
            'name' => 'Ananya Verma',
            'email' => 'ananya@example.com',
            'phone' => '+919123456780',
            'gender' => 'Female',
            'rent_target' => 'girlfriend',
            'age' => 23,
            'city' => 'Delhi',
            'duration_hours' => 'Weekends & Evenings',
            'budget_or_rate' => '₹1,500 / hour',
            'hobbies_interests' => 'Reading, Art, Cafe hopping, Spoken English',
            'partner_experience' => 'Friendly, well-spoken, respectful demeanor.',
            'remarks' => 'Prefer cafe and public dining venues only.',
            'agree_guidelines' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('rental_success');

        $this->assertDatabaseHas('companion_rentals', [
            'email' => 'ananya@example.com',
            'type' => 'partner',
            'rent_target' => 'girlfriend',
            'name' => 'Ananya Verma',
        ]);
    }
}

