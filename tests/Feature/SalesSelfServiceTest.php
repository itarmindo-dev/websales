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
            ->assertDontSee('Akun login sales');

        $this->actingAs($salesUser)->patch(route('sales.self.update'), [
            'name' => 'Rina HINO',
            'whatsapp_number' => '081234567891',
            'tagline' => 'HINO Sales Executive',
            'specialties' => 'HINO 300',
            'bio' => 'Membantu pelanggan memilih unit sesuai kebutuhan usaha.',
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
            ->assertSee('Prinsip layanan Rina');

        $this->actingAs($salesUser)->patch(route('sales.self.update'), [
            'name' => 'Rina HINO Updated',
            'whatsapp_number' => '081234567891',
            'remove_photo' => '1',
        ])->assertRedirect(route('sales.self.edit'));

        $profile->refresh();
        $this->assertSame('Rina HINO Updated', $profile->name);
        $this->assertNull($profile->photo);
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
