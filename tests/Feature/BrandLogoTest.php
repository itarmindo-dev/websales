<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandLogoTest extends TestCase
{
    use RefreshDatabase;

    public function test_armindo_logo_is_rendered_on_login_panel_and_sales_landing(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('img/logo/logoap1.png', false);

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('img/logo/logoap1.png', false);

        $salesUser = User::factory()->sales()->create();
        $salesProfile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'sales-logo-armindo',
            'name' => 'Sales Logo Armindo',
        ]);

        $this->get(route('sales.profile', $salesProfile->slug))
            ->assertOk()
            ->assertSee('img/logo/logoap1.png', false)
            ->assertSee('sales-brand-lockup', false)
            ->assertSee('sales-footer-lockup', false);
    }
}
