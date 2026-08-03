<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <?php echo e(__('Admin Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-white mb-6 sm:mb-0">
                        <h3 class="text-3xl font-bold mb-2">Halo, <?php echo e(Auth::user()->name); ?>!</h3>
                        <p class="text-green-100 text-lg">Kelola halaman sales dan pantau performa trafik website Anda di sini.</p>
                    </div>
                    <a href="<?php echo e(route('admin.sales.index')); ?>" class="bg-white text-green-700 hover:bg-green-50 font-bold py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Sales Profile Baru
                    </a>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Kunjungan (Bulan Ini)</p>
                        <h4 class="text-2xl font-bold text-gray-900">24,592</h4>
                    </div>
                </div>
                <!-- Stat 2 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Pengunjung Unik</p>
                        <h4 class="text-2xl font-bold text-gray-900">18,201</h4>
                    </div>
                </div>
                <!-- Stat 3 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tingkat Konversi (Chat WA)</p>
                        <h4 class="text-2xl font-bold text-gray-900">4.8%</h4>
                    </div>
                </div>
            </div>

            <!-- Charts Section (Google Analytics Mockup) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21.412 1.412a1 1 0 011 1v19.176a1 1 0 01-1 1H2.412a1 1 0 01-1-1v-4.176a1 1 0 011-1h1.529l4.471-7.153a1 1 0 011.69-.07l3.633 4.843 4.22-8.439a1 1 0 011.785-.021l1.672 3.344V2.412a1 1 0 011-1z"></path></svg>
                            Trafik Kunjungan Website
                        </h3>
                        <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded">30 Hari Terakhir</span>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="trafficChart"></canvas>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 text-center italic">*Data ini adalah representasi visual (mockup). Untuk integrasi GA asli, hubungkan credentials GCP Anda.</p>
                </div>

                <!-- Top Sales Pages -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Halaman Sales Paling Ramai</h3>
                    
                    <div class="space-y-6">
                        <!-- Item 1 -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-gray-700">1. /sales/budi-santoso</span>
                                <span class="text-green-600 font-bold">8,432 view</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <!-- Item 2 -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-gray-700">2. /sales/andi-hino</span>
                                <span class="text-green-600 font-bold">5,120 view</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 55%"></div>
                            </div>
                        </div>
                        <!-- Item 3 -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-gray-700">3. /sales/siti-trucks</span>
                                <span class="text-green-600 font-bold">3,890 view</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 38%"></div>
                            </div>
                        </div>
                        <!-- Item 4 -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-semibold text-gray-700">4. / (Homepage)</span>
                                <span class="text-green-600 font-bold">2,100 view</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="<?php echo e(route('admin.sales.index')); ?>" class="w-full block text-center text-sm text-green-600 hover:text-green-800 font-bold border border-green-200 rounded-lg py-2 transition-colors">
                            Kelola Semua Profil Sales &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Script for Mockup Analytics -->
     <?php $__env->slot('scripts', null, []); ?> 
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('trafficChart').getContext('2d');
                
                // Gradient for the line
                let gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(0, 155, 68, 0.5)');   
                gradient.addColorStop(1, 'rgba(0, 155, 68, 0.0)');

                const labels = [];
                const dataPoints = [];
                let baseValue = 500;
                
                // Generate 30 days of dummy data
                for(let i=30; i>=1; i--) {
                    let d = new Date();
                    d.setDate(d.getDate() - i);
                    labels.push(d.getDate() + '/' + (d.getMonth()+1));
                    
                    // random walk
                    baseValue = baseValue + (Math.random() * 200 - 80);
                    dataPoints.push(Math.round(baseValue));
                }

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Page Views',
                            data: dataPoints,
                            borderColor: '#009b44',
                            backgroundColor: gradient,
                            borderWidth: 2,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#009b44',
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f3f26',
                                titleFont: { size: 13 },
                                bodyFont: { size: 14, weight: 'bold' },
                                padding: 10,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af',
                                    maxTicksLimit: 10
                                }
                            }
                        }
                    }
                });
            });
        </script>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/dashboard.blade.php ENDPATH**/ ?>