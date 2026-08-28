<?php

namespace Tests\Feature;

use App\Mail\TcoReportMail;
use App\Models\SalesProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TcoSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_tco_submission_generates_and_sends_the_original_report(): void
    {
        Mail::fake();

        $response = $this->postJson(route('tco.submit'), $this->validPayload());

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Laporan TCO berhasil dikirim ke email.',
            ]);

        Mail::assertSent(TcoReportMail::class, function (TcoReportMail $mail): bool {
            return $mail->hasTo('itarmindo@gmail.com')
                && $mail->pdfData['nama'] === 'Budi Santoso'
                && $mail->pdfData['kategori_model'] === 'Dutro 115 HD STD'
                && $mail->pdfData['total_km'] === 150000.0
                && $mail->pdfData['tco_per_km'] === 4848.0
                && $mail->pdfData['sales_source'] === false;
        });
    }

    public function test_tco_from_a_sales_landing_is_sent_to_main_and_assigned_sales_email(): void
    {
        Mail::fake();

        $salesUser = User::factory()->sales()->create([
            'name' => 'Apolos',
            'email' => 'apoloswalalayo@yahoo.com',
        ]);
        $profile = SalesProfile::query()->create([
            'user_id' => $salesUser->id,
            'slug' => 'apolos',
            'name' => 'Apolos',
            'whatsapp_number' => '081296947879',
        ]);

        $this->get(route('sales.profile', $profile->slug))
            ->assertOk()
            ->assertSee(route('home', ['sales' => $profile->slug]).'#tco', false);

        $this->get(route('home', ['sales' => $profile->slug]))
            ->assertOk()
            ->assertSee('data-sales-slug="apolos"', false)
            ->assertSee('data-sales-name="Apolos"', false);

        $response = $this->postJson(route('tco.submit'), [
            ...$this->validPayload(),
            'sales_slug' => $profile->slug,
            'sales_email' => 'alamat-palsu@example.com',
        ]);

        $response->assertOk()->assertJsonPath('success', true);

        Mail::assertSent(TcoReportMail::class, function (TcoReportMail $mail): bool {
            return $mail->hasTo('itarmindo@gmail.com')
                && $mail->hasTo('apoloswalalayo@yahoo.com')
                && ! $mail->hasTo('alamat-palsu@example.com')
                && $mail->pdfData['sales_source'] === true
                && $mail->pdfData['sales_name'] === 'Apolos'
                && $mail->pdfData['sales_email'] === 'apoloswalalayo@yahoo.com'
                && $mail->pdfData['sales_phone'] === '081296947879'
                && str_contains($mail->render(), 'Sumber landing sales');
        });
    }

    public function test_unknown_sales_slug_is_rejected_without_sending_email(): void
    {
        Mail::fake();

        $this->postJson(route('tco.submit'), [
            ...$this->validPayload(),
            'sales_slug' => 'sales-tidak-ada',
        ])->assertUnprocessable();

        Mail::assertNothingSent();
    }

    public function test_invalid_tco_submission_does_not_send_an_email(): void
    {
        Mail::fake();

        $response = $this->postJson(route('tco.submit'), [
            'nama' => '',
            'no_wa' => '',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonPath('success', false);

        Mail::assertNothingSent();
    }

    public function test_production_does_not_report_success_when_mailer_cannot_deliver_email(): void
    {
        Mail::fake();
        $this->app->detectEnvironment(fn (): string => 'production');
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
        config(['mail.default' => 'log']);

        $this->postJson(route('tco.submit'), $this->validPayload())
            ->assertInternalServerError()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.');

        Mail::assertNothingSent();
    }

    private function validPayload(): array
    {
        return [
            'nama' => 'Budi Santoso',
            'no_wa' => '081234567890',
            'avg_km_harian' => 100,
            'hari_operasi' => 300,
            'periode_tco' => 5,
            'konsumsi_bbm' => 5.53,
            'harga_unit' => 450000000,
            'harga_karoseri' => 90000000,
            'bunga_flat' => 7.5,
            'durasi_bunga' => 5,
            'harga_solar' => 6800,
            'harga_ban' => 14000000,
            'umur_ban' => 40000,
            'tipe_unit' => '115',
            'kategori_model' => 'Dutro 115 HD STD',
            'kondisi_jalan' => 'All Around (Kombinasi)',
        ];
    }
}
