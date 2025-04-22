@extends('MasterAdmin.layout')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
     background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        display: inline-block;
        width: 100%;
    }

    .custom-btn {
        background: rgb(30,144,255);
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
        width:140px;
    }
  


    .custom-table-header th {
    background-color: #003366;
    color: white;
    text-align: center;
}


 /* Try hiding the CanvasJS watermark */
 a[href*="canvasjs.com"], .canvasjs-chart-credit {
        display: none !important;
        opacity: 0 !important;
        pointer-events: none !important;
        visibility: hidden !important;
        height: 0 !important;
    }



    /* Push search and length dropdowns down a little */
.dataTables_length, .dataTables_filter {
    margin-top: 0.5rem; /* Adjust as needed */
}

/* Alternating row colors */
#bannerTable tbody tr:nth-child(odd),
#bannerTable tbody tr:nth-child(odd),
#bannerTable tbody tr:nth-child(odd) {
    background-color: #F0F8FF; /* Alice Blue */
}

#bannerTable tbody tr:nth-child(even),
#bannerTable tbody tr:nth-child(even),
#bannerTable tbody tr:nth-child(even) {
    background-color: #B9D9EB; /* Soft pastel blue */
}

/* Padding and border for table cells */
#bannerTable td, #table-image2 td, #table-image3 td {
    padding: 10px;
    border-color: #ddd;
}


</style>

<div class="container mt-4">

    <div class="card shadow rounded p-3">
    <h2 class="mb-4 custom-heading">Banner Click Statistics</h2>

 <!-- Main Chart -->
<div class="mb-5">
<canvas id="bannerClickChart" style="height: 400px; width: 100%;"></canvas>

</div>

<!-- Chart Container Row -->
<div class="d-flex gap-3 mb-4 flex-wrap">
    <!-- Line Chart Daily Trends -->
    <div class="card p-2 flex-fill" style="min-width: 300px; height: 220px;">
        <h6 class="text-center mb-2">Daily Click Trends</h6>
        <div id="dailyClickChart" style="height: 140px; width: 100%;"></div>
    </div>

    <!-- Area Chart New Users -->
    <div class="card p-2 flex-fill" style="min-width: 300px; height: 220px;">
        <h6 class="text-center mb-2">New Users (Unique Redirect URLs per Day)</h6>
        <div id="newUserChart" style="height: 140px; width: 100%;"></div>
    </div>
</div>

<!-- Chart Container Row -->
<div class="d-flex gap-3 mb-4 flex-wrap">
    <!-- Monthly New Users Chart -->
    <div class="card p-2 flex-fill" style="min-width: 300px;">
        <h6 class="text-center mb-2">New Users Per Month</h6>
        <div id="monthlyUserChart" style="height: 140px; width: 100%;"></div>
    </div>

    <!-- Monthly Banner Clicks Chart -->
    <div class="card p-2 flex-fill" style="min-width: 300px;">
        <h6 class="text-center mb-2">Banner Clicks Per Month</h6>
        <div id="monthlyClicksChart" style="height: 140px; width: 100%;"></div>
    </div>
</div>



<!-- Filter Form Card -->
<div class="card mb-4" style="background-color: #87cefa;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.banner.clicks') }}" class="row g-3" id="filterForm">
            <div class="col-md-3">
                <label>Banner Type</label>
                <select name="type" class="form-select filter-control">
                    <option value="">All</option>
                    <option value="top" {{ request('type') == 'top' ? 'selected' : '' }}>Top</option>
                    <option value="bottom" {{ request('type') == 'bottom' ? 'selected' : '' }}>Bottom</option>
                    <option value="left" {{ request('type') == 'left' ? 'selected' : '' }}>Left</option>
                    <option value="right" {{ request('type') == 'right' ? 'selected' : '' }}>Right</option>
                    <option value="popup" {{ request('type') == 'popup' ? 'selected' : '' }}>Popup</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control filter-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control filter-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3 align-self-end d-flex justify-content-end">
            <button type="submit"
    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5%; width: 112px; text-align: center; cursor: pointer;">
    Filter
</button>

</div>

        </form>
    </div>
</div>



       

<!-- Export CSV -->
<div class="text-end mb-3">
    <a href="{{ route('admin.banner.clicks.export', request()->query()) }}"
       style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5%;  display: inline-block; text-align: center; text-decoration: none; cursor: pointer;">
        <i class="fas fa-download me-1"></i> Export CSV
    </a>
</div>




           <!-- Table -->
           <div class="card">
    <div class="card-header text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; font-size:18px; ">
       Banner Clicks List <!-- Optional: You can give it a title -->
    </div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table id="bannerTable" class="table table-bordered table-striped align-middle text-center">
                <thead class="custom-table-header">
                    <tr>
                        <th style="width: 60px;">S.No</th> <!-- Narrow S.No column -->
                        <th>Banner Type</th>
                        <th>Image</th>
                        <th>Redirect URL</th>
                        <th>Click Count</th>
                        <th>Last Clicked</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($clicks as $click)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- This gives you 1, 2, 3... -->
                    <td>{{ ucfirst($click->banner_type) }}</td>

                    <td>
                        <img src="{{ asset('storage/app/public/' . $click->image_path) }}" class="img-thumbnail" style="width: 100px; height: 100px;"  loading="lazy">
                    </td>
                    <td style="max-width: 200px; word-break: break-all;">
                        <a href="{{ $click->redirect_url }}" target="_blank">{{ $click->redirect_url }}</a>
                    </td>

                    <td>{{ $click->click_count }}</td>
                    <td>{{ $click->updated_at->diffForHumans() }}</td>
                    <td>{{ $click->updated_at->format('d-m-Y h:i A') }}</td>

                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    </div>
</div>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


    window.onload = function () {

const ctx = document.getElementById('bannerClickChart').getContext('2d');

// Create individual vertical gradients
const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
gradient1.addColorStop(0, 'rgb(214, 224, 255)');
gradient1.addColorStop(1, 'rgb(254, 168, 168)');

const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
gradient2.addColorStop(0, 'rgb(177, 173, 219)');
gradient2.addColorStop(1, 'rgb(245, 226, 226)');

const gradient3 = ctx.createLinearGradient(0, 0, 0, 400);
gradient3.addColorStop(0, '#fff1eb');
gradient3.addColorStop(1, '#ace0f9');

const gradient4 = ctx.createLinearGradient(0, 0, 0, 400);
gradient4.addColorStop(0, '#a18cd1');
gradient4.addColorStop(1, '#fbc2eb');

const gradient5 = ctx.createLinearGradient(0, 0, 0, 400);
gradient5.addColorStop(0, '#ff0844');
gradient5.addColorStop(1, '#ffb199');

// Initialize Chart.js Bar Chart
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Top', 'Bottom', 'Left', 'Right', 'Popup'],
        datasets: [{
            label: 'Total Clicks',
            data: [
                {{ $topClicks }},
                {{ $bottomClicks }},
                {{ $leftClicks }},
                {{ $rightClicks }},
                {{ $popupClicks }}
            ],
            backgroundColor: [
                gradient1,
                gradient2,
                gradient3,
                gradient4,
                gradient5
            ],
            borderRadius: 10,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Clicks'
                }
            }
        }
    }
});

    // CanvasJS Daily Click Trend
    var dailyClickChart = new CanvasJS.Chart("dailyClickChart", {
        animationEnabled: true,
        theme: "light2",
        axisX: { title: "Date" },
        axisY: { title: "Total Clicks", includeZero: true },
        data: [{
            type: "line",
            color: "#28a745",
            dataPoints: [
                @foreach($clicksPerDay as $point)
                    { label: "{{ \Carbon\Carbon::parse($point->date)->format('d M') }}", y: {{ $point->total }} },
                @endforeach
            ]
        }]
    });
    dailyClickChart.render();

    // CanvasJS New Users Area Chart
    var newUserChart = new CanvasJS.Chart("newUserChart", {
        animationEnabled: true,
        theme: "light1",
        axisX: { title: "Date" },
        axisY: { title: "New Users", includeZero: true },
        data: [{
            type: "area",
            color: "#007bff",
            dataPoints: [
                @foreach($newUsers as $point)
                    { label: "{{ \Carbon\Carbon::parse($point->date)->format('d M') }}", y: {{ $point->new_user_count }} },
                @endforeach
            ]
        }]
    });
    newUserChart.render();

    // CanvasJS Monthly New Users
    var monthlyUserChart = new CanvasJS.Chart("monthlyUserChart", {
        animationEnabled: true,
        theme: "light1",
        axisX: { title: "Month" },
        axisY: { title: "New Users", includeZero: true },
        data: [{
            type: "area",
            color: "#6f42c1",
            dataPoints: [
                @foreach($newUsersPerMonth as $point)
                    { label: "{{ \Carbon\Carbon::parse($point->month . '-01')->format('M Y') }}", y: {{ $point->new_user_count }} },
                @endforeach
            ]
        }]
    });
    monthlyUserChart.render();

    // CanvasJS Monthly Banner Clicks
    var monthlyClicksChart = new CanvasJS.Chart("monthlyClicksChart", {
        animationEnabled: true,
        theme: "light2",
        axisX: { title: "Month" },
        axisY: { title: "Total Clicks", includeZero: true },
        data: [{
            type: "column",
            color: "#17a2b8",
            dataPoints: [
                @foreach($clicksPerMonth as $point)
                    { label: "{{ \Carbon\Carbon::parse($point->month . '-01')->format('M Y') }}", y: {{ $point->total_clicks }} },
                @endforeach
            ]
        }]
    });
    monthlyClicksChart.render();
};
</script>



<script>
    // Automatically submit the form when a filter changes
    document.querySelectorAll('.filter-control').forEach(input => {
        input.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#bannerTable').DataTable({
            responsive: true,
            ordering:false,
            pageLength: 10,
            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 5], className: 'text-center' }
            ]
        });
    });
</script>

@endsection
