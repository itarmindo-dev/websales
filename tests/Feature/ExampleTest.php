<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_landing_page_can_be_opened_without_a_database(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Armindo Perkasa')
            ->assertSee('Kalkulator TCO')
            ->assertSee('tco-calculator-app', false)
            ->assertSee('wa.me/6281280061238', false);
    }

    public function test_removed_database_backed_pages_are_not_exposed(): void
    {
        $this->get('/login')->assertNotFound();
        $this->get('/register')->assertNotFound();
        $this->get('/dashboard')->assertNotFound();
        $this->get('/admin/sales')->assertNotFound();
    }
}
