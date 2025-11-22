<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <div class="container-fluid px-3">
        <!-- Brand + Mobile Toggle -->
        <div class="d-flex align-items-center w-100">
            <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center me-auto">
                <img src="{{ asset('img/logo2 .png') }}" alt="logo"
                     style="height: 70px; width: auto; object-fit: contain;">
                <!-- Desktop Title -->
                <span class="text-primary fw-bold ms-3 d-none d-lg-block">
                    MULTI BRAND FOUR WHEELER SERVICE CENTER
                </span>
                <!-- Mobile Scrolling Title -->
                <marquee behavior="scroll" direction="left" scrollamount="5"
                         class="text-primary fw-bold ms-2 d-block d-lg-none"
                         style="font-size: 15px; width: 180px;">
                    MULTI BRAND FOUR WHEELER SERVICE CENTER
                </marquee>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Nav Menu + Quote Button -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('services') }}" class="nav-item nav-link {{ request()->is('services') ? 'active' : '' }}">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="{{ route('booking') }}" class="dropdown-item">Booking</a>
                        <a href="{{ route('team') }}" class="dropdown-item">Technicians</a>
                        <a href="{{ route('testimonial') }}" class="dropdown-item">Testimonial</a>
                        <a href="{{ route('notFound') }}" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            </div>

            <!-- Quote Button (Desktop Only) -->
            <a href="{{ route('login') }}" class="btn btn-primary py-3 px-lg-4 d-none d-lg-block ms-lg-3">
               Login <i class="fa fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</nav>
<!-- Navbar End -->
