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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Daftar Sales Profile')); ?>

            </h2>
            <a href="<?php echo e(route('admin.sales.create')); ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Sales Baru
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Photo</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Kontak</th>
                                <th scope="col" class="px-6 py-3">Link URL</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        <?php if($sale->photo): ?>
                                            <img src="<?php echo e(asset('storage/'.$sale->photo)); ?>" class="w-10 h-10 rounded-full object-cover">
                                        <?php else: ?>
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">?</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900"><?php echo e($sale->name); ?></td>
                                    <td class="px-6 py-4">
                                        WA: <?php echo e($sale->whatsapp); ?><br>
                                        Telp: <?php echo e($sale->phone); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('sales.profile', $sale->slug)); ?>" target="_blank" class="text-blue-600 hover:underline">
                                            /sales/<?php echo e($sale->slug); ?>

                                        </a>
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="<?php echo e(route('admin.sales.edit', $sale->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="<?php echo e(route('admin.sales.destroy', $sale->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Belum ada data sales.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/admin/sales/index.blade.php ENDPATH**/ ?>