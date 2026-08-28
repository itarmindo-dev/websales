<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulasi TCO</title>
</head>
<body style="margin: 0; padding: 24px; font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #17201b; background: #f4f7f5;">
    <div style="max-width: 640px; margin: 0 auto; padding: 28px; border: 1px solid #d9e3dd; border-radius: 14px; background: #ffffff;">
        <h1 style="margin: 0 0 8px; color: #086b3b; font-size: 22px;">Lead Kalkulator TCO</h1>
        <p style="margin: 0 0 22px;">Perhitungan TCO baru telah dibuat oleh pelanggan.</p>

        @if ($data['sales_source'])
            <div style="margin-bottom: 22px; padding: 16px; border-left: 4px solid #078647; background: #eef8f2;">
                <strong style="display: block; margin-bottom: 8px; color: #075e37;">Sumber landing sales</strong>
                <div>Nama sales: {{ $data['sales_name'] }}</div>
                <div>Email sales: {{ $data['sales_email'] }}</div>
                <div>Nomor sales: {{ $data['sales_phone'] ?: '-' }}</div>
            </div>
        @else
            <div style="margin-bottom: 22px; padding: 16px; background: #f3f5f4;">
                Sumber lead: website utama Armindo Perkasa
            </div>
        @endif

        <table role="presentation" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 190px; padding: 7px 0; color: #64716a;">Nama pelanggan</td>
                <td style="padding: 7px 0; font-weight: 700;">{{ $data['nama'] }}</td>
            </tr>
            <tr>
                <td style="padding: 7px 0; color: #64716a;">WhatsApp pelanggan</td>
                <td style="padding: 7px 0; font-weight: 700;">{{ $data['no_wa'] }}</td>
            </tr>
        </table>

        <p style="margin: 22px 0 0;">File PDF kalkulasi terlampir. Mohon segera menghubungi Bapak/Ibu {{ $data['nama'] }}.</p>
    </div>
</body>
</html>
