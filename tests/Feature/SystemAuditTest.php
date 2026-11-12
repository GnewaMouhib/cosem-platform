<?php

namespace Tests\Feature;

use App\Models\Cereal;
use App\Models\ContactsMessage;
use App\Models\Disease;
use App\Models\Pulse;
use App\Models\Station;
use App\Models\User;
use App\Models\Year;
use Tests\TestCase;

class SystemAuditTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::firstOrCreate(
            ['email' => 'audit_admin@cosem.tn'],
            ['name' => 'Audit Admin', 'password' => bcrypt('password123')]
        );
        $this->admin->forceFill(['role' => 'admin'])->save();
    }

    public function test_all_public_pages_render_successfully(): void
    {
        $publicRoutes = [
            '/',
            '/stations',
            '/cereales',
            '/legumineuses',
            '/maladies',
            '/contact',
            '/mentions-legales',
            '/politique-de-confidentialite',
            '/admin/login',
        ];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_pdf_downloads_work(): void
    {
        $cereal = Cereal::first();
        if ($cereal) {
            $this->get(route('cereales.pdf', $cereal))->assertStatus(200);
        }

        $pulse = Pulse::first();
        if ($pulse) {
            $this->get(route('legumineuses.pdf', $pulse))->assertStatus(200);
        }
    }

    public function test_all_admin_pages_render_for_authenticated_admin(): void
    {
        $cereal = Cereal::first();
        $pulse = Pulse::first();
        $station = Station::first();
        $year = Year::first();
        $disease = Disease::first();
        $msg = ContactsMessage::firstOrCreate(
            ['email' => 'audit@farmer.tn'],
            ['full_name' => 'Audit Farmer', 'subject' => 'Test Subject', 'message' => 'Hello COSEM']
        );

        $adminRoutes = [
            route('admin.dashboard'),
            route('admin.campagnes.index'),
            route('admin.campagnes.edit', $year),
            route('admin.cereales.index'),
            route('admin.cereales.create'),
            route('admin.cereales.edit', $cereal),
            route('admin.legumineuses.index'),
            route('admin.legumineuses.create'),
            route('admin.legumineuses.edit', $pulse),
            route('admin.stations.index'),
            route('admin.stations.create'),
            route('admin.stations.edit', $station),
            route('admin.maladies.index'),
            route('admin.maladies.create'),
            route('admin.maladies.edit', $disease),
            route('admin.messages.index'),
            route('admin.messages.show', $msg),
        ];

        foreach ($adminRoutes as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post(route('contact.store'), [
            'full_name' => 'QA Tester',
            'email' => 'qa@test.com',
            'phone' => '12345678',
            'subject' => 'Demande de semences',
            'message' => 'Bonjour, ceci est un test de soumission.',
        ]);

        $response->assertRedirect(route('contact.index'));
        $this->assertDatabaseHas('contacts_messages', [
            'email' => 'qa@test.com',
        ]);
    }

    public function test_cereal_crud(): void
    {
        $createRes = $this->actingAs($this->admin)->post(route('admin.cereales.store'), [
            'category' => 'ble_dur',
            'name' => 'Variete Test QA',
            'type' => 'Semoulier',
            'breeder' => 'INRAT',
            'optimal_cycle' => '100 jours',
            'yield_potential' => '40 QX/Ha',
            'description' => 'Test description',
        ]);
        $createRes->assertRedirect(route('admin.cereales.index'));

        $cereal = Cereal::where('name', 'Variete Test QA')->first();
        $this->assertNotNull($cereal);

        $updateRes = $this->actingAs($this->admin)->put(route('admin.cereales.update', $cereal), [
            'category' => 'ble_dur',
            'name' => 'Variete Test QA Updated',
            'type' => 'Semoulier',
            'breeder' => 'INRAT',
        ]);
        $updateRes->assertRedirect(route('admin.cereales.index'));

        $deleteRes = $this->actingAs($this->admin)->delete(route('admin.cereales.destroy', $cereal));
        $deleteRes->assertRedirect(route('admin.cereales.index'));
        $this->assertDatabaseMissing('cereals', ['id' => $cereal->id]);
    }

    public function test_pulse_crud(): void
    {
        $createRes = $this->actingAs($this->admin)->post(route('admin.legumineuses.store'), [
            'name' => 'Pois Test QA',
            'variety' => 'Locale',
            'optimal_cycle' => '90 jours',
            'yield_potential' => '20 QX',
        ]);
        $createRes->assertRedirect(route('admin.legumineuses.index'));

        $pulse = Pulse::where('name', 'Pois Test QA')->first();
        $this->assertNotNull($pulse);

        $updateRes = $this->actingAs($this->admin)->put(route('admin.legumineuses.update', $pulse), [
            'name' => 'Pois Test QA Updated',
            'variety' => 'Locale',
        ]);
        $updateRes->assertRedirect(route('admin.legumineuses.index'));

        $deleteRes = $this->actingAs($this->admin)->delete(route('admin.legumineuses.destroy', $pulse));
        $deleteRes->assertRedirect(route('admin.legumineuses.index'));
        $this->assertDatabaseMissing('pulses', ['id' => $pulse->id]);
    }

    public function test_disease_and_pest_crud(): void
    {
        $createRes = $this->actingAs($this->admin)->post(route('admin.maladies.store'), [
            'name' => 'Ravageur Test QA',
            'scientific_name' => 'Testus pestus',
            'category' => 'ravageur',
            'affected_crops' => ['ble_dur', 'orge'],
            'period' => 'Printemps',
            'symptoms' => 'Dégâts foliaires',
            'control_methods' => 'Insecticide biologique',
        ]);
        $createRes->assertRedirect(route('admin.maladies.index'));

        $disease = Disease::where('name', 'Ravageur Test QA')->first();
        $this->assertNotNull($disease);
        $this->assertTrue($disease->isRavageur());

        $deleteRes = $this->actingAs($this->admin)->delete(route('admin.maladies.destroy', $disease));
        $deleteRes->assertRedirect(route('admin.maladies.index'));
        $this->assertDatabaseMissing('diseases', ['id' => $disease->id]);
    }
}
