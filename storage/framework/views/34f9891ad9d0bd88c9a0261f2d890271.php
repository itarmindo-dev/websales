<?php $__env->startSection('content'); ?>
<div id="vue-app">
    <!-- Header / Cover Area -->
    <div class="relative bg-gradient-to-r from-gray-900 to-green-900 pb-32 pt-20">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586191552066-b52fbfcb6966?q=80&w=2070&auto=format&fit=crop" alt="Truck Background" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Solusi Armada Bisnis Anda
            </h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl mx-auto italic font-medium">
                "<?php echo e($sale->slogan ?? $sale->tagline ?? 'Melayani dengan sepenuh hati dan profesionalisme.'); ?>"
            </p>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="-mt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 mb-16">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <div class="md:w-1/3 bg-gray-50 p-8 flex flex-col items-center justify-center border-r border-gray-100">
                <?php if($sale->photo): ?>
                    <img src="<?php echo e(asset('storage/'.$sale->photo)); ?>" alt="<?php echo e($sale->name); ?>" class="w-48 h-48 rounded-full object-cover border-4 border-green-500 shadow-lg mb-6">
                <?php else: ?>
                    <div class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-4xl mb-6 shadow-lg border-4 border-white">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
                <h2 class="text-2xl font-bold text-gray-900"><?php echo e($sale->name); ?></h2>
                <p class="text-green-600 font-semibold mb-2">Official HINO Sales Executive</p>
                <?php if($sale->specialties): ?>
                    <p class="text-sm font-bold bg-green-100 text-green-800 px-3 py-1 rounded-full mb-4"><?php echo e($sale->specialties); ?></p>
                <?php endif; ?>
                
                <div class="flex gap-4 mb-6">
                    <?php if($sale->whatsapp_number ?? $sale->whatsapp): ?>
                        <a href="https://wa.me/<?php echo e($sale->whatsapp_number ?? $sale->whatsapp); ?>" target="_blank" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    <?php endif; ?>
                    <?php if($sale->facebook_link ?? $sale->facebook): ?>
                        <a href="<?php echo e($sale->facebook_link ?? $sale->facebook); ?>" target="_blank" class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                    <?php endif; ?>
                    <?php if($sale->instagram_link ?? $sale->instagram): ?>
                        <a href="<?php echo e($sale->instagram_link ?? $sale->instagram); ?>" target="_blank" class="w-10 h-10 rounded-full bg-pink-600 text-white flex items-center justify-center hover:bg-pink-700 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if($sale->whatsapp_number ?? $sale->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e($sale->whatsapp_number ?? $sale->whatsapp); ?>?text=Halo%20<?php echo e(urlencode($sale->name)); ?>,%20saya%20ingin%20bertanya%20tentang%20truk%20HINO." class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-full text-center transition flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp"></i> Hubungi Sekarang
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="md:w-2/3 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Tentang <?php echo e($sale->name); ?></h3>
                <div class="prose max-w-none text-gray-600 mb-8">
                    <?php echo nl2br(e($sale->bio ?? 'Berdedikasi untuk memberikan layanan terbaik dalam pemilihan unit truk HINO yang tepat untuk kebutuhan bisnis Anda.')); ?>

                </div>

                <div class="bg-[#e9f5ee] rounded-xl p-6 mb-8 border border-green-100">
                    <h4 class="font-bold text-green-800 mb-2">Kenapa Memilih Kami?</h4>
                    <ul class="space-y-2 text-green-700">
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle"></i> Unit Terjamin & Berkualitas</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle"></i> Proses Cepat & Mudah</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check-circle"></i> Layanan Purna Jual Terbaik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Showcase -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Lineup Truk HINO</h2>
            <p class="text-gray-600 mt-2">Performa tangguh untuk segala kebutuhan bisnis.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Hino 300 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://hino.co.id/images/product/1666690494.png" class="w-full h-full object-contain group-hover:scale-110 transition duration-500 p-4">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">HINO 300 (Dutro)</h3>
                    <p class="text-gray-600 text-sm mb-4">Truk ringan andalan untuk angkutan dalam kota dan distribusi barang.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li><strong>GVW:</strong> 5.2 - 8.5 Ton</li>
                        <li><strong>Tenaga:</strong> 130 - 136 PS</li>
                    </ul>
                    <?php if($sale->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e($sale->whatsapp); ?>?text=Halo%20<?php echo e(urlencode($sale->name)); ?>,%20saya%20tertarik%20dengan%20Hino%20300." class="text-green-600 font-bold hover:text-green-800 flex items-center gap-1">
                        Tanya Detail <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hino 500 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://hino.co.id/images/product/1666690562.png" class="w-full h-full object-contain group-hover:scale-110 transition duration-500 p-4">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">HINO 500 (Ranger)</h3>
                    <p class="text-gray-600 text-sm mb-4">Truk medium tangguh untuk logistik lintas kota dan konstruksi.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li><strong>GVW:</strong> 14 - 26 Ton</li>
                        <li><strong>Tenaga:</strong> 245 - 280 PS</li>
                    </ul>
                    <?php if($sale->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e($sale->whatsapp); ?>?text=Halo%20<?php echo e(urlencode($sale->name)); ?>,%20saya%20tertarik%20dengan%20Hino%20500." class="text-green-600 font-bold hover:text-green-800 flex items-center gap-1">
                        Tanya Detail <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hino 700 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group">
                <div class="h-48 bg-gray-200 overflow-hidden relative">
                    <img src="https://hino.co.id/images/product/1666690623.png" class="w-full h-full object-contain group-hover:scale-110 transition duration-500 p-4">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">HINO 700 (Profia)</h3>
                    <p class="text-gray-600 text-sm mb-4">Tractor head premium untuk angkutan beban berat ekstrem.</p>
                    <ul class="text-sm text-gray-500 mb-6 space-y-1">
                        <li><strong>GCW:</strong> 36 - 46 Ton</li>
                        <li><strong>Tenaga:</strong> 350 - 410 PS</li>
                    </ul>
                    <?php if($sale->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e($sale->whatsapp); ?>?text=Halo%20<?php echo e(urlencode($sale->name)); ?>,%20saya%20tertarik%20dengan%20Hino%20700." class="text-green-600 font-bold hover:text-green-800 flex items-center gap-1">
                        Tanya Detail <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- TCO Calculator & Docs Section -->
    <div class="bg-gray-50 py-20 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 items-start">
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Hitung Keuntungan Anda</h2>
                    <p class="text-gray-600 mb-8">Gunakan kalkulator TCO (Total Cost of Ownership) kami untuk mengestimasi biaya operasional armada Anda. Investasi cerdas dimulai dari perhitungan yang tepat bersama HINO.</p>
                    
                    <!-- Ini komponen Vue -->
                    <tco-calculator></tco-calculator>

                </div>
                
                <div class="lg:w-1/2 w-full">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Galeri Penyerahan Unit</h2>
                    <?php if($sale->documentation_photos && count($sale->documentation_photos) > 0): ?>
                        <div class="grid grid-cols-2 gap-4">
                            <?php $__currentLoopData = $sale->documentation_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(asset('storage/'.$doc)); ?>" class="w-full h-48 object-cover rounded-xl shadow-md hover:opacity-90 transition cursor-pointer">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-white p-8 rounded-xl text-center border-2 border-dashed border-gray-300">
                            <div class="text-gray-400 mb-2"><i class="fas fa-images text-4xl"></i></div>
                            <p class="text-gray-500">Belum ada foto dokumentasi.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', ['title' => 'Sales Profile - ' . $sale->name], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/pages/sales.blade.php ENDPATH**/ ?>