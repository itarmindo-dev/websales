<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Database\Seeders\SalesProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesProfileSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_profile_seeder_creates_complete_reusable_dummy_data(): void
    {
        $this->seed(SalesProfileSeeder::class);
        $this->seed(SalesProfileSeeder::class);

        $this->assertSame(1, SalesProfile::query()->count());
        $this->assertSame(1, User::query()->where('is_sales', true)->count());

        $profile = SalesProfile::query()->where('slug', 'budi-santoso')->sole();

        $this->assertSame('budi.sales@example.test', $profile->user->email);
        $this->assertSame('HINO Sales Executive', $profile->tagline);
        $this->assertNotEmpty($profile->phone);
        $this->assertNotEmpty($profile->whatsapp_number);
        $this->assertNotEmpty($profile->bio);
        $this->assertSame('img/slider/herosales.png', $profile->hero_image);
        $this->assertSame('img/slider/footersales.png', $profile->footer_image);
        $this->assertCount(3, $profile->documentation_photos);
        $this->assertCount(2, $profile->sections);
        $this->assertFileExists(public_path($profile->photo));
        $this->assertFileExists(public_path($profile->hero_image));
        $this->assertFileExists(public_path($profile->footer_image));

        foreach ($profile->documentation_photos as $documentationPhoto) {
            $this->assertFileExists(public_path($documentationPhoto));
        }

        $this->get(route('sales.profile', $profile->slug))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('Unit dipilih dari pekerjaan yang harus diselesaikan.')
            ->assertSee('img/team/ca-team-iner1.2.png', false)
            ->assertSee('img/portfolio/portfolio-big-1.3.png', false)
            ->assertDontSee('/storage/img/', false);
    }
}
