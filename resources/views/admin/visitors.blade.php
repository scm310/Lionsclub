@extends('MasterAdmin.layout')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto; /* ✅ Fix for scroll/pagination overflow */
}


.card {
    background-color: #ffffff;
    border-radius: 10px;
}

.custom-heading {
    text-align: center;
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

.custom-btn {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: 0.3s;
    width: 100%;
}
.dataTables_length select {
    width: auto !important;
    min-width: 60px;
    padding: 4px 24px 4px 8px; /* leave space for arrow */
    background-position: right 8px center;
    background-size: 10px;
}

.custom-btn:hover {
    color: white;
}

.table th {
    background-color: #003366;
    color: white;
    font-size: 14px;
}

.table td {
    font-size: 13px;
    word-wrap: break-word;
    white-space: normal !important;
    overflow-wrap: break-word;
}

#visitorsTable {
    border-radius: 10px;
    overflow: hidden;
}
#visitorsTable tbody tr:nth-child(odd) {
    background-color: #F0F8FF;
  
}

#visitorsTable tbody tr:nth-child(even) {
    background-color: #B9D9EB;
}
#visitorsTable td:nth-child(7) {
    white-space: normal !important;
    word-break: break-word;
    max-width: 200px;
    overflow-wrap: break-word;
}


td.details-control {
    cursor: pointer;
    text-align: center;
    color: #007bff;
    font-weight: bold;
}

td.details-control::before {
    content: '\002B';
    font-size: 16px;
}

tr.shown td.details-control::before {
    content: '\2212';
}

@media (min-width: 769px) {
    td.details-control::before {
        content: none !important;
    }
}

/* Mobile styles copied from Events blade */
@media (max-width: 768px) {
    .card {
        width: 127% !important;
        margin: 7px -35px !important;
        padding: 20px;
    }

    .custom-heading, h5 {
        font-size: 18px !important;
        text-align: center;
    }

    .form-group label,
    .form-control {
        font-size: 14px;
    }

    .form-control {
        padding: 10px;
    }

    .custom-btn {
        width: 31% !important;
        margin-top: 10px;
        margin-left: 2px;
        font-size: 14px;
        padding: 8px 16px;
    }

    table {
        font-size: 14px;
    }

    

    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before {
        top: 50%;
        transform: translateY(-50%);
    }
}
@media (max-width: 768px) {
    #visitorsTable td:nth-child(7) {
        max-width: 140px;
        font-size: 12px;
    }
}

</style>

<div class="container mt-4">
    <div class="white-container">
        <h3 class="custom-heading">Visitor Statistics</h3>
       
        @if($pageStats->isNotEmpty())
<div class="mb-3 p-3" style="background-color:#87cefa;border-radius:8px;">
    <h5><strong>Total Page Visits</strong></h5>
    <ul>
        @foreach($pageStats as $page => $count)
            <li><strong>{{ $page }}</strong>: {{ $count }}</li>
        @endforeach
    </ul>
</div>

@endif


<div class="p-3 mb-4" style="background-color: #87cefa; border-radius: 8px;">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="from_date" style="color:black">From Date</label>
            <input type="date" class="form-control" name="from_date" id="from_date" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-3">
            <label for="to_date"style="color:black">To Date</label>
            <input type="date" class="form-control" name="to_date" id="to_date" value="{{ request('to_date') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn custom-btn w-50">Filter</button>
        </div>
    </form>
</div>

      <div class="text-end mb-3">
    <a href="{{ route('admin.banner.clicks.export', request()->query()) }}"
       style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5%;  display: inline-block; text-align: center; text-decoration: none; cursor: pointer;">
        <i class="fas fa-download me-1"></i> Export Stats
    </a>
</div>

        <div class="card shadow-lg p-4">
            <div class="table-responsive">
                <table id="visitorsTable" class="table table-bordered dt-responsive" style="width:100%";>

                    <thead>
    <tr>
        <th></th> <!-- For + icon -->
        <th class="all">S.No</th>
        <th class="all">IP Address</th>
        <th class="all">Country</th>
        <th class="none">Region</th>
        <th class="none">City</th>
        <th class="none">Page</th>
        <th class="none">Date & Time</th>
    </tr>
</thead>


                    <tbody>
                        @foreach($visits as $index => $visit)
                        <tr>
                            <td></td>
                           <td>{{ $loop->iteration }}</td>

                            <td>{{ $visit->ip_address }}</td>
                            <td>{{ $visit->country }}</td>
                            <td>{{ $visit->region }}</td>
                            <td>{{ $visit->city }}</td>
                            <td>{{ \App\Helpers\PageMap::getPageName($visit->url) }}</td>

                          <td>{{ \Carbon\Carbon::parse($visit->created_at)->format('d-m-Y H:i:s') }}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
<script>
    let previousExpanded = null;

    function toggleAsk(element, id) {
        if (previousExpanded && previousExpanded !== element) {
            previousExpanded.classList.remove('expanded');
        }

        element.classList.toggle('expanded');
        previousExpanded = element.classList.contains('expanded') ? element : null;
    }
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    // Format dates to YYYY-MM-DD when form is submitted
    $('form').on('submit', function() {
        const fromDate = $('#from_date').val();
        const toDate = $('#to_date').val();
        
        if (fromDate) {
            $('#from_date').val(new Date(fromDate).toISOString().split('T')[0]);
        }
        if (toDate) {
            $('#to_date').val(new Date(toDate).toISOString().split('T')[0]);
        }
    });
function initResponsiveTable() {
    const isMobile = window.innerWidth <= 768;
    $('#visitorsTable').DataTable({
        destroy: true,
        responsive: isMobile ? {
            details: {
                type: 'column',
                target: 0
            }
        } : false,
        columnDefs: isMobile ? [
            { className: 'control', orderable: false, targets: 0 },
            { targets: [0, 1], visible: true },
            { targets: '_all', visible: true }
        ] : [
            { targets: 0, visible: false }
        ],
        autoWidth: true,
        paging: true,
        lengthChange: true,
        searching: false,
        ordering: false,
        info: true,
        pageLength: 10
    });
}

$(document).ready(function () {
    initResponsiveTable();
    $(window).on('resize', function () {
        $('#visitorsTable').DataTable().destroy();
        initResponsiveTable();
    });
});
</script>

@endsection
