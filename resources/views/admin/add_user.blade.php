@extends('admin.main')

@section('title', 'Register')

@section('content')

<!-- Register Page Start -->
<div class="container-fluid position-relative overflow-hidden" style="background: #150003; min-height:100vh;">

    <!-- Red Bubbles Canvas -->
    <canvas id="bubbleCanvas"
        class="position-absolute top-0 start-0 w-100 h-100"
        style="z-index:1; pointer-events:none;">
    </canvas>

    <!-- Background Image -->
    <img src="{{ asset('img/carousel-bg-2.jpg') }}"
         class="position-absolute top-0 start-0 w-100 h-100"
         style="object-fit: cover; opacity: 0.08; pointer-events: none; z-index: 0;">

    <!-- Registration Form -->
    <div class="d-flex justify-content-center align-items-center position-relative"
         style="z-index: 2; min-height:100vh; padding:20px;">

        <div class="card shadow-lg p-4 register-card">

            <div class="text-center mb-4">
                <h2 class="text-white fw-bold">Create Account</h2>
                <p class="text-light">Please fill your information</p>

                @if(session('success'))
                <div style="background: #28a745; color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    {{ session('success') }}
                </div>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- ROW 1 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Profile Image</label>
                        <input type="file" class="form-control" name="profile_image">
                    </div>
                </div>

                <!-- ROW 3 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">City</label>
                        <input type="text" class="form-control" name="city" placeholder="City">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white">Pincode</label>
                        <input type="number" class="form-control" name="pincode" placeholder="Pincode">
                    </div>
                </div>

                <button type="submit" class="btn w-100 fw-bold"
                    style="background:#D81324; color:white; padding:12px; font-size:17px; border-radius:8px;">
                    Register
                </button>
            </form>

            {{-- <div class="text-center mt-3 text-white">
                Already have an account?
                <a href="{{ route('login') }}" class="fw-bold" style="color:#D81324;">Login</a>
            </div> --}}

        </div>
    </div>
</div>
<!-- Register Page End -->

@endsection

@push('styles')
<style>
/* Make card scrollable on small screens */
.register-card {
    width: 900px;
    max-width: 95%;
    background: rgba(216,19,36,0.15);
    backdrop-filter: blur(8px);
    border-radius: 20px;
    /* border: 1px solid rgba(216,19,36,0.4); */
    box-shadow: 0 0 25px rgba(216,19,36,0.4);
}

/* Scrollable on short screens */
@media (max-height: 750px), (max-width: 767px) {
    .register-card {
        max-height: 90vh;
        overflow-y: auto;
        padding: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// RED BUBBLES BACKGROUND (#D81324)
const canvas = document.getElementById('bubbleCanvas');
const ctx = canvas.getContext('2d');

function resizeCanvas() {
    const dpr = window.devicePixelRatio || 1;
    canvas.width = window.innerWidth * dpr;
    canvas.height = window.innerHeight * dpr;
    canvas.style.width = window.innerWidth + "px";
    canvas.style.height = window.innerHeight + "px";
    ctx.setTransform(1,0,0,1,0,0); // reset transform
    ctx.scale(dpr, dpr);
}

resizeCanvas();

const bubbles = [];
const colors = [
    "rgba(216,19,36,0.35)",
    "rgba(216,19,36,0.25)",
    "rgba(216,19,36,0.45)",
    "rgba(216,19,36,0.30)"
];

class Bubble {
    constructor() { this.reset(); }

    reset() {
        this.x = Math.random() * window.innerWidth;
        this.y = window.innerHeight + Math.random() * 200;
        this.radius = 12 + Math.random() * 30;
        this.speed = 0.4 + Math.random() * 1.2;
        this.color = colors[Math.floor(Math.random() * colors.length)];
    }

    update() {
        this.y -= this.speed;
        if (this.y + this.radius < 0) this.reset();
    }

    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
    }
}

for (let i = 0; i < 50; i++) bubbles.push(new Bubble());

function animate() {
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    bubbles.forEach(b => { b.update(); b.draw(); });
    requestAnimationFrame(animate);
}

animate();
window.addEventListener('resize', resizeCanvas);
</script>
@endpush
