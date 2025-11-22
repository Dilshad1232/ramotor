<!-- admin.dashboard.blade.php -->
@extends('admin.main')

@section('title', 'Admin Dashboard')

@section('content')
<h1 style="margin-bottom:25px;color:#ff4d4d;text-shadow:1px 1px 2px #000;">Admin Dashboard</h1>

<!-- Top Stats Cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:25px;margin-bottom:40px;">
    <div class="card">🚗<h3>Total Cars</h3><p style="font-weight:bold;">50</p></div>
    <div class="card">🛠️<h3>Denting Jobs</h3><p style="font-weight:bold;">12</p></div>
    <div class="card">🎨<h3>Painting Jobs</h3><p style="font-weight:bold;">8</p></div>
    <div class="card">⭐<h3>Customer Rating</h3><p style="font-weight:bold;">4.9/5</p></div>
</div>

<!-- Service Progress -->
<h2 style="margin-bottom:15px;color:#ff4d4d;">Service Progress</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px;">
    @php
        $services = [
            ['Denting', 70, '#ff4d4d'],
            ['Painting', 50, '#ff6666'],
            ['Repairs', 90, '#ff3333'],
            ['Engine Service', 40, '#ff1a1a'],
        ];
    @endphp

    @foreach($services as $s)
    <div class="card">
        <h3>{{$s[0]}}</h3>
        <div style="background:#444;border-radius:12px;height:15px;margin-top:10px;overflow:hidden;">
            <div style="width:{{$s[1]}}%;background:{{$s[2]}};height:100%;transition:0.5s;"></div>
        </div>
        <p style="margin-top:8px;">{{$s[1]}}% Complete</p>
    </div>
    @endforeach
</div>
@endsection
