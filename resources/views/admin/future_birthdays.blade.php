@extends('MasterAdmin.layout')
@section('content')


<style>

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
.btn-birthday {
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    color: #ffffff;
    padding: 8px 16px;
    font-size: 15px;
    border: none;
    border-radius: 6px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
    display: inline-block;
    margin-top:-7px;
}

.btn-birthday:hover {
    transform: scale(1.03);
    color: #ffffff;
    text-decoration: none;
}

</style>
<div class="container mt-4 ">
    <div class="white-container">

        <h3 class="mb-3 custom-heading">Coming week birthdays</h3>

        <div class="mb-4 d-flex justify-content-end">
            <a href="{{ route('admin.birthday') }}" class="btn-birthday">
                Celebrations This Month
            </a>
        </div>


    @if($members->count())
    <div class="table-responsive" style="background-color:white;">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="birthdaysTable" style="width: 100%; overflow-x: auto;">
            <thead style="background-color:#003366;">
                <tr>
                        <th>S.No</th>
                        <th>Member Name</th>
                        <th>Club Name</th>
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::title($member->first_name) }} {{ Str::title($member->last_name) }}</td>
                            <td>{{ $member->chapter_name ?? 'N/A' }}</td>


                            <td>{{ \Carbon\Carbon::parse($member->dob)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No birthdays in the upcoming week.</p>
    @endif
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
