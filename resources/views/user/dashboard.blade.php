@extends('user.main')

@section('title', 'Garage Dashboard')

@section('content')

<h1 style="color:#ff4d4d;margin-bottom:25px;text-shadow:1px 1px 3px #000;">Car Garage Dashboard</h1>

<!-- Top Stats Cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:40px;">
  <div class="card" style="background:#1f1f1f;color:white;padding:25px;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.6);text-align:center;transition:0.3s;">
    <div style="font-size:2.5rem;margin-bottom:10px;">🚗</div>
    <h3>Total Cars</h3>
    <p style="font-size:1.5rem;font-weight:bold;">20</p>
  </div>
  <div class="card" style="background:#1f1f1f;color:white;padding:25px;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.6);text-align:center;transition:0.3s;">
    <div style="font-size:2.5rem;margin-bottom:10px;">🛠️</div>
    <h3>Denting Jobs</h3>
    <p style="font-size:1.5rem;font-weight:bold;">6</p>
  </div>
  <div class="card" style="background:#1f1f1f;color:white;padding:25px;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.6);text-align:center;transition:0.3s;">
    <div style="font-size:2.5rem;margin-bottom:10px;">🎨</div>
    <h3>Painting Jobs</h3>
    <p style="font-size:1.5rem;font-weight:bold;">5</p>
  </div>
  <div class="card" style="background:#1f1f1f;color:white;padding:25px;border-radius:15px;box-shadow:0 10px 25px rgba(0,0,0,0.6);text-align:center;transition:0.3s;">
    <div style="font-size:2.5rem;margin-bottom:10px;">⚙️</div>
    <h3>Engine Services</h3>
    <p style="font-size:1.5rem;font-weight:bold;">4</p>
  </div>
</div>

<!-- Service Progress -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Service Progress</h2>
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
  <div class="card" style="padding:20px;border-radius:15px;background:#2c2c2c;color:white;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
    <h3>{{$s[0]}}</h3>
    <div style="background:#444;border-radius:12px;height:15px;margin-top:10px;overflow:hidden;">
      <div style="width:{{$s[1]}}%;background:{{$s[2]}};height:100%;transition:0.5s;"></div>
    </div>
    <p style="margin-top:8px;">{{$s[1]}}% Complete</p>
  </div>
  @endforeach
</div>

<!-- Recent Jobs Cards -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Recent Jobs</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:30px;">
  @php
    $jobs = [
      ['Honda Civic 2020', 'Denting', 'In Progress', '$150'],
      ['Toyota Corolla 2018', 'Painting', 'Pending', '$200'],
      ['Ford Mustang 2021', 'Repairs', 'Completed', '$180'],
      ['BMW X5 2019', 'Engine Service', 'In Progress', '$220'],
    ];
  @endphp

  @foreach($jobs as $j)
  <div class="card" style="padding:20px;border-radius:15px;background:#2c2c2c;color:white;box-shadow:0 8px 20px rgba(0,0,0,0.5);transition:0.3s;cursor:pointer;">
    <h4>{{$j[0]}}</h4>
    <p>Service: <strong>{{$j[1]}}</strong></p>
    <p>Status: <span style="color:#ff4d4d">{{$j[2]}}</span></p>
    <p>Price: <strong>{{$j[3]}}</strong></p>
  </div>
  @endforeach
</div>

<!-- Quick Actions -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Quick Actions</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;">
  <div class="card" style="background:linear-gradient(145deg,#ff4d4d,#d32f2f);color:white;text-align:center;padding:25px;border-radius:15px;cursor:pointer;box-shadow:0 8px 20px rgba(0,0,0,0.5);transition:0.3s;">
    <div style="font-size:2rem;margin-bottom:10px;">🚗</div>
    <h3>Add New Car</h3>
  </div>
  <div class="card" style="background:linear-gradient(145deg,#ff6666,#b71c1c);color:white;text-align:center;padding:25px;border-radius:15px;cursor:pointer;box-shadow:0 8px 20px rgba(0,0,0,0.5);transition:0.3s;">
    <div style="font-size:2rem;margin-bottom:10px;">🛠️</div>
    <h3>Schedule Service</h3>
  </div>
  <div class="card" style="background:linear-gradient(145deg,#ff3333,#b71c1c);color:white;text-align:center;padding:25px;border-radius:15px;cursor:pointer;box-shadow:0 8px 20px rgba(0,0,0,0.5);transition:0.3s;">
    <div style="font-size:2rem;margin-bottom:10px;">🎨</div>
    <h3>Painting Jobs</h3>
  </div>
  <div class="card" style="background:linear-gradient(145deg,#ff1a1a,#d32f2f);color:white;text-align:center;padding:25px;border-radius:15px;cursor:pointer;box-shadow:0 8px 20px rgba(0,0,0,0.5);transition:0.3s;">
    <div style="font-size:2rem;margin-bottom:10px;">⭐</div>
    <h3>Customer Feedback</h3>
  </div>
</div>

@endsection
