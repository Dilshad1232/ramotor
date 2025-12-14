@extends('user.main')

@section('title','Dashboard')

@section('content')

<style>
    @media(max-width:768px){
    .main-content {
        margin-left: 0 !important;
        padding: 15px;
        position: relative;
        z-index: 1;    /* important */
    }

    .sidebar {
        z-index: 1000; /* sidebar always stays on top */
    }
}

</style>
<h1 style="color:#ff4d4d;margin-bottom:20px;padding-bottom:10px;border-bottom:1px solid #ff4d4d;">Dashboard</h1>

<!-- Stats Cards -->
<div class="stats-cards " style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:30px;">
    @foreach($stats as $s)
    <div class="card"
         style="background:linear-gradient(145deg,#686060,#1c1c1c);padding:20px;border-radius:15px;box-shadow:0 8px 20px rgba(0,0,0,0.6);text-align:center;cursor:pointer;transition:0.3s;">
        <div style="font-size:2.5rem;margin-bottom:10px;">{{$s[2]}}</div>
        <h4>{{$s[0]}}</h4>
        <p style="font-size:1.5rem;font-weight:bold;">{{$s[1]}}</p>
    </div>
    @endforeach
</div>

<!-- Quick Actions -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Quick Actions</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:20px;margin-bottom:35px;">
    <div style="background:#ff4d4d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-plus-circle" style="font-size:2rem;margin-bottom:8px;"></i>
        <a href="{{route('user.book-service')}}" style="margin:0;font-weight:500;text-decoration:none;color:white;">Add New Service</a>
    </div>
    <div style="background:#ff4d4d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-plus-circle" style="font-size:2rem;margin-bottom:8px;"></i>
        <a href="{{ route('user.schedule_service') }}" style="margin:0;font-weight:500;text-decoration:none;color:white;">Schedule Services</a>
    </div>
    <div style="background:#ff4d4d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-plus-circle" style="font-size:2rem;margin-bottom:8px;"></i>
        <a href="{{route('user.services')}}" style="margin:0;font-weight:500;text-decoration:none;color:white;">View Services</a>
    </div>
    <div style="background:#ffb84d;color:white;padding:20px;text-align:center;border-radius:12px;cursor:pointer;transition:0.3s;">
        <i class="fa fa-star" style="font-size:2rem;margin-bottom:8px;"></i>
        <p style="margin:0;font-weight:500;">Customer Feedback</p>
    </div>
</div>

<!-- Latest Bookings Table -->
<h2 style="color:#ff4d4d;margin-bottom:15px;">Latest Bookings</h2>
<div style="overflow-x:auto;background:#1c1c1c;padding:15px;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.5);">
    <table id="bookingsTable" style="width:100%;color:white;border-collapse:collapse;">
        <thead style="background:#ff4d4d;" >
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Service Date</th>
                <th>Special Request</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr style="border-bottom:1px solid #444;">
                <td style="padding:8px;">{{ $b->name }}</td>
                <td>{{ $b->email }}</td>
                <td>{{ $b->service }}</td>
                <td>{{ $b->service_date }}</td>
                <td>{{ $b->special_request }}</td>
                <td>{{ $b->phone }}</td>
                <td style="text-transform: capitalize;">
                    @if($b->status == 'pending')
                        <span style="color:#ff9800;font-weight:bold;">Pending</span>
                    @elseif($b->status == 'approved')
                        <span style="color:#4caf50;font-weight:bold;">Approved</span>
                    @else
                        <span style="color:#f44336;font-weight:bold;">Rejected</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex; gap:5px;">
                        <a href="javascript:void(0);"
                           onclick="showModal({{ json_encode($b->name) }}, {{ json_encode($b->service) }}, {{ json_encode($b->status) }}, {{ json_encode($b->service_date) }})"
                           style="padding:5px 10px;border:none;border-radius:5px;background:#ff4d4d;color:white;cursor:pointer;text-decoration:none;">
                           View
                        </a>
                        <a href="#"
                           style="padding:5px 10px;border:none;border-radius:5px;background:#4caf50;color:white;text-decoration:none;cursor:pointer;">
                           Edit
                        </a>
                        <form action="#" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this booking?')"
                                style="padding:5px 10px;border:none;border-radius:5px;background:#f44336;color:white;cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Service Progress -->
<h2 style="color:#ff4d4d;margin-bottom:15px;margin-top:25px;">Service Progress</h2>
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

<!-- Modal -->
<div id="jobModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);justify-content:center;align-items:center;z-index:9999;">
    <div style="background:#1c1c1c;color:white;padding:25px;border-radius:15px;width:90%;max-width:500px;position:relative;">
        <span style="position:absolute;top:10px;right:15px;font-size:1.5rem;cursor:pointer;" onclick="closeModal()">×</span>
        <div id="modalContent"></div>
    </div>
</div>

@endsection

@section('scripts')
<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#bookingsTable').DataTable({

        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50],
        "ordering": false,
        "searching": true,
        "info": true,
        "autoWidth": false,
        "language": {

            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    });
});

// Modal functions
function showModal(name,service,status,date){
    let html = `
        <h3 style="color:#ff4d4d;margin-bottom:15px;">Booking Details</h3>
        <p><strong>Name:</strong> ${name}</p>
        <p><strong>Service:</strong> ${service}</p>
        <p><strong>Status:</strong> ${status}</p>
        <p><strong>Service Date:</strong> ${date}</p>
    `;
    document.getElementById('modalContent').innerHTML = html;
    document.getElementById('jobModal').style.display = 'flex';
}
function closeModal(){
    document.getElementById('jobModal').style.display = 'none';
}
</script>
@endsection
