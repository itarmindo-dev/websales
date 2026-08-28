<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesSourceAttributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_page_uses_assigned_sales_whatsapp_for_every_sales_cta(): void
    {
        $profile = SalesProfile::query()->create([
            'slug' => 'apolos',
            'name' => 'Apolos',
            'whatsapp_number' => '6281296947879',
        ]);

        $response = $this->get(route('home', ['sales' => $profile->slug]));

        $response
            ->assertOk()
            ->assertSee('wa.me/6281296947879', false)
            ->assertSee('Halo%20Apolos', false)
            ->assertDontSee('wa.me/6281280061238', false);

        $this->assertGreaterThan(3, substr_count($response->getContent(), 'wa.me/6281296947879'));
    }

    public function test_dealer_fallback_keeps_sales_attribution_when_sales_has_no_whatsapp(): void
    {
        $profile = SalesProfile::query()->create([
            'slug' => 'sales-tanpa-nomor',
            'name' => 'Sales Tanpa Nomor',
        ]);

        $this->get(route('home', ['sales' => $profile->slug]))
            ->assertOk()
            ->assertSee('wa.me/6281280061238', false)
            ->assertSee('Saya%20membuka%20halaman%20dari%20sales%20Sales%20Tanpa%20Nomor', false);
    }

    public function test_sales_header_and_footer_keep_the_sales_source_parameter(): void
    {
        $profile = SalesProfile::query()->create([
            'slug' => 'sumber-sales',
            'name' => 'Sumber Sales',
        ]);

        $response = $this->get(route('sales.profile', $profile->slug));
        $attributedHome = route('home', ['sales' => $profile->slug]);

        $response
            ->assertOk()
            ->assertSee('href="'.$attributedHome.'"', false)
            ->assertSee('href="'.$attributedHome.'#tco"', false);
    }
}
