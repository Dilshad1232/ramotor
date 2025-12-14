@extends('user.main')
@section('title','Statistics')
@section('content')

<div class="dashboard-wrapper">

    <h2 class="dashboard-title">📊 Booking Dashboard</h2>

    <!-- STAT CARDS TOP ROW -->
    <div class="dashboard-cards">
        <div class="card total">
            <div class="card-icon"><i class="fas fa-list-alt"></i></div>
            <h3>Total Bookings</h3>
            <p>{{ $totalBookings }}</p>
        </div>
        <div class="card pending">
            <div class="card-icon"><i class="fas fa-clock"></i></div>
            <h3>Pending</h3>
            <p>{{ $pending }}</p>
        </div>
        <div class="card approved">
            <div class="card-icon"><i class="fas fa-check-circle"></i></div>
            <h3>Approved</h3>
            <p>{{ $approved }}</p>
        </div>
        <div class="card rejected">
            <div class="card-icon"><i class="fas fa-times-circle"></i></div>
            <h3>Rejected</h3>
            <p>{{ $rejected }}</p>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="dashboard-charts">
        <div class="chart-card">
            <h3>Doughnut Chart</h3>
            <canvas id="statusChart"></canvas>
        </div>
        <div class="chart-card">
            <h3>Monthly Trend</h3>
            <canvas id="monthlyTrendChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
// Doughnut Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Rejected'],
        datasets: [{
            data: [{{ $pending }}, {{ $approved }}, {{ $rejected }}],
            backgroundColor: ['#ffc107','#28a745','#dc3545'],
            borderColor: '#111',
            borderWidth: 3
        }]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        cutout:'70%',
        plugins:{ legend:{ position:'bottom', labels:{color:'#fff'} } }
    }
});

// Line Chart
new Chart(document.getElementById('monthlyTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [
            { label:'Pending', data:{!! json_encode($monthlyPending) !!}, borderColor:'#ffc107', backgroundColor:'rgba(255,193,7,0.2)', tension:0.4, fill:true },
            { label:'Approved', data:{!! json_encode($monthlyApproved) !!}, borderColor:'#28a745', backgroundColor:'rgba(40,167,69,0.2)', tension:0.4, fill:true },
            { label:'Rejected', data:{!! json_encode($monthlyRejected) !!}, borderColor:'#dc3545', backgroundColor:'rgba(220,53,69,0.2)', tension:0.4, fill:true }
        ]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{ legend:{ labels:{ color:'#fff' } } },
        scales:{
            x:{ ticks:{ color:'#fff' }, grid:{ color:'rgba(255,255,255,0.05)' } },
            y:{ ticks:{ color:'#fff' }, grid:{ color:'rgba(255,255,255,0.05)' }, beginAtZero:true }
        }
    }
});
</script>

<style>
/* DASHBOARD WRAPPER */
.dashboard-wrapper {
    padding:10px;
    max-width:1200px;
    margin:0 auto;

}

/* TITLE */
.dashboard-title {
    text-align:center;
    color:#ff4d4d;
    font-size:2rem;
    margin-bottom:30px;
    font-weight:700;

}

/* STAT CARDS */
.dashboard-cards {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:25px;
    margin-bottom:40px;
}
.card {
    background: rgba(255,255,255,0.05);
    /* backdrop-filter:blur(8px); */
    border-radius:20px;
    text-align:center;
    color:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
    transition:0.3s;
    padding:20px 15px;

}
/* .card:hover {
    transform:translateY(-5px) scale(1.03);
    box-shadow:0 15px 35px rgba(0,0,0,0.7);
} */
.card-icon {
    width:60px;
    height:60px;
    border-radius:50%;
    background:rgba(255,255,255,0.12);
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0 auto 15px;
    font-size:28px;
    color:#fff;
    text-shadow:0 0 10px currentColor;
}
.card.total { background:linear-gradient(135deg,#1e3c72,#2a5298); }
.card.pending { background:linear-gradient(135deg,#ffc107,#e0a800); }
.card.approved { background:linear-gradient(135deg,#28a745,#218838); }
.card.rejected { background:linear-gradient(135deg,#dc3545,#a71d2a); }
.card h3 { margin:5px 0; font-size:1.2rem; }
.card p { font-size:2rem; font-weight:700; }

/* CHARTS */
.dashboard-charts {
    display:flex;
    gap:50px;
    flex-wrap:wrap;
}
.chart-card {
    flex:1 1 400px;
    background: rgba(30,30,30,0.8);
    padding:2px;
    /* margin-bottom:30px; */
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
    /* backdrop-filter:blur(8px); */
    height:400px;
}
.chart-card h3 {
    text-align:center;
    color:#ff4d4d;
    margin-bottom:15px;
    font-size:1.2rem;
}

/* RESPONSIVE */
@media(max-width:768px){
    .dashboard-charts { flex-direction:column; }
    .chart-card { width:100%; height:350px; }
    .dashboard-title { font-size:1.5rem; }
    .card p { font-size:1.5rem; }
}
</style>

@endsection
