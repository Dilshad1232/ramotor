@extends('homelayouts.app')
@section('title', 'Services')
@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase">// Our Services //</h6>
            <h1 class="fw-bold">Professional Car Care & Repair Services</h1>
        </div>

        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <!-- Card -->
                    <div class="service-card card border-0 shadow-sm position-relative overflow-hidden h-100">
                        <!-- Image with overlay icon -->
                        <div class="card-img-wrapper position-relative">
                            <img src="{{ asset('img/' . $service->image) }}" class="card-img-top img-fluid"
                                 alt="{{ $service->title }}" style="height:180px; object-fit:cover; border-radius: 10px;">
                            <div class="icon-circle position-absolute top-50 start-50 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow"
                                 style="width:60px; height:60px; font-size:28px; opacity:0.8;">
                                <i class="fa {{ $service->icon ?? 'fa-tools' }}"></i>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body text-center pt-4">
                            <h5 class="card-title fw-bold mb-2">{{ $service->title }}</h5>
                            <p class="card-text text-muted mb-3" style="height:50px; overflow:hidden; font-size:0.9rem;">
                                {{ $service->description ?? 'High-quality & trusted car care with warranty and expert technicians.' }}
                            </p>
                            <!-- Read More Button (Bootstrap default outline-primary) -->
                            <button type="button" class="btn btn-outline-primary btn-sm px-4 py-2"
                                    data-bs-toggle="modal" data-bs-target="#serviceModal{{ $service->id }}">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Small Service Modal -->
                <div class="modal fade" id="serviceModal{{ $service->id }}" tabindex="-1" aria-labelledby="serviceModalLabel{{ $service->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg rounded-3">
                      <div class="modal-header bg-primary text-white rounded-top">
                        <h5 class="modal-title fw-bold" id="serviceModalLabel{{ $service->id }}">{{ $service->title }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body p-3 text-center">
                        <img src="{{ asset('img/' . $service->image) }}" class="img-fluid mb-3 rounded" style="width:100%; height:200px; object-fit:cover;" alt="{{ $service->title }}">
                        <p class="mb-0">{{ $service->description ?? 'High-quality & trusted car care with warranty and expert technicians.' }}</p>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm px-3 py-1" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

            @endforeach
        </div>
    </div>
</div>

<style>
    /* Card hover effect */
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .service-card img {
        transition: transform 0.3s ease;
    }

    .service-card:hover img {
        transform: scale(1.05);
    }

    /* Icon hover effect */
    .icon-circle {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity:0.8;
    }
    .service-card:hover .icon-circle {
        transform: scale(1.2);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
</style>

@endsection
