@extends('homelayouts.app')
@section('title', 'Booking')
@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-bg-1.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Booking</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-certificate fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Quality Servicing</h5>
                            <p>Diam dolor diam ipsum sit amet diam et eos erat ipsum</p>
                            <a class="text-secondary border-bottom" href="">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-users-cog fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Expert Workers</h5>
                            <p>Diam dolor diam ipsum sit amet diam et eos erat ipsum</p>
                            <a class="text-secondary border-bottom" href="">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-tools fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Modern Equipment</h5>
                            <p>Diam dolor diam ipsum sit amet diam et eos erat ipsum</p>
                            <a class="text-secondary border-bottom" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Booking Start -->
    <div class="container-fluid bg-secondary booking my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6 py-5">
                    <div class="py-5">
                        <h1 class="text-white mb-4">Certified and Award Winning Car Repair Service Provider</h1>
                        <p class="text-white mb-0">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd ipsum. Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt voluptua. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem. Elitr ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-primary h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                        @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

                        <h1 class="text-white mb-4">Book For A Service</h1>
                        <form action="{{ route('booking.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">

                                <div class="col-12 col-sm-6">
                                    <input type="text" name="name" class="form-control border-0" placeholder="Your Name" style="height: 55px;" required>
                                    <div class="invalid-feedback">
                                        Please enter your name.
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="email" name="email" class="form-control border-0" placeholder="Your Email" style="height: 55px;" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email.
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <select class="form-select border-0" name="service" style="height: 55px;" required>
                                        <option value="">Select A Service</option>
                                        <option value="Painting">Painting</option>
                                        <option value="Denting">Denting</option>
                                        <option value="Engine Repair">Engine Repair</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a service.
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="date" name="service_date" class="form-control border-0" style="height: 55px;" required>
                                    <div class="invalid-feedback">
                                        Please choose a service date.
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="tel" name="phone" class="form-control border-0" placeholder="Mobile" style="height: 55px;" required pattern="[0-9]{10}">
                                    <div class="invalid-feedback">
                                        Please enter a valid 10-digit phone number.
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="text" name="address" class="form-control border-0" placeholder="Address" style="height: 55px;">
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control border-0" name="special_request" placeholder="Special Request"></textarea>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-secondary w-100 py-3" type="submit">Book Now</button>
                                </div>

                            </div>
                        </form>

                        <script>
                        // Bootstrap 5 custom validation
                        (function () {
                            'use strict'
                            var forms = document.querySelectorAll('.needs-validation')
                            Array.prototype.slice.call(forms)
                                .forEach(function (form) {
                                    form.addEventListener('submit', function (event) {
                                        if (!form.checkValidity()) {
                                            event.preventDefault()
                                            event.stopPropagation()
                                        }
                                        form.classList.add('was-validated')
                                    }, false)
                                })
                        })();
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->


    <!-- Call To Action Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8 col-md-6">
                    <h6 class="text-primary text-uppercase">// Call To Action //</h6>
                    <h1 class="mb-4">Have Any Pre Booking Question?</h1>
                    <p class="mb-0">Lorem diam ea sit dolor labore. Clita et dolor erat sed est lorem sed et sit. Diam sed duo magna erat et stet clita ea magna ea sed, sit labore magna lorem tempor justo rebum dolores. Eos dolor sea erat amet et, lorem labore lorem at dolores. Stet ea ut justo et, clita et et ipsum diam.</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-primary d-flex flex-column justify-content-center text-center h-100 p-4">
                        <h3 class="text-white mb-4"><i class="fa fa-phone-alt me-3"></i>+012 345 6789</h3>
                        <a href="" class="btn btn-secondary py-3 px-5">Contact Us<i class="fa fa-arrow-right ms-3"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Call To Action End -->


    @if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Booking Successful!',
        icon: 'success',
        html: `
            <b>Name:</b> {{ old('name', session('name')) }} <br>
            <b>Email:</b> {{ old('email', session('email')) }} <br>
            <b>Service:</b> {{ old('service', session('service')) }} <br>
            <b>Service Date:</b> {{ old('service_date', session('service_date')) }} <br>
            <b>Special Request:</b> {{ old('special_request', session('special_request')) }} <br>
            <b>Phone:</b> {{ old('phone', session('phone')) }} <br>
            <b>Address:</b> {{ old('address', session('address')) }}
        `,
        confirmButtonText: 'OK'
    });
</script>
@endif

    @endsection
