<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_has_fillable_attributes()
    {
        $fillable = [
            'name', 'email', 'subject', 'message', 'status'
        ];

        $contact = new Contact();
        $this->assertEquals($fillable, $contact->getFillable());
    }

    public function test_new_scope_returns_only_new_contacts()
    {
        Contact::factory()->create(['status' => 'new']);
        Contact::factory()->create(['status' => 'read']);
        Contact::factory()->create(['status' => 'new']);

        $newContacts = Contact::new()->get();

        $this->assertCount(2, $newContacts);
        $this->assertTrue($newContacts->every(fn($contact) => $contact->status === 'new'));
    }

    public function test_read_scope_returns_only_read_contacts()
    {
        Contact::factory()->create(['status' => 'new']);
        Contact::factory()->create(['status' => 'read']);
        Contact::factory()->create(['status' => 'read']);

        $readContacts = Contact::read()->get();

        $this->assertCount(2, $readContacts);
        $this->assertTrue($readContacts->every(fn($contact) => $contact->status === 'read'));
    }

    public function test_replied_scope_returns_only_replied_contacts()
    {
        Contact::factory()->create(['status' => 'new']);
        Contact::factory()->create(['status' => 'replied']);
        Contact::factory()->create(['status' => 'replied']);

        $repliedContacts = Contact::replied()->get();

        $this->assertCount(2, $repliedContacts);
        $this->assertTrue($repliedContacts->every(fn($contact) => $contact->status === 'replied'));
    }

    public function test_recent_scope_orders_contacts_by_created_at_desc()
    {
        $contact1 = Contact::factory()->create(['created_at' => now()->subDays(3)]);
        $contact2 = Contact::factory()->create(['created_at' => now()->subDay()]);
        $contact3 = Contact::factory()->create(['created_at' => now()->subDays(2)]);

        $recentContacts = Contact::recent()->get();

        $this->assertEquals($contact2->id, $recentContacts[0]->id);
        $this->assertEquals($contact3->id, $recentContacts[1]->id);
        $this->assertEquals($contact1->id, $recentContacts[2]->id);
    }

    public function test_contact_can_store_all_required_fields()
    {
        $contact = Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'I would like to discuss a project with you.',
            'status' => 'new'
        ]);

        $this->assertEquals('John Doe', $contact->name);
        $this->assertEquals('john@example.com', $contact->email);
        $this->assertEquals('Project Inquiry', $contact->subject);
        $this->assertEquals('I would like to discuss a project with you.', $contact->message);
        $this->assertEquals('new', $contact->status);
    }

    public function test_contact_can_have_optional_subject()
    {
        $contact = Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'message' => 'Hello, I have a question.',
            'status' => 'new'
        ]);

        $this->assertNull($contact->subject);
        $this->assertEquals('Hello, I have a question.', $contact->message);
    }

    public function test_contact_status_can_be_updated()
    {
        $contact = Contact::factory()->create(['status' => 'new']);

        $contact->update(['status' => 'read']);
        $this->assertEquals('read', $contact->fresh()->status);

        $contact->update(['status' => 'replied']);
        $this->assertEquals('replied', $contact->fresh()->status);
    }

    public function test_contact_scopes_can_be_combined()
    {
        Contact::factory()->create(['status' => 'new', 'created_at' => now()->subDay()]);
        Contact::factory()->create(['status' => 'read', 'created_at' => now()->subDays(2)]);
        Contact::factory()->create(['status' => 'new', 'created_at' => now()->subDays(3)]);

        $recentNewContacts = Contact::new()->recent()->get();

        $this->assertCount(2, $recentNewContacts);
        $this->assertTrue($recentNewContacts->every(fn($contact) => $contact->status === 'new'));
        $this->assertTrue($recentNewContacts[0]->created_at->isAfter($recentNewContacts[1]->created_at));
    }

    public function test_contact_timestamps_are_automatically_managed()
    {
        $contact = Contact::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
            'status' => 'new'
        ]);

        $this->assertNotNull($contact->created_at);
        $this->assertNotNull($contact->updated_at);
        $this->assertEquals($contact->created_at->format('Y-m-d H:i:s'), $contact->updated_at->format('Y-m-d H:i:s'));
    }
}