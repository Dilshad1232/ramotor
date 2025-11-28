@extends('user.main')

@section('title','Dashboard')

@section('content')

<h1 style="color:#ff4d4d;margin-bottom:20px;">Dashboard</h1>

<!-- Stats Cards -->
<div class="stats-cards" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:30px;">
    @php
        $stats = [
            ['Total Cars','20','🚗','#ff4d4d'],
            ['Denting ','6','🛠️','#ff6666'],
            ['Painting ','5','🎨','#ff3333'],
            ['Engine Services','4','⚙️','#ff1a1a'],
        ];
    @endphp

    @foreach($stats as $s)
    <div class="card" style="background:linear-gradient(145deg,#000000,#1c1c1c);padding:20px;border-radius:15px;box-shadow:0 8px 20px rgba(0,0,0,0.6);text-align:center;cursor:pointer;transition:0.3s;" onclick="alert('Show details for {{$s[0]}}')">
        <div style="font-size:2.5rem;margin-bottom:10px;">{{$s[2]}}</div>
        <h4>{{$s[0]}}</h4>
        <p style="font-size:1.5rem;font-weight:bold;">{{$s[1]}}</p>
    </div>
    @endforeach
</div>

<!-- Service Progress Section (Circular) -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Service Progress</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px;margin-bottom:30px;">
    @php
        $services = [
            ['Denting',70,'#ff4d4d'],
            ['Painting',50,'#ff6666'],
            ['Engine Service',40,'#ff1a1a'],
            ['Wheel Alignment',30,'#ff8533']
        ];
    @endphp
    @foreach($services as $service)
    <div style="text-align:center;cursor:pointer;">
        <div style="position:relative;width:100px;height:100px;margin:0 auto;">
            <svg width="100" height="100">
                <circle cx="50" cy="50" r="45" stroke="#333" stroke-width="10" fill="none"/>
                <circle cx="50" cy="50" r="45" stroke="{{$service[2]}}" stroke-width="10" fill="none"
                    stroke-dasharray="282.6"
                    stroke-dashoffset="{{ 282.6 - (282.6 * $service[1]/100) }}"
                    stroke-linecap="round"
                    transform="rotate(-90 50 50)"
                />
            </svg>
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-weight:bold;color:white;">
                {{$service[1]}}%
            </div>
        </div>
        <p style="margin-top:10px;font-weight:500;">{{$service[0]}}</p>
    </div>
    @endforeach
</div>


<!-- Quick Actions / Shortcuts -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Quick Actions</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px;margin-bottom:35px;">
    <div style="background:#ff4d4d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-plus-circle" style="font-size:2rem;margin-bottom:8px;"></i>
        <p style="margin:0;font-weight:500;">Add New Car</p>
    </div>
    <div style="background:#ff6666;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-calendar-plus" style="font-size:2rem;margin-bottom:8px;"></i>
        <p style="margin:0;font-weight:500;">Schedule Service</p>
    </div>
    <div style="background:#ff8533;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-list" style="font-size:2rem;margin-bottom:8px;"></i>
        <p style="margin:0;font-weight:500;">View My Services</p>
    </div>
    <div style="background:#ffb84d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-star" style="font-size:2rem;margin-bottom:8px;"></i>
        <p style="margin:0;font-weight:500;">Customer Feedback</p>
    </div>
</div>

<!-- Recent Jobs Table -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Latest Bookings</h2>
<div style="overflow-x:auto;background:#1c1c1c;padding:15px;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
    <table style="width:100%;color:white;border-collapse:collapse;">
        <thead style="background:#ff4d4d;">
            <tr>
                <th style="padding:10px;">Car</th>
                <th>Service</th>
                <th>Status</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $jobs = [
                    ['Honda Civic 2020','Denting','In Progress','$150'],
                    ['Toyota Corolla 2018','Painting','Pending','$200'],
                    ['Ford Mustang 2021','Repairs','Completed','$180'],
                    ['BMW X5 2019','Engine Service','In Progress','$220'],
                ];
            @endphp
            @foreach($jobs as $job)
            <tr style="border-bottom:1px solid #444;">
                <td style="padding:8px;">{{$job[0]}}</td>
                <td>{{$job[1]}}</td>
                <td>{{$job[2]}}</td>
                <td>{{$job[3]}}</td>
                <td><button onclick="showModal('{{$job[0]}}','{{$job[1]}}','{{$job[2]}}','{{$job[3]}}')" style="padding:5px 10px;border:none;border-radius:5px;background:#ff4d4d;color:white;cursor:pointer;">View</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="jobModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);justify-content:center;align-items:center;z-index:9999;">
    <div style="background:#1c1c1c;color:white;padding:25px;border-radius:15px;width:90%;max-width:500px;position:relative;">
        <span style="position:absolute;top:10px;right:15px;font-size:1.5rem;cursor:pointer;" onclick="closeModal()">×</span>
        <div id="modalContent"></div>
    </div>
</div>

<script>
function showModal(car,service,status,price){
    let html = `<h3 style="color:#ff4d4d;margin-bottom:15px;">Job Details</h3>
        <p><strong>Car:</strong> ${car}</p>
        <p><strong>Service:</strong> ${service}</p>
        <p><strong>Status:</strong> ${status}</p>
        <p><strong>Price:</strong> ${price}</p>`;
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('jobModal').style.display = 'flex';
}
function closeModal(){ document.getElementById('jobModal').style.display = 'none'; }
</script>

@endsection
