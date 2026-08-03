<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.partials.header.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.partials.header.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                    <h2 class="ca-breadcrumb-title fnw-600">Our Blog</h2>
                    <div class="it-breadcum-link">
                        <a href="<?php echo e(route('any', 'index')); ?>">Home</a>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <a class="active" href="#">Our Blog</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb area end -->

        <div class="ca-blog-inner pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.2.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 21, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">Optimizing Last-Mile Delivery: Strategies for Success</a></h4>
                                <p class="pt-16 pb-18">
                                    Delve into the challenges of last-mile delivery <br />and explore strategies to overcome them.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.3.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 20, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">Handling Project Cargo: Expert<br /> Tips and Strategies</a></h4>
                                <p class="pt-16 pb-18">
                                    Get expert tips on managing project cargo <br /> logistics. From planning and coordination.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.1.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.4.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.5.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.6.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.7.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.8.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single-blog-item -->
                    <div class="col-xl-4 col-md-6 mb-30">
                        <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
                            <div class="ca-team-img">
                                <img class="w-100" src="/img/blog/ca-blog-1.9.png" alt="" />
                            </div>
                            <div class="ca-blog-date-3 ca-blg-date-3">
                                <a href="#" class="blg-date-3">March 18, 2024</a>
                            </div>
                            <div class="ca-blog-box-content ca-blog-box-content-3">
                                <div class="ca-b-meta">
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/user-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Henry Nicolls</span>
                                        </div>
                                    </a>
                                    <!-- blog meta box -->
                                    <a href="#" class="ca-blog-meta ca-blog-meta-3">
                                        <div class="ca-meta-icon">
                                            <span><img src="/img/icon/tag-1.1.svg" alt="" /></span>
                                        </div>
                                        <div class="ca-meta-title">
                                            <span>Transport &amp; Logistics</span>
                                        </div>
                                    </a>
                                </div>
                                <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="#">The Importance of Reliable Freight Forwarding Services</a></h4>
                                <p class="pt-16 pb-18">
                                    Learn practical strategies for optimizing your<br /> supply chain operations, improve delivery.
                                </p>
                                <div class="blog-3-rearmore">
                                    <a href="<?php echo e(route('second', ['blogs', 'single'])); ?>" class="read-more3">Read More <span><i class="fa-solid fa-angle-right"></i></span></a>
                                </div>
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

<?php echo $__env->make('layouts.base', ['title' => 'Blog'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LaravelProject\Sales\WebSales\resources\views/blogs/blog.blade.php ENDPATH**/ ?>