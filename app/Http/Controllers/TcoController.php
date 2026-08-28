<?php

namespace App\Http\Controllers;

use App\Mail\TcoReportMail;
use App\Models\SalesProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class TcoController extends Controller
{
    public function submit(Request $request)
    {
        try {
            // --- 1. VALIDASI INPUT ---
            $validated = $request->validate([
                'nama'          => 'required|string|max:255',
                'no_wa'         => 'required|string|max:30',
                'avg_km_harian' => 'required|numeric|min:1',
                'hari_operasi'  => 'required|numeric|min:1',
                'periode_tco'   => 'required|numeric|min:1|max:10',
                'konsumsi_bbm'  => 'required|numeric|min:0.01',
                'harga_unit'    => 'required|numeric|min:0',
                'harga_karoseri'=> 'nullable|numeric|min:0',
                'bunga_flat'    => 'nullable|numeric|min:0',
                'durasi_bunga'  => 'nullable|numeric|min:0',
                'harga_solar'   => 'required|numeric|min:0',
                'harga_ban'     => 'required|numeric|min:0',
                'umur_ban'      => 'required|numeric|min:1',
                'tipe_unit'     => 'nullable|string',
                'kategori_model'=> 'nullable|string',
                'kondisi_jalan' => 'nullable|string',
                'sales_slug'    => 'nullable|string|max:255|exists:sales_profiles,slug',
            ]);

            // --- 2. AMBIL DATA ---
            $nama           = $validated['nama'];
            $no_wa          = $validated['no_wa'];
            $avg_km_harian  = (float) $validated['avg_km_harian'];
            $hari_operasi   = (float) $validated['hari_operasi'];
            $periode_tco    = (int) $validated['periode_tco'];
            $konsumsi_bbm   = (float) $validated['konsumsi_bbm'];
            $harga_unit     = (float) $validated['harga_unit'];
            $harga_karoseri = (float) ($validated['harga_karoseri'] ?? 0);
            $bunga_flat     = (float) ($validated['bunga_flat'] ?? 0);
            $durasi_bunga   = (int) ($validated['durasi_bunga'] ?? 0);
            $harga_solar    = (float) $validated['harga_solar'];
            $harga_ban      = (float) $validated['harga_ban'];
            $umur_ban       = (float) $validated['umur_ban'];
            $tipe_unit      = $validated['tipe_unit'] ?? '-';
            $kategori_model = $validated['kategori_model'] ?? '-';
            $kondisi_jalan  = $validated['kondisi_jalan'] ?? '-';
            
            $salesProfile = isset($validated['sales_slug'])
                ? SalesProfile::query()->with('user:id,email')->where('slug', $validated['sales_slug'])->first()
                : null;
            $mainRecipientEmail = config('tco.recipient_email');
            $mainRecipientName = config('tco.recipient_name');
            $sales_name = $salesProfile?->name ?? 'Tim Sales';
            $sales_email = $salesProfile?->user?->email ?? $mainRecipientEmail;
            $sales_phone = $salesProfile?->whatsapp_number
                ?? $salesProfile?->whatsapp
                ?? $salesProfile?->phone;

            $this->assertMailDeliveryConfigured();

            // --- 3. PERHITUNGAN TCO ---
            $km_per_tahun = $avg_km_harian * $hari_operasi;
            $total_km     = $km_per_tahun * $periode_tco;

            // Akuisisi
            $harga_pokok    = $harga_unit + $harga_karoseri;
            $total_bunga    = $harga_pokok * ($bunga_flat / 100) * $durasi_bunga;
            $total_akuisisi = $harga_pokok + $total_bunga;

            // Solar
            $total_liter_solar = ($konsumsi_bbm > 0) ? floor($total_km / $konsumsi_bbm) : 0;
            $total_biaya_solar = $total_liter_solar * $harga_solar;

            // Ban
            $jumlah_ganti_ban = ($umur_ban > 0) ? round($total_km / $umur_ban, 2) : 0;
            $total_biaya_ban  = $jumlah_ganti_ban * $harga_ban;

            // Servis (naik 15% per tahun)
            $HARGA_SERVIS_TAHUN_1 = 7271111;
            $total_biaya_servis   = 0;
            $rincian_servis       = [];
            $biaya_servis_prev    = $HARGA_SERVIS_TAHUN_1;

            for ($tahun = 1; $tahun <= $periode_tco; $tahun++) {
                if ($tahun === 1) {
                    $biaya_tahun_ini = $HARGA_SERVIS_TAHUN_1;
                } else {
                    $biaya_tahun_ini = round($biaya_servis_prev * 1.15);
                }
                
                $rincian_servis[] = [
                    'tahun'         => $tahun,
                    'biaya'         => $biaya_tahun_ini,
                    'biaya_sebelum' => $biaya_servis_prev,
                ];
                
                $total_biaya_servis += $biaya_tahun_ini;
                $biaya_servis_prev = $biaya_tahun_ini;
            }

            // Total Operasional
            $total_operasional = $total_biaya_solar + $total_biaya_ban + $total_biaya_servis;

            // Harga Jual Kembali (Depresiasi)
            $rincian_depresiasi = [];
            $nilai_sisa         = $harga_pokok;

            for ($tahun = 1; $tahun <= $periode_tco; $tahun++) {
                $depr_rate = ($tahun === 1) ? 0.15 : (($tahun >= 2 && $tahun <= 5) ? 0.10 : 0.05);
                $nilai_sebelum = $nilai_sisa;
                $nilai_sisa    = $nilai_sebelum * (1 - $depr_rate);

                $rincian_depresiasi[] = [
                    'tahun'          => $tahun,
                    'rate'           => $depr_rate * 100,
                    'nilai_sebelum'  => $nilai_sebelum,
                    'nilai_sesudah'  => $nilai_sisa,
                ];
            }
            $harga_jual_kembali = $nilai_sisa;

            // Final TCO
            $tco_final   = ($total_akuisisi + $total_operasional) - $harga_jual_kembali;
            $tco_per_km  = ($total_km > 0) ? floor($tco_final / $total_km) : 0;
            $tco_per_bln = ($periode_tco > 0) ? floor($tco_final / ($periode_tco * 12)) : 0;

            // Ongkos angkut & profit
            $ongkos_angkut_raw = ($tco_per_km * 0.5) + $tco_per_km;
            $ongkos_angkut     = ceil($ongkos_angkut_raw / 1000) * 1000;
            $profit_kotor      = $ongkos_angkut - $tco_per_km;

            // --- 4. SUSUN DATA UNTUK PDF ---
            $pdfData = [
                'nama'              => $nama,
                'no_wa'             => $no_wa,
                'tipe_unit'         => $tipe_unit,
                'kategori_model'    => $kategori_model,
                'kondisi_jalan'     => $kondisi_jalan,
                'avg_km_harian'     => $avg_km_harian,
                'hari_operasi'      => $hari_operasi,
                'periode_tco'       => $periode_tco,
                'konsumsi_bbm'      => $konsumsi_bbm,
                'km_per_tahun'      => $km_per_tahun,
                'total_km'          => $total_km,
                'harga_unit'        => $harga_unit,
                'harga_karoseri'    => $harga_karoseri,
                'harga_pokok'       => $harga_pokok,
                'bunga_flat'        => $bunga_flat,
                'durasi_bunga'      => $durasi_bunga,
                'total_bunga'       => $total_bunga,
                'total_akuisisi'    => $total_akuisisi,
                'total_liter_solar' => $total_liter_solar,
                'harga_solar'       => $harga_solar,
                'total_biaya_solar' => $total_biaya_solar,
                'umur_ban'          => $umur_ban,
                'jumlah_ganti_ban'  => $jumlah_ganti_ban,
                'harga_ban'         => $harga_ban,
                'total_biaya_ban'   => $total_biaya_ban,
                'rincian_servis'    => $rincian_servis,
                'total_biaya_servis'=> $total_biaya_servis,
                'total_operasional' => $total_operasional,
                'rincian_depresiasi'=> $rincian_depresiasi,
                'harga_jual_kembali'=> $harga_jual_kembali,
                'tco_final'         => $tco_final,
                'tco_per_km'        => $tco_per_km,
                'tco_per_bln'       => $tco_per_bln,
                'ongkos_angkut'     => $ongkos_angkut,
                'profit_kotor'      => $profit_kotor,
                'tanggal'           => now()->format('d F Y'),
                'sales_name'        => $sales_name,
                'sales_email'       => $sales_email,
                'sales_phone'       => $sales_phone,
                'sales_source'      => (bool) $salesProfile,
            ];

            // Tambahkan Base64 Logo Hino untuk PDF Header
            $logo_path = public_path('img/logo/logohino.png');
            if (file_exists($logo_path)) {
                $pdfData['logo_base64'] = 'data:image/png;base64,' . base64_encode(file_get_contents($logo_path));
            } else {
                $pdfData['logo_base64'] = '';
            }

            // --- 5. GENERATE PDF ---
            $pdf = Pdf::loadView('pdf.tco-report', $pdfData);
            $pdf->setPaper('A4', 'portrait');

            $namaFile = 'TCO - ' . preg_replace('/[^a-zA-Z0-9 ]/', '', $nama) . ' - ' . preg_replace('/[^0-9]/', '', $no_wa) . '.pdf';

            // --- 6. KIRIM EMAIL ---
            $pdfContent = $pdf->output();
            
            $recipients = [
                ['email' => $mainRecipientEmail, 'name' => $mainRecipientName],
            ];
            
            if (strcasecmp($sales_email, $mainRecipientEmail) !== 0) {
                $recipients[] = ['email' => $sales_email, 'name' => $sales_name];
            }

            Mail::to($recipients)
                ->send(new TcoReportMail($pdfData, $pdfContent, $namaFile));

            return response()->json([
                'success' => true,
                'message' => 'Laporan TCO berhasil dikirim ke email.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all()),
            ], 422);
        } catch (\Exception $e) {
            Log::error('TCO Submit Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Format angka ke Rupiah
     */
    private function formatRupiah($angka): string
    {
        return 'Rp ' . number_format(round($angka), 0, ',', '.');
    }

    private function assertMailDeliveryConfigured(): void
    {
        if (! app()->isProduction()) {
            return;
        }

        $mailer = (string) config('mail.default');

        if (in_array($mailer, ['array', 'log'], true)) {
            throw new RuntimeException(
                "TCO email delivery is disabled because MAIL_MAILER is set to [{$mailer}].",
            );
        }

        if (! filter_var(config('mail.from.address'), FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('MAIL_FROM_ADDRESS is not a valid email address.');
        }
    }
}
