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

    public function test_only_admin_or_sales_account_can_complete_login(): void
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

        $this->post(route('logout'));

        $salesUser = User::factory()->sales()->create(['email' => 'sales@example.com']);

        $this->post(route('login'), [
            'email' => $salesUser->email,
            'password' => 'password',
        ])->assertRedirect(route('sales.self.edit'));
        $this->assertAuthenticatedAs($salesUser);
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
            'account_email' => 'budi@example.com',
            'account_password' => 'password-sales-123',
            'account_password_confirmation' => 'password-sales-123',
            'account_enabled' => '1',
            'photo' => UploadedFile::fake()->image('budi.jpg', 600, 600),
            'documentation_photos' => [
                UploadedFile::fake()->image('handover.jpg', 800, 600),
            ],
            'hero_title' => 'Armada siap untuk usaha Anda',
            'hero_image' => UploadedFile::fake()->image('hero.jpg', 1600, 1200),
            'sections' => [
                [
                    'type' => 'image_text',
                    'layout' => 'media_left',
                    'eyebrow' => 'Cerita pelanggan',
                    'title' => 'Memilih unit berdasarkan kebutuhan',
                    'body' => 'Muatan dan rute menjadi dasar rekomendasi.',
                    'media_file' => UploadedFile::fake()->image('section.jpg', 1200, 900),
                    'is_active' => '1',
                ],
            ],
        ]);

        $sale = SalesProfile::query()->sole();

        $response->assertRedirect(route('admin.sales.index'));
        $this->assertSame('budi-hino', $sale->slug);
        $this->assertSame('6281280061238', $sale->whatsapp_number);
        $this->assertSame('budi@example.com', $sale->user->email);
        $this->assertTrue($sale->user->is_sales);
        $this->assertTrue(Hash::check('password-sales-123', $sale->user->password));
        Storage::disk('public')->assertExists($sale->photo);
        Storage::disk('public')->assertExists($sale->hero_image);
        Storage::disk('public')->assertExists($sale->documentation_photos[0]);
        $this->assertSame('Memilih unit berdasarkan kebutuhan', $sale->sections()->sole()->title);
        Storage::disk('public')->assertExists($sale->sections()->sole()->media_path);

        $this->post(route('logout'));
        $this->post(route('login'), [
            'email' => 'budi@example.com',
            'password' => 'password-sales-123',
        ])->assertRedirect(route('sales.self.edit'));

        $this->get(route('sales.profile', $sale->slug))
            ->assertOk()
            ->assertSee('Budi HINO')
            ->assertSee('Memilih unit berdasarkan kebutuhan')
            ->assertSee('6281280061238');
    }

    public function test_updating_and_deleting_profile_cleans_up_replaced_files(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $oldPhoto = UploadedFile::fake()->image('old.jpg')->store('sales_photos', 'public');
        $oldDocumentation = UploadedFile::fake()->image('old-doc.jpg')->store('sales_docs', 'public');
        $oldHero = UploadedFile::fake()->image('old-hero.jpg')->store('sales_heroes', 'public');
        $oldSectionMedia = UploadedFile::fake()->image('old-section.jpg')->store('sales_sections', 'public');
        $sale = SalesProfile::query()->create([
            'slug' => 'siti-hino',
            'name' => 'Siti HINO',
            'photo' => $oldPhoto,
            'hero_image' => $oldHero,
            'documentation_photos' => [$oldDocumentation],
        ]);
        $sale->sections()->create([
            'type' => 'image_text',
            'layout' => 'media_left',
            'title' => 'Section lama',
            'media_path' => $oldSectionMedia,
            'is_active' => true,
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
        Storage::disk('public')->assertMissing($oldHero);
        Storage::disk('public')->assertMissing($oldSectionMedia);
        $this->assertDatabaseMissing('sales_profiles', ['id' => $sale->id]);
    }

    public function test_admin_can_change_profile_url_and_duplicate_slug_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $sale = SalesProfile::query()->create([
            'slug' => 'tes',
            'name' => 'Muhammad Habib Amrullah',
        ]);
        SalesProfile::query()->create([
            'slug' => 'url-sales-lain',
            'name' => 'Sales Lain',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.sales.edit', $sale))
            ->assertOk()
            ->assertSee('name="slug"', false)
            ->assertSee('value="tes"', false);

        $this->actingAs($admin)->patch(route('admin.sales.update', $sale), [
            'name' => 'Muhammad Habib Amrullah',
            'slug' => 'Muhammad Habib Amrullah',
            'account_enabled' => '0',
        ])->assertRedirect(route('admin.sales.index'));

        $this->assertSame('muhammad-habib-amrullah', $sale->fresh()->slug);
        $this->get('/sales/tes')->assertNotFound();
        $this->get('/sales/muhammad-habib-amrullah')->assertOk();

        $this->actingAs($admin)
            ->from(route('admin.sales.edit', $sale))
            ->patch(route('admin.sales.update', $sale), [
                'name' => 'Muhammad Habib Amrullah',
                'slug' => 'url-sales-lain',
                'account_enabled' => '0',
            ])
            ->assertRedirect(route('admin.sales.edit', $sale))
            ->assertSessionHasErrors('slug');

        $this->assertSame('muhammad-habib-amrullah', $sale->fresh()->slug);
    }

    public function test_public_sales_page_only_renders_active_sections_and_safe_video_embed(): void
    {
        $sale = SalesProfile::query()->create([
            'slug' => 'video-sales',
            'name' => 'Video Sales',
        ]);
        $sale->sections()->createMany([
            [
                'type' => 'video',
                'layout' => 'full_width',
                'title' => 'Video aktif',
                'media_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'type' => 'text',
                'layout' => 'full_width',
                'title' => 'Section nonaktif',
                'sort_order' => 1,
                'is_active' => false,
            ],
        ]);

        $this->get(route('sales.profile', $sale->slug))
            ->assertOk()
            ->assertSee('Video aktif')
            ->assertSee('https://www.youtube-nocookie.com/embed/abcdefghijk', false)
            ->assertSee('sales-intro--copy-only', false)
            ->assertDontSee('Pendekatan konsultatif')
            ->assertDontSee('Bukan sekadar memilih truk.')
            ->assertDontSee('Menyusun armada yang bekerja.')
            ->assertDontSee('Section nonaktif');
    }

    public function test_admin_can_choose_a_card_layout_for_video_sections(): void
    {
        $admin = User::factory()->admin()->create();
        $sale = SalesProfile::query()->create([
            'slug' => 'video-card-sales',
            'name' => 'Video Card Sales',
        ]);

        $this->actingAs($admin)->get(route('admin.sales.edit', $sale))
            ->assertOk()
            ->assertSee('Video kiri + teks kanan')
            ->assertSee('Teks kiri + video kanan');

        $this->actingAs($admin)->patch(route('admin.sales.update', $sale), [
            'name' => 'Video Card Sales',
            'account_enabled' => '0',
            'sections' => [[
                'type' => 'video',
                'layout' => 'video_right',
                'eyebrow' => 'Cerita video',
                'title' => 'Video di sisi kanan',
                'body' => 'Teks tetap terbaca di sisi kiri.',
                'media_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
                'is_active' => '1',
            ]],
        ])->assertRedirect(route('admin.sales.index'));

        $this->assertSame('video_right', $sale->sections()->sole()->layout);

        $this->get(route('sales.profile', $sale->slug))
            ->assertOk()
            ->assertSee('sales-content--video_right', false)
            ->assertSee('Video di sisi kanan');
    }

    public function test_public_sales_page_replaces_missing_local_media_with_valid_fallbacks(): void
    {
        Storage::fake('public');

        $sale = SalesProfile::query()->create([
            'slug' => 'media-hilang',
            'name' => 'Budi Santoso',
            'photo' => 'sales_photos/tidak-ada.png',
            'hero_image' => 'sales_heroes/tidak-ada.png',
            'footer_image' => 'sales_footers/tidak-ada.png',
            'documentation_photos' => ['sales_docs/tidak-ada.jpg'],
        ]);

        $this->get(route('sales.profile', $sale->slug))
            ->assertOk()
            ->assertSee(asset('img/team/ca-team-iner1.2.png'), false)
            ->assertSee(asset('img/slider/herosales.png'), false)
            ->assertSee(asset('img/slider/footersales.png'), false)
            ->assertSee(asset('img/portfolio/portfolio-big-1.3.png'), false)
            ->assertDontSee('/storage/sales_photos/tidak-ada.png', false)
            ->assertDontSee('/storage/sales_docs/tidak-ada.jpg', false);
    }
}
