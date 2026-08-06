<?php

namespace Tests\Feature;

use App\Mail\TcoReportMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TcoSubmissionTest extends TestCase
{
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
                && $mail->pdfData['tco_per_km'] === 4848.0;
        });
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
