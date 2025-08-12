<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_contact_page_displays_successfully()
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.contact');
        $response->assertSee('Get In Touch');
        $response->assertSee('Send Message');
        $response->assertSee('LinkedIn');
        $response->assertSee('GitHub');
        $response->assertSee('ArtStation');
    }

    public function test_contact_form_submission_with_valid_data()
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'I would like to discuss a web development project with you.',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for your message! I\'ll get back to you soon.');

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'I would like to discuss a web development project with you.',
            'status' => 'new'
        ]);
    }

    public function test_contact_form_submission_without_subject()
    {
        $contactData = [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'message' => 'Hello, I am interested in your 3D modeling services.',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'subject' => 'Contact Form Submission',
            'message' => 'Hello, I am interested in your 3D modeling services.',
            'status' => 'new'
        ]);
    }

    public function test_contact_form_validation_required_fields()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_validation_email_format()
    {
        $contactData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'message' => 'This is a test message.',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_form_validation_message_minimum_length()
    {
        $contactData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Short',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasErrors(['message']);
    }

    public function test_contact_form_validation_name_minimum_length()
    {
        $contactData = [
            'name' => 'A',
            'email' => 'test@example.com',
            'message' => 'This is a valid message with enough characters.',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_contact_form_spam_protection_honeypot()
    {
        $contactData = [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'message' => 'This is a spam message.',
            'honeypot' => 'spam content',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasErrors(['honeypot']);
    }

    public function test_contact_form_spam_protection_keywords()
    {
        $contactData = [
            'name' => 'Spammer',
            'email' => 'spammer@example.com',
            'message' => 'Buy viagra now! Click here for amazing deals on casino games!',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasErrors(['honeypot']);
    }

    public function test_contact_form_retains_input_on_validation_error()
    {
        $contactData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
        ];

        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), $contactData);

        $response->assertSessionHasInput('name', 'Test User');
        $response->assertSessionHasInput('subject', 'Test Subject');
        $response->assertSessionHasInput('message', 'This is a test message.');
    }

    public function test_contact_form_displays_custom_validation_messages()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
                         ->post(route('contact.store'), [
            'name' => '',
            'email' => '',
            'message' => ''
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Please enter your name.',
            'email' => 'Please enter your email address.',
            'message' => 'Please enter your message.'
        ]);
    }
}