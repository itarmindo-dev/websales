<!-- Header Area Start-->
<header class="header-2 stiky">
    <div class="container ca-header-bg-2">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 col-6">
                <!-- ca-logo -->
                <div class="ca-logo">
                    <a href="{{ route('second', ['demo', 'index-02']) }}"><img src="/img/logo/ca-logo2.1.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <!-- ca-main-menu -->
                <div class="ca-main-menu-2">
                    <nav class="ca-mobile-menu-active-2">
                        <ul>

                            <li>
                                <a href="#">Home <span><i class="fa-solid fa-angle-down"></i></span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('any', 'index') }}">Home 01</a></li>
                                    <li><a href="{{ route('second', ['demo', 'index-02']) }}">Home 02</a></li>
                                    <li><a href="{{ route('second', ['demo', 'index-03']) }}">Home 03</a></li>
                                    <li><a href="{{ route('second', ['demo', 'index-04']) }}">Home 04</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('second', ['pages', 'about']) }}">About Us</a></li>
                            <li>
                                <a href="#">Service <span><i class="fa-solid fa-angle-down"></i></span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('second', ['services', 'service']) }}">Service</a></li>
                                    <li><a href="{{ route('second', ['services', 'left']) }}">Service Left</a></li>
                                    <li><a href="{{ route('second', ['services', 'right']) }}">Service Right</a></li>
                                    <li><a href="{{ route('second', ['services', 'single']) }}">Service Single</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Pages <span><i class="fa-solid fa-angle-down"></i></span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('second', ['pages', 'team']) }}">Team</a></li>
                                    <li><a href="{{ route('second', ['pages', 'testimonial']) }}">Testimonial</a></li>
                                    <li><a href="{{ route('second', ['pages', 'faq']) }}">Faq</a></li>
                                    <li><a href="{{ route('second', ['pages', 'pricing']) }}">Pricing Plan</a></li>
                                    <li><a href="{{ route('second', ['pages', 'contact']) }}">Contact Us</a></li>
                                    <li><a href="{{ route('second', ['pages', '404']) }}">404</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Project <span><i class="fa-solid fa-angle-down"></i></span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('second', ['project', 'projects']) }}">Project</a></li>
                                    <li><a href="{{ route('second', ['project', 'left']) }}">Project Left</a></li>
                                    <li><a href="{{ route('second', ['project', 'right']) }}">Project Right</a></li>
                                    <li><a href="{{ route('second', ['project', 'single']) }}">Project Single</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <!-- ca-btn -->
                <div class="ca-btn-header text-end d-none d-lg-block">
                    <a href="{{ route('second', ['pages', 'contact']) }}" class="ca-btn-primary-22">Get A Free Quote <span><i class="fa-solid fa-arrow-right"></i></span></a>
                </div>

                <div class="ca-header-action-item d-lg-none text-end">
                    <button type="button" class="ca-offcanvas-toogle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 30 16">
                            <rect x="10" width="20" height="2" fill="currentColor"></rect>
                            <rect x="5" y="7" width="25" height="2" fill="currentColor"></rect>
                            <rect x="10" y="14" width="20" height="2" fill="currentColor"></rect>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End-->
<!-- offcanvas start -->
<div class="ca-offcanvas w-bg">
    <div class="ca-offcanvas-wrapper">
        <div class="ca-offcanvas-header d-flex justify-content-between align-items-center mb-40">
            <div class="ca-offcanvas-logo">
                <a href="#"><img src="/img/logo/ca-logo2.2.png" alt=""></a>
            </div>
            <div class="ca-offcanvas-close">
                <button class="ca-offcanvas-close-toggle"><i class="fal fa-times"></i></button>
            </div>
        </div>
        <div class="ca-offcanvas-menu-2 mb-40">
            <nav>
            </nav>
        </div>
        <div class="ca-offcanvas-contact mb-40">
            <a href="#" class="ca-btn-primary ca-btn-primary-2 theme-bg-2 text-white">Get A Quote<span><i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
        <div class="ca-offcanvas-contact-info mb-40">
            <h3 class="ca-offcanvas-sm-title">Contact Info</h3>
            <!-- single item -->
            <div class="ca-sm-single-item-4 mb-20">
                <div class="icon">
                    <span>
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                </div>
                <div class="ca-sm-single-item-4-content">
                    <p><a href="#">55 Street, 2nd block, 3rd Floor
                            Melbourne, Australia</a></p>
                </div>
            </div>

            <!-- single item -->
            <div class="ca-sm-single-item-4 mb-20">
                <div class="icon">
                    <span>
                        <i class="fa-solid fa-phone"></i>
                    </span>
                </div>
                <div class="ca-sm-single-item-4-content">
                    <p><a href="tel:+0221234568806">+022 (123) 456 88 06</a></p>
                </div>
            </div>

            <!-- single item -->
            <div class="ca-sm-single-item-4 mb-20">
                <div class="icon">
                    <span>
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                </div>
                <div class="ca-sm-single-item-4-content">
                    <p><a href="mailto:infocargon@gmail.com">infocargon@gmail.com</a></p>
                </div>
            </div>
        </div>
        <div class="ca-offcanvas-social mb-40">
            <h3 class="ca-offcanvas-sm-title">Follow Us</h3>
            <div class="ca-footer-social ca-footer-social-2">
                <ul>
                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="ca-offcanvas-overlay"></div>
<!-- offcanvas end -->
