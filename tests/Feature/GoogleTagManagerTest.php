<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleTagManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_tag_manager_is_loaded_on_public_sales_login_and_panel_pages(): void
    {
        $salesUser = User::factory()->sales()->create();
        $salesProfile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'sales-gtm',
            'name' => 'Sales GTM',
        ]);
        $admin = User::factory()->admin()->create();

        $responses = [
            $this->get(route('home')),
            $this->get(route('sales.profile', $salesProfile->slug)),
            $this->get(route('login')),
            $this->actingAs($admin)->get(route('dashboard')),
        ];

        foreach ($responses as $response) {
            $response
                ->assertOk()
                ->assertSee('https://www.googletagmanager.com/gtm.js?id=', false)
                ->assertSee('https://www.googletagmanager.com/ns.html?id=GTM-M95LQ2F7', false);

            $html = $response->getContent();

            $this->assertLessThan(
                strpos($html, '<meta'),
                strpos($html, 'https://www.googletagmanager.com/gtm.js?id='),
            );
            $this->assertLessThan(
                strpos($html, '<noscript>'),
                strpos($html, '<body'),
            );
        }
    }
}
