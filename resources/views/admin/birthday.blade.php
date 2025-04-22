@extends('MasterAdmin.layout')
@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<style>

    .birthday-table {
        width: 90%; /* Adjust as per your requirement */
        margin: auto; /* Center the table */
        overflow: hidden; /* Ensures corners are properly rounded */
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f8f9fa;

    }

    .birthday-table th, .birthday-table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .birthday-table thead th {
        background-color: #f8f9fa;

    }
    .birthday-table th:first-child,
    .birthday-table td:first-child {
        width: 120px; /* Adjust as needed */
    }

    .birthday-table th:last-child,
    .birthday-table td:last-child {
        width: 60px; /* Adjust as needed */
    }

    .custom-tabs {
    border-bottom: none; /* Removes default Bootstrap tab border */
}

.nav-tabs .nav-link {
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    color: white;
    border: none;
    border-radius: 5px;
    margin: 0 5px; /* Adds spacing between tabs */
    padding: 10px 20px;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    color: white;
    font-weight: bold;
    border-bottom: 3px solid yellow;
}

/* Centers tabs */
.d-flex.justify-content-center .nav-tabs {
    display: flex;
    justify-content: center;
    border-bottom: none;
}



/* Table Styles */
table#complaintTable thead th {
    background-image: none !important;
    cursor: default !important;
}

table#complaintTable thead .sorting:after,
table#complaintTable thead .sorting:before {
    display: none !important;
}
table#Table thead .sorting:after,
table#Table thead .sorting:before {
    display: none !important;
}
/* Styles for DataTable container */
.table-responsive {
background-color: #f8f9fa; /* Light background */
color:black;
padding: 20px; /* Adds space inside the container */
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
overflow: hidden; /* Ensures rounded corners work */
width:100%;
border-radius: 10px;

margin-top:-36px;

}
.table-responsive th,td{
    text-align:center !important;
}

/* Styles for the DataTable */
#complaintTable {
overflow: hidden; /* Ensures proper edge handling */
}

/* Ensuring the table header has a proper background */
#complaintTable thead th,#Table thead th
{
background-color: #ffffff; /* Dark background for better contrast */
color: rgb(0, 0, 0); /* White text */
}

/* Table row hover effect */
#complaintTable tbody tr:hover {
background-color: #e9ecef; /* Light grey hover effect */
}

/* Ensure pagination controls have rounded edges */
.dataTables_wrapper .dataTables_paginate .paginate_button {
background: #ffffff;
border-radius: 5px;
margin: 2px;
padding: 5px 10px;
border: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
background: #ffffff;
}

/* Make the search input field rounded */
.dataTables_wrapper .dataTables_filter input {
border-radius: 5px;
border: 1px solid #ced4da;
padding: 5px;
}



div.dataTables_wrapper div.dataTables_length select {
width: 50px;
font-size: 12px;
padding: 2px 10px;
appearance: none; /* Removes default arrow */
-webkit-appearance: none;
-moz-appearance: none;
background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray"><path d="M5 7l5 5 5-5H5z"/></svg>');
background-repeat: no-repeat;
background-position: right 5px center;
background-size: 20px;
}
.page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}
/* Ensure Mobile Responsiveness */

    /* Mobile Responsiveness */
    @media screen and (max-width: 768px) {

        h3 {
            font-size: 18px;
            margin-left: 0;
        }

        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
        }

        .nav-tabs .nav-link {
            padding: 8px;
            font-size: 14px;
        }
    }

.table th{
    text-transform: capitalize;
}

.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}

.table th{
    color: white !important;
    font-size: 15px;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white; /* Ensures text is readable */
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px; /* Optional rounded edges */
    display: inline-block; /* Adjusts width to fit content */
    width: 100%; /* Ensures it spans across the container */
}
#birthdaysTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF; 
}

#birthdaysTable tbody tr:nth-child(even) {
    background-color: #B9D9EB; 
}

#anniversariesTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF; 
}

#anniversariesTable tbody tr:nth-child(even) {
    background-color: #B9D9EB; 
}
</style>
    <div class="container mt-4 ">
        <div class="white-container">

            <h3 class="mb-3 custom-heading">Birthdays and Anniversaries</h3>



     <!-- Nav Tabs -->
     <div class="d-flex mt-3">
        <ul class="nav nav-tabs custom-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="birthdays-tab" data-bs-toggle="tab" href="#birthdays">Birthdays</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="anniversaries-tab" data-bs-toggle="tab" href="#anniversaries">Anniversaries</a>
            </li>
        </ul>
    </div>


<!-- Tab Content -->
<div class="tab-content mt-3">
<!-- Birthdays Tab -->
<div class="tab-pane fade show active" id="birthdays">

    <div class="table-responsive" style="background-color:white;">
        <h4 style="text-align:center;">Members Birthday</h4>
        <table class="table table-striped table-bordered dt-responsive nowrap" id="birthdaysTable" style="width: 100%; overflow-x: auto;">
            <thead style="background-color:#003366;">
                <tr>
                    <th>S.No</th>
                    <th>Member Name</th>
                    <th>Birthday Date</th>
                </tr>
            </thead>
            <tbody>
                @if(count($birthdays) > 0)
                    @foreach($birthdays as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::title($member->first_name) }} {{ Str::title($member->last_name) }}</td>
                            <td>{{ \Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>




</div>


<!-- Anniversaries Tab -->
<div class="tab-pane fade" id="anniversaries">
    <div class="table-responsive" style="background-color:white;">
        <h4 style="text-align:center;">Members Anniversary</h4>
        <table id="anniversariesTable" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%; overflow-x: auto;">
            <thead style="background-color:#003366;">
                <tr>
                    <th>S.No</th>
                    <th>Member Name</th>
                    <th>Anniversary Date</th>
                </tr>
            </thead>
            <tbody>
                @if(count($anniversaries) > 0)
                    @foreach($anniversaries as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::title($member->first_name) }} {{ Str::title($member->last_name) }}</td>
                            <td>{{ \Carbon\Carbon::parse($member->anniversary_date)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

</div>
</div>
</div>


<script>
$(document).ready(function () {
    $('#birthdaysTable').DataTable({
        "pageLength": 10,                // Set initial page length
        "ordering": false,              // Disable sorting
        "searching": true,              // Enable search
        "lengthChange": true,           // Show "Show X entries" dropdown
        "info": true,                   // Show "Showing X of X entries"
        "lengthMenu": [10, 25, 50, 100]  // Dropdown options
    });

    $('#anniversariesTable').DataTable({
        "pageLength": 10,
        "ordering": false,
        "searching": true,
        "lengthChange": true,
        "info": true,
        "lengthMenu": [10, 25, 50, 100]
    });
});
</script>


@endsection

