<?php

namespace Tests\Feature;

use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesContactFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_landing_uses_dealer_whatsapp_when_sales_number_is_empty(): void
    {
        $salesUser = User::factory()->sales()->create();
        $profile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'sales-tanpa-whatsapp',
            'name' => 'Sales Tanpa WhatsApp',
        ]);

        $this->get(route('sales.profile', $profile->slug))
            ->assertOk()
            ->assertSee('Mulai konsultasi')
            ->assertSee('Chat WhatsApp')
            ->assertSee('wa.me/6281280061238', false)
            ->assertSee('WhatsApp dealer');
    }

    public function test_sales_whatsapp_still_takes_priority_over_dealer_number(): void
    {
        $salesUser = User::factory()->sales()->create();
        $profile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'sales-dengan-whatsapp',
            'name' => 'Sales Dengan WhatsApp',
            'whatsapp_number' => '6281296947879',
        ]);

        $this->get(route('sales.profile', $profile->slug))
            ->assertOk()
            ->assertSee('wa.me/6281296947879', false)
            ->assertDontSee('wa.me/6281280061238', false)
            ->assertDontSee('WhatsApp dealer');
    }
}
