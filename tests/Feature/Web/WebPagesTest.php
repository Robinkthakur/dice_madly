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
}
