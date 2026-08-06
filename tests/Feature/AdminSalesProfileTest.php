<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSalesProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_user_cannot_open_admin_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.sales.index'))->assertForbidden();
    }

    public function test_admin_pages_render_with_real_data(): void
    {
        $admin = User::factory()->admin()->create();
        SalesProfile::query()->create([
            'slug' => 'andi-hino',
            'name' => 'Andi HINO',
            'whatsapp_number' => '6281234567890',
        ]);

        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total profil sales')
            ->assertSee('Andi HINO');

        $this->actingAs($admin)->get(route('admin.sales.index'))
            ->assertOk()
            ->assertSee('Andi HINO');

        $this->actingAs($admin)->get(route('admin.sales.create'))
            ->assertOk()
            ->assertSee('Tambah Profil Sales');
    }

    public function test_only_admin_account_can_complete_login(): void
    {
        $regularUser = User::factory()->create(['email' => 'user@example.com']);

        $this->post(route('login'), [
            'email' => $regularUser->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $admin = User::factory()->admin()->create(['email' => 'admin@example.com']);

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_create_command_creates_a_verified_admin_without_default_password(): void
    {
        $this->artisan('admin:create', ['email' => 'owner@example.com'])
            ->expectsQuestion('Nama admin', 'Owner Armindo')
            ->expectsQuestion('Password admin (minimal 12 karakter)', 'password-kuat-123')
            ->expectsQuestion('Ulangi password admin', 'password-kuat-123')
            ->assertSuccessful();

        $admin = User::query()->where('email', 'owner@example.com')->sole();

        $this->assertTrue($admin->is_admin);
        $this->assertNotNull($admin->email_verified_at);
        $this->assertTrue(Hash::check('password-kuat-123', $admin->password));
    }

    public function test_admin_can_create_profile_and_public_page_is_available(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.sales.store'), [
            'name' => 'Budi HINO',
            'phone' => '021 555 0101',
            'whatsapp_number' => '081280061238',
            'tagline' => 'Sales Executive',
            'specialties' => 'HINO 300 dan HINO 500',
            'bio' => 'Membantu pemilihan armada sesuai kebutuhan usaha.',
            'photo' => UploadedFile::fake()->image('budi.jpg', 600, 600),
            'documentation_photos' => [
                UploadedFile::fake()->image('handover.jpg', 800, 600),
            ],
        ]);

        $sale = SalesProfile::query()->sole();

        $response->assertRedirect(route('admin.sales.index'));
        $this->assertSame('budi-hino', $sale->slug);
        $this->assertSame('6281280061238', $sale->whatsapp_number);
        Storage::disk('public')->assertExists($sale->photo);
        Storage::disk('public')->assertExists($sale->documentation_photos[0]);

        $this->get(route('sales.profile', $sale->slug))
            ->assertOk()
            ->assertSee('Budi HINO')
            ->assertSee('6281280061238');
    }

    public function test_updating_and_deleting_profile_cleans_up_replaced_files(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $oldPhoto = UploadedFile::fake()->image('old.jpg')->store('sales_photos', 'public');
        $oldDocumentation = UploadedFile::fake()->image('old-doc.jpg')->store('sales_docs', 'public');
        $sale = SalesProfile::query()->create([
            'slug' => 'siti-hino',
            'name' => 'Siti HINO',
            'photo' => $oldPhoto,
            'documentation_photos' => [$oldDocumentation],
        ]);

        $this->actingAs($admin)->patch(route('admin.sales.update', $sale), [
            'name' => 'Siti HINO',
            'whatsapp_number' => '081234567890',
            'photo' => UploadedFile::fake()->image('new.jpg'),
            'remove_documentation_photos' => [$oldDocumentation],
        ])->assertRedirect(route('admin.sales.index'));

        $sale->refresh();
        Storage::disk('public')->assertMissing($oldPhoto);
        Storage::disk('public')->assertMissing($oldDocumentation);
        Storage::disk('public')->assertExists($sale->photo);

        $newPhoto = $sale->photo;
        $this->actingAs($admin)->delete(route('admin.sales.destroy', $sale))
            ->assertRedirect(route('admin.sales.index'));

        Storage::disk('public')->assertMissing($newPhoto);
        $this->assertDatabaseMissing('sales_profiles', ['id' => $sale->id]);
    }
}
