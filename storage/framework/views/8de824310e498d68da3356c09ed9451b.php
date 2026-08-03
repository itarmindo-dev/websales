<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulasi TCO</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
    Halo <?php echo e($data['sales_name']); ?>, Kalkulasi TCO telah buat<br><br>
    Nama Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo e($data['nama']); ?><br>
    No. WhatsApp Customer&nbsp;: <?php echo e($data['no_wa']); ?><br><br>
    File PDF Kalkulasi terlampir<br><br>
    Dimohon untuk segera menghubungi Bpk/Ibu <?php echo e($data['nama']); ?><br><br>
    Terima Kasih.
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/emails/tco-report.blade.php ENDPATH**/ ?>