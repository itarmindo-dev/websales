<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.partials.header.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.partials.header.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- main -->
    <main>
        <!-- breadcrumb area start -->
        <section class="ca-breadcrumb-area cream-bg-3 p-relative z-index-1 fix">
            <div class="ca-breadcrumb-shape p-absolute bre-sh-1">
                <img src="/img/shape/breadcrumn-shape.png" alt="" />
            </div>
            <div class="ca-breadcrumb-shape p-absolute bre-sh-2">
                <img src="/img/shape/ca-line-shape.png" alt="" />
            </div>
            <div class="container">
                <div class="ca-breadcrumb-content text-center">
                    <h2 class="ca-breadcrumb-title fnw-600">Our Projects</h2>
                    <div class="it-breadcum-link">
                        <a href="<?php echo e(route('any', 'index')); ?>">Home</a>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <a class="active" href="<?php echo e(route('second', ['project', 'projects'])); ?>">Our Projects</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->

        <div class="ca-projects-iner pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.1.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item big-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-big-1.1.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item big-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-big-1.1.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.2.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.3.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item big-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-big-1.3.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.4.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.5.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <!-- single-portfolio-item -->
                        <div class="ca-single-portfolio-item sm-img p-relative z-index-1 fix mb-30">
                            <div class="ca-portfolio-img">
                                <img class="w-100 br-7" src="/img/portfolio/portfolio-sm-1.6.png" alt="" />
                            </div>
                            <div class="ca-portfolio-link">
                                <a href="#" class="portfolio-link portfolio-link-2"><span><img src="/img/icon/ca-portfolio-arrow-1.1.svg" alt="" /></span></a>
                            </div>
                            <div class="ca-portfolio-content-meta theme-bg-3 br-7">
                                <p>Transportation 2024</p>
                                <h4 class="ca-por-title"><a href="#">Experts in Logistics Management</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- pagination -->

                <div class="row">
                    <div class="col-12 m-auto">
                        <div class="theme-pagination text-center">
                            <ul>
                                <li>
                                    <a href="#"><i class="fa-solid fa-angle-left"></i></a>
                                </li>
                                <li>
                                    <a class="active" href="#">01</a>
                                </li>
                                <li>
                                    <a href="#">02</a>
                                </li>
                                <li>...</li>
                                <li>
                                    <a href="#">12</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-solid fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <button id="topBtn3"><i class="fa-solid fa-arrow-up"></i></button>

    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', ['title' => 'Project'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/project/projects.blade.php ENDPATH**/ ?>