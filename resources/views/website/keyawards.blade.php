@extends('layouts.navbar')

@section('content')

<style>
    /* Page Layout */
    .award-container {
        display: flex;
        padding: 20px;
        gap: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px;
    }

    /* Left Side: Award Image */
    .award-image {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .award-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* Right Side: Awarded Members List */
    .award-list {
        flex: 1;
        padding: 20px;
        border-left: 2px solid #ddd;
    }

    .award-list h2 {
        text-align: center;
        margin-bottom: 15px;
        color: #333;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;

    }
    td{
        background-color: #C4A484;
        background-image: linear-gradient(315deg, #C4A484 0%, #fbc6b6 74%);
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e0e0e0;
        transition: 0.3s;
    }

    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .pagination .active span {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: white;
    }


    /* Left Side: Award Image */
.award-image {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.award-image img {
    max-width: 100%;
    height: 600px; /* Reduced height */
    width: auto;
    border-radius: 10px;
    object-fit: contain; /* Ensures the image scales properly */
}

 /* Responsive Design */
 @media (max-width: 768px) {
        .award-container {
            flex-direction: column;
            padding: 10px;
        }

        .award-image {
            order: -1; /* Moves the image above the list */
            text-align: center;
        }

        .award-image img {
            max-width: 80%;
            height: auto;
        }

        .award-list {
            border-left: none;
            border-top: 2px solid #ddd;
            padding: 10px;
        }

        th, td {
            padding: 10px;
            font-size: 14px;
        }

        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
/* Remove extra space in mobile view */
@media (max-width: 768px) {
    body, html {
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Prevents horizontal scrolling */
    }

    .content {
        padding: 0;
        margin: 0;
        width: 100%; /* Ensures it takes full width */
    }


    footer {
        padding: 3px 0; /* Adjust padding to remove extra space */
        margin-bottom: -13px;
        width: 100%;
        position: fixed; /* Keeps footer at the bottom */
        bottom: 0;
        left: 0;
    }
}

.active>.page-link, .page-link.active {
    z-index: 3;
    color: var(--bs-pagination-active-color);
    background: linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(97, 149, 219) 158.5%);
    border-color: var(--bs-pagination-active-border-color);
}
</style>

<div class="award-container">
    <!-- Left Side: Award Image -->
    <div class="award-image">
        <img src="{{ asset('assets\images\Membership.jpeg') }}" alt="Awards">
    </div>

    <!-- Right Side: Awarded Members List -->
<!-- Include Bootstrap 5 and DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<div class="award-list container mt-4">
    <h2 class="text-center">Membership Key Awards</h2>

    <table id="awardTable" class="table table-striped table-bordered">
        <thead class="text-white" style="background-color:#003366">
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Award</th>
                <th>Clubs</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->award->name ?? 'N/A' }}</td>
                <td>{{ $member->chapter->chapter_name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination-container">
        {{ $members->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Include jQuery and DataTables.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#awardTable').DataTable({
            "paging": true, 
            "searching": true, 
            "ordering": false,  // 🚫 Disable sorting
            "info": true, 
            "lengthMenu": [5, 10, 25, 50], 
            "pageLength": 5 
        });
    });
</script>

</div>

@endsection