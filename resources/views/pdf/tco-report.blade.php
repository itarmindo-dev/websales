@php
    function formatRupiah($angka) { return 'Rp ' . number_format(round($angka), 0, ',', '.'); }
    function formatRupiahFloored($angka) { return 'Rp ' . number_format(floor($angka), 0, ',', '.'); }
    function formatAngka($angka, $desimal = 0) { return number_format($angka, $desimal, ',', '.'); }

    // --- 3. FORMAT SEMUA NILAI ---
    $val_periode = $periode_tco;
    $val_km_per_tahun_rumus = "{$avg_km_harian} KM/Hari * {$hari_operasi} Hari";
    $val_km_per_tahun_hasil = formatAngka($km_per_tahun) . " KM";
    $val_total_km_text = formatAngka($total_km) . " KM";
    
    $val_akuisisi_pokok_rumus = formatRupiah($harga_unit) . ' + ' . formatRupiah($harga_karoseri);
    $val_akuisisi_pokok_hasil = formatRupiah($harga_pokok);
    
    $val_bunga_rumus = formatRupiah($harga_pokok) . " * ({$bunga_flat}%) * {$durasi_bunga} Thn";
    $val_bunga_hasil = formatRupiah($total_bunga);
    
    $val_akuisisi_total_rumus = formatRupiah($harga_pokok) . ' + ' . formatRupiah($total_bunga);
    $val_akuisisi_total_hasil = formatRupiah($total_akuisisi);
    
    $val_solar_liter_rumus = formatAngka($total_km) . " KM / " . formatAngka($konsumsi_bbm, 2) . " KM/L";
    $val_solar_liter_hasil = formatAngka($total_liter_solar) . " Liter";
    
    $val_solar_biaya_rumus = formatAngka($total_liter_solar) . " L * " . formatRupiah($harga_solar);
    $val_solar_biaya_hasil = formatRupiah($total_biaya_solar);
    
    $val_ban_jumlah_rumus = formatAngka($total_km) . " KM / " . formatAngka($umur_ban) . " KM";
    $val_ban_jumlah_hasil = formatAngka($jumlah_ganti_ban, 2) . " kali";
    
    $val_ban_biaya_rumus = formatAngka($jumlah_ganti_ban, 2) . " * " . formatRupiah($harga_ban);
    $val_ban_biaya_hasil = formatRupiah($total_biaya_ban);
    
    $val_servis_total_hasil = formatRupiah($total_biaya_servis);
    $val_operasional_total_hasil = formatRupiah($total_operasional);
    $val_hjk_awal_hasil = formatRupiah($harga_pokok);
    $val_hjk_final_hasil = formatRupiah($harga_jual_kembali);
    
    $val_final_akuisisi = formatRupiah($total_akuisisi);
    $val_final_operasional = formatRupiah($total_operasional);
    $val_final_hjk = '(' . formatRupiah($harga_jual_kembali) . ')';
    $val_final_tco = formatRupiah($tco_final);
    
    $val_metric_tco = formatRupiah($tco_final);
    $val_metric_bulan_rumus = formatRupiah($tco_final) . " / " . ($periode_tco * 12) . " Bln";
    $val_metric_bulan_hasil = formatRupiahFloored($tco_per_bln) . " / Bulan";
    $val_metric_km_rumus = formatRupiah($tco_final) . " / " . formatAngka($total_km) . " KM";
    $val_metric_km_hasil = formatRupiahFloored($tco_per_km) . " / KM";
    $val_metric_ongkos_angkut = formatRupiahFloored($ongkos_angkut) . "/KM";
    $val_metric_profit_kotor = formatRupiahFloored($profit_kotor) . "/KM";
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Kalkulasi TCO - {{ $nama }}</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff; padding: 0; margin: 0; font-size: 10pt; }
        
        /* Custom Header Styling specifically for DomPDF to look premium */
        .header-box { background-color: #0f3f26; color: #fff; padding: 15px 25px; margin-bottom: 15px; border-bottom: 5px solid #00c853; }
        .header-table { width: 100%; border: none; }
        .header-table td { border: none; padding: 0; vertical-align: middle; }
        .header-logo { max-height: 45px; }
        .header-title { text-align: right; font-size: 1.4em; font-weight: bold; margin: 0; padding: 0; color: #fff; }
        .header-subtitle { text-align: right; font-size: 0.9em; margin: 5px 0 0 0; color: #a7f3d0; font-weight: normal; }

        .tco-wrapper { width: 90%; margin: 0 auto; padding: 0; }
        
        /* Original WP Colors replaced with Hino Green Theme */
        h2, h3 { color: #009b44; }
        
        .report-table { width: 100%; border-collapse: collapse; font-family: 'Segoe UI', Arial, sans-serif; margin-bottom: 15px; }
        
        .report-table th, .report-table td { 
            padding: 8px 10px; 
            line-height: 1.4; 
            vertical-align: middle; 
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            border-left: none;
            border-right: none;
        }
        .report-table .main-title-cell { font-size: 1.25em; font-weight: bold; text-align: center; color: #009b44; padding-bottom: 5px; border: none; }
        .report-table .nama-pelanggan-cell { font-size: 1.1em; font-weight: bold; text-align: center; color: #374151; padding-top: 0; padding-bottom: 15px; border: none; }
        
        .report-table .section-header td { 
            background-color: #009b44; 
            color: white; 
            font-weight: bold; 
            font-size: 1.1em; 
            margin-top: 10px; 
            border: none;
        }
        .report-table .section-header-final td { 
            background-color: #f3f4f6; 
            color: #0f3f26; 
            font-weight: bold; 
            font-size: 1.1em; 
        }
        .item-rumus, .item-hasil { font-family: Consolas, 'Courier New', monospace; font-size: 1em; }
        .item-detail { width: 35%; font-weight: normal; text-align: left; color: #374151; }
        .item-detail-header { padding-top: 15px; font-weight: bold; color: #111827; }
        .item-detail-nested { padding-left: 25px; font-style: italic; font-size: 0.9em; color: #4b5563; }
        .item-rumus { width: 35%; text-align: right; color: #6b7280; font-size: 0.9em; }
        .item-hasil { width: 30%; text-align: right; font-weight: bold; color: #111827; }
        #report_hjk_rincian td { padding-top: 8px; padding-bottom: 8px; }
        
        .total-row td, .total-row-nested td { 
            padding-top: 10px; 
            border-top: 1px solid #9ca3af !important;
            background-color: #f9fafb;
        }
        .total-label, .total-label-nested { font-weight: bold; font-size: 1.05em; text-align: left; color: #111827; }
        .total-label-nested { padding-left: 25px; font-size: 1em; color: #111827; }
        .total-value { font-size: 1.1em; color: #009b44; }
        .final-tco { color: #dc2626; font-size: 1.2em; font-weight: 900; }
        .final-metric { color: #059669; font-size: 1.15em; font-weight: bold; }
        
        .metric-explanation { 
            padding-left: 20px; 
            padding-right: 10px; 
            padding-bottom: 15px; 
            font-size: 0.85em; 
            line-height: 1.6; 
            color: #4b5563;
            border: none;
            background-color: #fff;
        }
        .page-break { page-break-before: always !important; }
        
        .final-results .total-row td {
            border-top: 2px solid #9ca3af !important; 
        }
        
        /* Footer */
        .footer-text { text-align: center; font-size: 0.8em; color: #9ca3af; margin-top: 20px; font-style: italic; }
    </style>
</head>
<body>
    <div class="header-box">
        <table class="header-table">
            <tr>
                <td style="width: 25%; text-align: left; vertical-align: middle;">
                    @php
                        $path_ap = public_path('img/logo/logoap1.png');
                        $logo_ap_base64 = '';
                        if (file_exists($path_ap)) {
                            $type_ap = pathinfo($path_ap, PATHINFO_EXTENSION);
                            $data_ap = file_get_contents($path_ap);
                            $logo_ap_base64 = 'data:image/' . $type_ap . ';base64,' . base64_encode($data_ap);
                        }
                    @endphp
                    @if(!empty($logo_ap_base64))
                        <img src="{{ $logo_ap_base64 }}" class="header-logo" alt="Logo AP">
                    @else
                        <h2 style="color:white; margin:0;">ARMINDO PERKASA</h2>
                    @endif
                </td>
                <td style="width: 50%; text-align: center; vertical-align: middle;">
                    <p class="header-title" style="text-align: center;">LAPORAN ANALISIS TCO</p>
                    <p class="header-subtitle" style="text-align: center;">TOTAL COST OF OWNERSHIP</p>
                </td>
                <td style="width: 25%; text-align: right; vertical-align: middle;">
                    @if(!empty($logo_base64))
                        <img src="{{ $logo_base64 }}" class="header-logo" alt="Logo Hino">
                    @else
                        <h2 style="color:white; margin:0;">HINO</h2>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="tco-wrapper">
        <table class="report-table">
            <tbody>
                <tr>
                    <th colspan="3" class="main-title-cell">HASIL KALKULASI TCO (Periode {{ $val_periode }} Tahun)</th>
                </tr>
                <tr>
                    <td colspan="3" class="nama-pelanggan-cell">Pelanggan: {{ $nama }} | Unit: {{ $kategori_model }}</td>
                </tr>
            </tbody>
            <tbody>
                <tr class="section-header"><td colspan="3">Kalkulasi Total KM (Penggerak Biaya Solar & Ban)</td></tr>
                <tr><td class="item-detail">KM per Tahun</td><td class="item-rumus">{{ $val_km_per_tahun_rumus }}</td><td class="item-hasil">{{ $val_km_per_tahun_hasil }}</td></tr>
                <tr><td class="item-detail">Total KM TCO ({{ $val_periode }} Tahun)</td><td class="item-rumus"></td><td class="item-hasil">{{ $val_total_km_text }}</td></tr>
            </tbody>
            <tbody>
                <tr class="section-header"><td colspan="3">Kalkulasi Biaya Akuisisi (Biaya Awal)</td></tr>
                <tr><td class="item-detail">Harga Awal (Pokok)</td><td class="item-rumus">{{ $val_akuisisi_pokok_rumus }}</td><td class="item-hasil">{{ $val_akuisisi_pokok_hasil }}</td></tr>
                <tr><td class="item-detail">Total Biaya Bunga</td><td class="item-rumus">{{ $val_bunga_rumus }}</td><td class="item-hasil">{{ $val_bunga_hasil }}</td></tr>
                <tr class="total-row"><td class="total-label">Total Akuisisi</td><td class="item-rumus">{{ $val_akuisisi_total_rumus }}</td><td class="item-hasil total-value">{{ $val_akuisisi_total_hasil }}</td></tr>
            </tbody>
            <tbody>
                <tr class="section-header"><td colspan="3">Kalkulasi Biaya Operasional (Biaya Rutin)</td></tr>
                <tr><td class="item-detail-header" colspan="3">A. Total Biaya Solar (Berbasis KM)</td></tr>
                <tr><td class="item-detail-nested">Total Liter</td><td class="item-rumus">{{ $val_solar_liter_rumus }}</td><td class="item-hasil">{{ $val_solar_liter_hasil }}</td></tr>
                <tr><td class="item-detail-nested">Biaya Solar</td><td class="item-rumus">{{ $val_solar_biaya_rumus }}</td><td class="item-hasil">{{ $val_solar_biaya_hasil }}</td></tr>
                
                <tr><td class="item-detail-header" colspan="3">B. Total Biaya Ban (Berbasis KM)</td></tr>
                <tr><td class="item-detail-nested">Jumlah Ganti Ban</td><td class="item-rumus">{{ $val_ban_jumlah_rumus }}</td><td class="item-hasil">{{ $val_ban_jumlah_hasil }}</td></tr>
                <tr><td class="item-detail-nested">Biaya Ban</td><td class="item-rumus">{{ $val_ban_biaya_rumus }}</td><td class="item-hasil">{{ $val_ban_biaya_hasil }}</td></tr>
                
                <tr><td class="item-detail-header" colspan="3">C. Total Biaya Servis (Berbasis Waktu)</td></tr>
            </tbody>
            
            <tbody>
                @foreach($rincian_servis as $servis)
                    @if($loop->first)
                        <tr>
                            <td class="item-detail-nested">Biaya Tahun 1</td>
                            <td class="item-rumus"></td>
                            <td class="item-hasil">{{ formatRupiah($servis['biaya']) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="item-detail-nested">Biaya Tahun {{ $servis['tahun'] }} (Inflasi 15%)</td>
                            <td class="item-rumus">{{ formatRupiah($servis['biaya_sebelum']) }} * 1.15</td>
                            <td class="item-hasil">{{ formatRupiah($servis['biaya']) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody> 
            
            <tbody>
                <tr class="total-row-nested"><td class="total-label-nested">Total Servis</td><td class="item-rumus"></td><td class="item-hasil total-value">{{ $val_servis_total_hasil }}</td></tr>
            </tbody>
            <tbody>
                 <tr class="total-row"><td class="total-label">Total Operasional (A + B + C)</td><td class="item-rumus"></td><td class="item-hasil total-value">{{ $val_operasional_total_hasil }}</td></tr>
            </tbody>
        </table>
        
        <table class="report-table">
            <tbody id="section-hjk">
                <tr class="section-header"><td colspan="3">Kalkulasi Harga Jual Kembali (Depresiasi)</td></tr>
                <tr><td class="item-detail">Harga Awal</td><td class="item-rumus"></td><td class="item-hasil">{{ $val_hjk_awal_hasil }}</td></tr>
            </tbody>
            <tbody id="report_hjk_rincian">
                @foreach($rincian_depresiasi as $depr)
                    <tr>
                        <td class="item-detail-nested">Nilai Akhir Tahun {{ $depr['tahun'] }} (Turun {{ $depr['rate'] }}%)</td>
                        <td class="item-rumus">{{ formatRupiah($depr['nilai_sebelum']) }} * {{ (100 - $depr['rate']) / 100 }}</td>
                        <td class="item-hasil">{{ formatRupiah($depr['nilai_sesudah']) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tbody>
                <tr class="total-row-nested"><td class="total-label-nested">Harga Jual Kembali (Tahun {{ $val_periode }})</td><td class="item-rumus"></td><td class="item-hasil total-value">{{ $val_hjk_final_hasil }}</td></tr>
            </tbody>
            <tfoot class="final-results">
                <tr class="section-header-final"><td colspan="3" style="border-top: 2px solid #009b44;">Hasil Akhir Simulasi ({{ $val_periode }} Tahun)</td></tr>
                <tr><td class="item-detail">Total Biaya Akuisisi</td><td class="item-rumus"></td><td class="item-hasil">{{ $val_final_akuisisi }}</td></tr>
                <tr><td class="item-detail">Total Biaya Operasional</td><td class="item-rumus"></td><td class="item-hasil">{{ $val_final_operasional }}</td></tr>
                <tr><td class="item-detail">(-) Harga Jual Kembali</td><td class="item-rumus"></td><td class="item-hasil">{{ $val_final_hjk }}</td></tr>
                
                <tr class="total-row"><td class="total-label" style="font-size: 1.1em;">TOTAL TCO (Biaya Bersih)</td><td class="item-rumus"></td><td class="item-hasil total-value final-tco">{{ $val_final_tco }}</td></tr>
                
                <tr class="section-header-final" style="border-top: 4px solid #009b44;"><td colspan="3">Metrik Kunci untuk Pelanggan</td></tr>
                
                <tr class="total-row" style="background-color: #fff;"><td class="total-label" style="padding-top: 15px;">Total TCO</td><td class="item-rumus" style="padding-top: 15px;"></td><td class="item-hasil total-value" style="padding-top: 15px;">{{ $val_metric_tco }}</td></tr>
                <tr><td colspan="3" class="metric-explanation"><b>Fungsinya: Menunjukkan HASIL AKHIR (Perbandingan Aset).</b><br>Total biaya bersih yang sebenarnya pelanggan keluarkan selama {{ $val_periode }} Tahun dan angka final untuk membandingkan HINO dengan pesaing.</td></tr>
                
                <tr class="total-row" style="border-top: 1px dashed #d1d5db !important; background-color: #fff;"><td class="total-label">TCO per Bulan</td><td class="item-rumus">{{ $val_metric_bulan_rumus }}</td><td class="item-hasil total-value final-metric">{{ $val_metric_bulan_hasil }}</td></tr>
                <tr><td colspan="3" class="metric-explanation"><b>Fungsinya: Menunjukkan ANGGARAN (Perencanaan Cash Flow).</b><br>Merupakan biaya riil per bulan (termasuk depresiasi, solar, servis) yang harus pelanggan siapkan untuk menjalankan unit ini.</td></tr>
                
                <tr class="total-row" style="border-top: 1px dashed #d1d5db !important; background-color: #fff;"><td class="total-label">TCO per KM</td><td class="item-rumus">{{ $val_metric_km_rumus }}</td><td class="item-hasil total-value final-metric">{{ $val_metric_km_hasil }}</td></tr>
                <tr><td colspan="3" class="metric-explanation"><b>Fungsinya: Menunjukkan PROFITABILITAS (Biaya vs Pendapatan).</b><br>Ini adalah biaya produksi per kilometer. Contoh jika ongkos angkut pelanggan <b style="color: #111827;">{{ $val_metric_ongkos_angkut }}</b>, maka Profit kotor yang dihasilkan adalah <b style="color: #059669;">{{ $val_metric_profit_kotor }}</b>.</td></tr>
            </tfoot>
        </table>

        <p class="footer-text">
            *Dokumen ini dihasilkan secara otomatis oleh Kalkulator TCO PT Armindo Perkasa.<br>
            Angka di atas bersifat estimasi dan bukan merupakan penawaran yang mengikat.
        </p>
    </div>
</body>
</html>
