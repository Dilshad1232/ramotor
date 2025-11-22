@extends('homelayouts.app')

@section('title', 'Login')

@section('content')

<!-- Login Page Start -->
<div class="container-fluid vh-100 position-relative overflow-hidden" style="background: #1a1a1a;">

    <!-- Bubble Canvas -->
    <canvas id="bubbleCanvas"
        class="position-absolute top-0 start-0 w-100 h-100"
        style="z-index:1; pointer-events:none;"></canvas>

    <!-- Background Image -->
    <img src="{{ asset('img/carousel-bg-2.jpg') }}"
         class="position-absolute top-0 start-0 w-100 h-100"
         style="object-fit: cover; opacity: 0.15; pointer-events:none; z-index:0;">

    <!-- Login Form -->
    <div class="d-flex justify-content-center align-items-center vh-100 position-relative" style="z-index:2;">

        <div class="card shadow-lg p-4"
             style="width: 450px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 20px;">

            <div class="text-center mb-4">
                <h2 class="text-white fw-bold">Login</h2>
                <p class="text-light">Enter your credentials</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label text-white">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label text-white">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                {{-- Remember + Forgot --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label for="remember" class="form-check-label text-white">Remember me</label>
                    </div>
                    <a href="#" class="text-light small">Forgot Password?</a>
                </div>

                {{-- Button --}}
                <button type="submit" class="btn w-100 fw-bold text-white"
                        style="background:#D81324; border:none;">
                    Login
                </button>
            </form>

            <div class="text-center mt-3 text-white">
                Don't have an account?
                <a href="{{ route('register') }}" class="fw-bold" style="color:#D81324;">Register</a>
            </div>

        </div>
    </div>
</div>
<!-- Login Page End -->

@endsection


@push('scripts')
<script>
// Red Bubble Background (Same as Registration)
const canvas = document.getElementById('bubbleCanvas');
const ctx = canvas.getContext('2d');

function resizeCanvas() {
    const dpr = window.devicePixelRatio || 1;
    canvas.width = window.innerWidth * dpr;
    canvas.height = window.innerHeight * dpr;
    canvas.style.width = window.innerWidth + "px";
    canvas.style.height = window.innerHeight + "px";
    ctx.scale(dpr, dpr);
}
resizeCanvas();

const bubbles = [];
const colors = ['#D81324', '#ff3344', '#cc0011', '#ff6677'];

class Bubble {
    constructor() { this.reset(); }
    reset() {
        this.x = Math.random() * window.innerWidth;
        this.y = window.innerHeight + Math.random() * 100;
        this.radius = 10 + Math.random() * 30;
        this.speed = 1 + Math.random() * 2;
        this.color = colors[Math.floor(Math.random() * colors.length)];
        this.opacity = 0.1 + Math.random() * 0.3;
    }
    update() {
        this.y -= this.speed;
        if (this.y + this.radius < 0) this.reset();
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = this.opacity;
        ctx.fill();
        ctx.globalAlpha = 1;
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
