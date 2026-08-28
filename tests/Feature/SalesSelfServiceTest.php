<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SalesSelfServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_can_create_and_update_only_their_own_public_profile(): void
    {
        Storage::fake('public');
        $salesUser = User::factory()->sales()->create(['name' => 'Nama Akun']);

        $this->actingAs($salesUser)
            ->get(route('sales.self.edit'))
            ->assertOk()
            ->assertSee('Profil Anda belum dipublikasikan')
            ->assertSee('name="slug"', false)
            ->assertSee('name="intro_eyebrow"', false)
            ->assertSee('name="intro_title"', false)
            ->assertSee('name="intro_emphasis"', false)
            ->assertDontSee('Akun login sales');

        $this->actingAs($salesUser)->patch(route('sales.self.update'), [
            'name' => 'Rina HINO',
            'whatsapp_number' => '081234567891',
            'tagline' => 'HINO Sales Executive',
            'specialties' => 'HINO 300',
            'bio' => 'Membantu pelanggan memilih unit sesuai kebutuhan usaha.',
            'intro_eyebrow' => 'Pendekatan Rina',
            'intro_title' => 'Bukan hanya membeli unit.',
            'intro_emphasis' => 'Menyiapkan usaha untuk terus bergerak.',
            'photo' => UploadedFile::fake()->image('rina.jpg', 500, 500),
            'sections' => [
                [
                    'type' => 'text',
                    'layout' => 'full_width',
                    'title' => 'Prinsip layanan Rina',
                    'body' => 'Rekomendasi disusun berdasarkan kebutuhan pelanggan.',
                    'is_active' => '1',
                ],
            ],
        ])->assertRedirect(route('sales.self.edit'));

        $profile = $salesUser->salesProfile()->sole();

        $this->assertSame($salesUser->id, $profile->user_id);
        $this->assertSame('rina-hino', $profile->slug);
        $this->assertSame('6281234567891', $profile->whatsapp_number);
        $this->assertSame('Rina HINO', $salesUser->fresh()->name);
        Storage::disk('public')->assertExists($profile->photo);
        $this->assertSame('Prinsip layanan Rina', $profile->sections()->sole()->title);

        $this->get(route('sales.profile', $profile->slug))
            ->assertOk()
            ->assertSee('Rina HINO')
            ->assertSee('Pendekatan Rina')
            ->assertSee('Bukan hanya membeli unit.')
            ->assertSee('Menyiapkan usaha untuk terus bergerak.')
            ->assertSee('Prinsip layanan Rina');

        $this->actingAs($salesUser)->patch(route('sales.self.update'), [
            'name' => 'Rina HINO Updated',
            'slug' => 'Rina HINO Tangerang',
            'whatsapp_number' => '081234567891',
            'intro_eyebrow' => 'Konsultasi armada',
            'intro_title' => 'Pilihan yang tepat dimulai dari kebutuhan.',
            'intro_emphasis' => 'Armada disusun agar bisnis terus bekerja.',
            'remove_photo' => '1',
        ])->assertRedirect(route('sales.self.edit'));

        $profile->refresh();
        $this->assertSame('Rina HINO Updated', $profile->name);
        $this->assertSame('rina-hino-tangerang', $profile->slug);
        $this->assertSame('Konsultasi armada', $profile->intro_eyebrow);
        $this->assertSame('Pilihan yang tepat dimulai dari kebutuhan.', $profile->intro_title);
        $this->assertSame('Armada disusun agar bisnis terus bekerja.', $profile->intro_emphasis);
        $this->assertNull($profile->photo);
        $this->get('/sales/rina-hino')->assertNotFound();
        $this->get('/sales/rina-hino-tangerang')->assertOk();

        SalesProfile::query()->create([
            'slug' => 'slug-sales-lain',
            'name' => 'Sales Lain',
        ]);

        $this->actingAs($salesUser)
            ->from(route('sales.self.edit'))
            ->patch(route('sales.self.update'), [
                'name' => 'Rina HINO Updated',
                'slug' => 'slug-sales-lain',
            ])
            ->assertRedirect(route('sales.self.edit'))
            ->assertSessionHasErrors('slug');

        $this->assertSame('rina-hino-tangerang', $profile->fresh()->slug);
    }

    public function test_sales_cannot_access_admin_data_or_delete_their_account(): void
    {
        $salesUser = User::factory()->sales()->create();
        $otherProfile = SalesProfile::query()->create([
            'slug' => 'sales-lain',
            'name' => 'Sales Lain',
        ]);

        $this->actingAs($salesUser)->get(route('dashboard'))->assertForbidden();
        $this->actingAs($salesUser)->get(route('admin.sales.index'))->assertForbidden();
        $this->actingAs($salesUser)->get(route('admin.sales.edit', $otherProfile))->assertForbidden();
        $this->actingAs($salesUser)->delete(route('profile.destroy'), ['password' => 'password'])->assertForbidden();

        $this->assertModelExists($salesUser);
        $this->assertModelExists($otherProfile);
    }

    public function test_sales_cannot_update_a_section_owned_by_another_profile(): void
    {
        $salesUser = User::factory()->sales()->create();
        SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'profil-saya',
            'name' => 'Profil Saya',
        ]);
        $otherProfile = SalesProfile::query()->create([
            'slug' => 'profil-lain',
            'name' => 'Profil Lain',
        ]);
        $otherSection = $otherProfile->sections()->create([
            'type' => 'text',
            'layout' => 'full_width',
            'title' => 'Milik sales lain',
            'is_active' => true,
        ]);

        $this->actingAs($salesUser)->from(route('sales.self.edit'))->patch(route('sales.self.update'), [
            'name' => 'Profil Saya Diubah',
            'sections' => [[
                'id' => $otherSection->id,
                'type' => 'text',
                'layout' => 'full_width',
                'title' => 'Berusaha mengambil section',
                'is_active' => '1',
            ]],
        ])->assertRedirect(route('sales.self.edit'))
            ->assertSessionHasErrors('sections.0.id');

        $this->assertSame('Profil Saya', $salesUser->salesProfile->fresh()->name);
        $this->assertSame('Milik sales lain', $otherSection->fresh()->title);
    }

    public function test_admin_can_disable_a_sales_login_without_deleting_the_profile(): void
    {
        $admin = User::factory()->admin()->create();
        $salesUser = User::factory()->sales()->create(['email' => 'sales@example.com']);
        $profile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'sales-aktif',
            'name' => 'Sales Aktif',
        ]);

        $this->actingAs($admin)->patch(route('admin.sales.update', $profile), [
            'name' => 'Sales Aktif',
            'account_email' => 'sales@example.com',
            'account_enabled' => '0',
        ])->assertRedirect(route('admin.sales.index'));

        $this->assertFalse($salesUser->fresh()->is_sales);
        $this->get(route('sales.profile', $profile->slug))->assertOk();

        $this->post(route('logout'));
        $this->post(route('login'), [
            'email' => 'sales@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
