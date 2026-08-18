<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_can_be_opened(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Armindo Perkasa')
            ->assertSee('Kalkulator TCO')
            ->assertSee('tco-calculator-app', false)
            ->assertSee('wa.me/6281280061238', false);
    }

    public function test_admin_entry_points_are_protected(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertNotFound();
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/sales')->assertRedirect('/login');
        $this->get('/admin/landing-page')->assertRedirect('/login');
    }
}
