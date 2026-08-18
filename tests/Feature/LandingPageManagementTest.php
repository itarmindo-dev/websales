<?php

namespace Tests\Feature;

use App\Models\LandingPageSetting;
use App\Models\Testimonial;
use App\Models\TruckModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LandingPageManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_an_admin_can_manage_landing_page_content(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user)
            ->get(route('admin.landing.edit'))
            ->assertForbidden();

        $this->actingAs($admin)
            ->get(route('admin.landing.edit'))
            ->assertOk()
            ->assertSee('Landing Page')
            ->assertSee('Pengantar Kalkulator TCO')
            ->assertSee('rumus dan pengiriman email tidak berubah');

        $this->actingAs($admin)->get(route('admin.truck-models.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.truck-models.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.truck-models.edit', TruckModel::query()->firstOrFail()))->assertOk();
        $this->actingAs($admin)->get(route('admin.testimonials.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.testimonials.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.testimonials.edit', Testimonial::query()->firstOrFail()))->assertOk();
    }

    public function test_default_content_is_rendered_from_the_migrations(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Armada Tangguh, Bisnis Maju')
            ->assertSee('HINO 300')
            ->assertSee('Hasbie Affan RH')
            ->assertSee('tco-calculator-app', false);
    }

    public function test_admin_can_update_landing_content_and_section_visibility(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $settings = LandingPageSetting::query()->sole();
        $payload = $this->settingsPayload($settings);
        $payload['hero_title'] = 'Armindo Perkasa Tangerang';
        $payload['locations_text'] = "Tangerang\nCirebon";
        $payload['testimonials_enabled'] = '0';

        $this->actingAs($admin)
            ->patch(route('admin.landing.update'), $payload)
            ->assertRedirect(route('admin.landing.edit'));

        $settings->refresh();

        $this->assertSame('Armindo Perkasa Tangerang', $settings->hero_title);
        $this->assertSame(['Tangerang', 'Cirebon'], $settings->locations);
        $this->assertFalse($settings->testimonials_enabled);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Armindo Perkasa Tangerang')
            ->assertDontSee('data-nav-section="testimonials"', false)
            ->assertSee('tco-calculator-app', false);
    }

    public function test_admin_can_add_update_and_delete_a_truck_model_with_its_upload(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.truck-models.store'), [
            'name' => 'HINO Uji',
            'series' => 'Test Series',
            'description' => 'Model untuk pengujian.',
            'whatsapp_message' => 'Saya ingin model HINO Uji.',
            'sort_order' => 10,
            'is_active' => '1',
            'image' => UploadedFile::fake()->image('truck.webp', 800, 500),
        ])->assertRedirect(route('admin.truck-models.index'));

        $truckModel = TruckModel::query()->where('name', 'HINO Uji')->sole();
        $storedPath = substr($truckModel->image, 8);
        Storage::disk('public')->assertExists($storedPath);

        $this->actingAs($admin)->patch(route('admin.truck-models.update', $truckModel), [
            'name' => 'HINO Uji Baru',
            'series' => 'Test Series',
            'description' => 'Model untuk pengujian.',
            'whatsapp_message' => 'Saya ingin model HINO Uji.',
            'sort_order' => 11,
            'is_active' => '0',
            'remove_image' => '1',
        ])->assertRedirect(route('admin.truck-models.index'));

        $truckModel->refresh();
        $this->assertSame('HINO Uji Baru', $truckModel->name);
        $this->assertFalse($truckModel->is_active);
        $this->assertNull($truckModel->image);
        Storage::disk('public')->assertMissing($storedPath);

        $this->actingAs($admin)
            ->delete(route('admin.truck-models.destroy', $truckModel))
            ->assertRedirect(route('admin.truck-models.index'));

        $this->assertModelMissing($truckModel);
    }

    public function test_admin_can_manage_testimonials(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post(route('admin.testimonials.store'), [
            'name' => 'Pelanggan Uji',
            'company' => 'PT Contoh',
            'quote' => 'Pelayanannya sesuai kebutuhan operasional kami.',
            'sort_order' => 10,
            'is_verified' => '1',
            'is_active' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));

        $testimonial = Testimonial::query()->where('name', 'Pelanggan Uji')->sole();
        $this->assertTrue($testimonial->is_verified);
        $this->assertTrue($testimonial->is_active);

        $this->actingAs($admin)
            ->delete(route('admin.testimonials.destroy', $testimonial))
            ->assertRedirect(route('admin.testimonials.index'));

        $this->assertModelMissing($testimonial);
    }

    private function settingsPayload(LandingPageSetting $settings): array
    {
        return [
            'hero_eyebrow' => $settings->hero_eyebrow,
            'hero_title' => $settings->hero_title,
            'hero_highlight' => $settings->hero_highlight,
            'hero_description' => $settings->hero_description,
            'hero_primary_label' => $settings->hero_primary_label,
            'hero_secondary_label' => $settings->hero_secondary_label,
            'locations_text' => implode("\n", $settings->locations),
            'tco_enabled' => '1',
            'tco_kicker' => $settings->tco_kicker,
            'tco_title' => $settings->tco_title,
            'tco_highlight' => $settings->tco_highlight,
            'tco_lead' => $settings->tco_lead,
            'tco_description' => $settings->tco_description,
            'tco_benefits_text' => implode("\n", $settings->tco_benefits),
            'tco_promo' => $settings->tco_promo,
            'models_enabled' => '1',
            'models_kicker' => $settings->models_kicker,
            'models_title' => $settings->models_title,
            'models_highlight' => $settings->models_highlight,
            'models_description' => $settings->models_description,
            'models_note' => $settings->models_note,
            'models_cta_label' => $settings->models_cta_label,
            'models_cta_subtitle' => $settings->models_cta_subtitle,
            'testimonials_enabled' => '1',
            'testimonials_title' => $settings->testimonials_title,
            'testimonials_description' => $settings->testimonials_description,
            'service_promises_text' => implode("\n", $settings->service_promises),
            'contact_enabled' => '1',
            'contact_kicker' => $settings->contact_kicker,
            'contact_title' => $settings->contact_title,
            'contact_description' => $settings->contact_description,
            'whatsapp_number' => $settings->whatsapp_number,
            'whatsapp_label' => $settings->whatsapp_label,
            'website_url' => $settings->website_url,
            'website_label' => $settings->website_label,
            'address' => $settings->address,
            'email' => $settings->email,
            'business_hours' => $settings->business_hours,
            'contact_cta_label' => $settings->contact_cta_label,
            'dealer_benefits_text' => implode("\n", $settings->dealer_benefits),
        ];
    }
}
