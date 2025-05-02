@extends('MasterAdmin.layout')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    /* Custom CSS for the tables and container */
    .container {
        padding: 20px;
    }

    h4 {
        margin-bottom: 20px;
        text-align: center;
    }

    table#districtsTable thead th {
        background-image: none !important;
        cursor: default !important;
    }

    table#districtsTable thead .sorting:after,
    table#districtsTable thead .sorting:before {
        display: none !important;
    }

    table#districtTable thead .sorting:after,
    table#districtTable thead .sorting:before {
        display: none !important;
    }

    table#chaptersTable thead .sorting:after,
    table#chaptersTable thead .sorting:before {
        display: none !important;
    }

    table#membershipTable thead .sorting:after,
    table#membershipTable thead .sorting:before {
        display: none !important;
    }

    table#regionTable thead .sorting:after,
    table#regionTable thead .sorting:before {
        display: none !important;
    }



    .nav-tabs .nav-item {
        margin-right: 1px;
        /* Adds space between tabs */
    }

    .nav-tabs .nav-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        border: none;
        padding: 10px 15px;
        /* Increases padding for better spacing */
        border-radius: 5px;
        /* Rounds corners slightly */
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: #ffff;
        font-weight: bold;
        border-bottom: 3px solid yellow;
    }

    #districtsTable {
        width: 70%;
        /* Adjust as per your requirement */
        margin: auto;
        /* Center the table */
        overflow: hidden;
        /* Ensures corners are properly rounded */
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f8f9fa;

    }

    .districtsTable th,
    .districtsTable td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .districtsTable thead th {
        background-color: #f8f9fa;

    }

    .table-responsive {
        background-color: #f8f9fa;
        /* Light background */
        color: black;
        padding: 20px;
        /* Adds space inside the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
        overflow: hidden;
        /* Ensures rounded corners work */
        width: 90%;
        border-radius: 10px;

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
        appearance: none;
        /* Removes default arrow */
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray"><path d="M5 7l5 5 5-5H5z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 5px center;
        background-size: 20px;
    }

    .table th {
        text-transform: capitalize;
    }

    th,
    td {
        text-transform: capitalize !important;
        /* Ensures each word is capitalized */
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
    }

    .table th {
        color: white !important;
        background-color: #003366 !important;
        font-size: 15px !important;
    }

    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        /* Ensures text is readable */
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        /* Optional rounded edges */
        display: inline-block;
        /* Adjusts width to fit content */
        width: 100%;

        /* Ensures it spans across the container */
    }


    @media only screen and (max-width: 768px) {
        .white-container {
            width: 100% !important;
            padding: 15px;
            border-radius: 0;
        }

        .table-responsive {
            width: 300px !important;
            padding: 10px;
            border-radius: 0;
            margin-left: auto;
            margin-right: auto;
        }

        #districtsTable,
        #districtTable,
        #chaptersTable,
        #membershipTable,
        #regionTable {
            width: 100% !important;
        }
    }

    .table-responsive {

        margin-left: -15px;
        margin-right: auto;
    }

    @media (max-width: 768px) {
        .alert-container .alert {
            width: 100% !important;
            margin: 0 auto;
        }
    }

    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 8px 17px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
    }

    /* Alternate row background colors */
    #districtsTable tbody tr:nth-child(odd),
    #districtTable tbody tr:nth-child(odd),
    #chaptersTable tbody tr:nth-child(odd),
    #membershipTable tbody tr:nth-child(odd),
    #regionTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
        /* Alice Blue */
    }

    #districtsTable tbody tr:nth-child(even),
    #districtTable tbody tr:nth-child(even),
    #chaptersTable tbody tr:nth-child(even),
    #membershipTable tbody tr:nth-child(even),
    #regionTable tbody tr:nth-child(even) {
        background-color: #B9D9EB;
        /* Soft pastel blue */
    }

    /* Table cell styling */
    #districtsTable td,
    #districtTable td,
    #chaptersTable td,
    #membershipTable td,
    #regionTable td {
        padding: 10px;
        border-color: #ddd;
    }

    /* Active pagination button style */
    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }

    .modal-footer>*:first-child {
        margin-right: 7px;
    }

    .modal-body {
        background-color: #87cefa;
    }

    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5) !important;
    }


    #cancel:hover {
        background: gray !important;
    }
</style>



<div class="container mt-4">
    <div class="white-container">

        <h3 class="mb-3 custom-heading">Setting Tables</h3>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.settings.add') }}" class="btn btn-secondary btn-sm custom-btn">
                <i class="bi bi-gear-fill"></i> Add Settings
            </a>
        </div>

        <div class="alert-container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 40%; margin: 0 auto;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 50%; margin: 0 auto;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div><br>



        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="districts-tab" data-bs-toggle="tab" href="#districts">Parents Multiple Districts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="district-tab" data-bs-toggle="tab" href="#district">Districts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chapters-tab" data-bs-toggle="tab" href="#chapters">Club</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="membership-tab" data-bs-toggle="tab" href="#membership">Membership Types</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Regions-tab" data-bs-toggle="tab" href="#Regions">Regions</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4">
            <!-- Parents Multiple Districts Tab -->
            <div class="tab-pane fade show active" id="districts">
                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; max-width: 1000px; width: 100%;">
                        <h5 class="mb-3 custom-heading">Parents Multiple Districts</h5>
                        <table class="table table-striped table-bordered dt-responsive nowrap" id="districtsTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parentsMultipleDistricts as $district)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $district->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-primary edit-btn"
                                            data-id="{{ $district->id }}"
                                            data-name="{{ $district->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('districts.delete', $district->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title custom-heading" id="editModalLabel">Edit District</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="district_id" name="id">
                                <div class="mb-3">
                                    <label for="district_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="district_name" name="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn custom-btn">Update</button>
                                <button type="button" class="btn custom-btn " data-bs-dismiss="modal" id="cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Script to Handle Edit Modal -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const editButtons = document.querySelectorAll('.edit-btn');
                    const editForm = document.getElementById('editForm');

                    editButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            const id = button.getAttribute('data-id');
                            const name = button.getAttribute('data-name');

                            document.getElementById('district_id').value = id;
                            document.getElementById('district_name').value = name;
                            editForm.action = `/settings/districts/${id}`; // Update to match route
                        });
                    });
                });
            </script>


            <!-- Districts Tab -->
            <div class="tab-pane fade" id="district">
                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; max-width: 1000px; width: 100%;">
                        <h5 class="mb-3 custom-heading">Districts</h5>
                        <table class="table table-striped table-bordered dt-responsive nowrap text-center" id="districtTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($districts as $district)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $district->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-primary edit-btn"
                                            data-id="{{ $district->id }}"
                                            data-name="{{ $district->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editDistrictModal"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('districts.destroyDistrict', $district->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit District Modal -->
            <div class="modal fade" id="editDistrictModal" tabindex="-1" aria-labelledby="editDistrictModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" id="editDistrictForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title custom-heading">Edit District</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="districtName" class="form-label">District Name</label>
                                    <input type="text" class="form-control" id="districtName" name="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn custom-btn">Update</button>
                                <button type="button" class="btn custom-btn " data-bs-dismiss="modal" id="cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JS for handling edit -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editButtons = document.querySelectorAll('.edit-btn');
                    const form = document.getElementById('editDistrictForm');
                    const nameInput = document.getElementById('districtName');

                    editButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            const id = button.getAttribute('data-id');
                            const name = button.getAttribute('data-name');

                            nameInput.value = name;
                            form.action = `/districts/update/${id}`;
                        });
                    });
                });
            </script>




            <!-- Chapters Tab -->
            <div class="tab-pane fade" id="chapters">
                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; max-width: 1000px; width: 100%;">
                        <h5 class="mb-3 custom-heading">Club</h5>
                        <table class="table table-striped table-bordered dt-responsive nowrap text-center" id="chaptersTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center">Club Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chapters as $chapter)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="text-transform: capitalize;">
                                        {{ ucwords(strtolower($chapter->chapter_name)) }}
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button
                                            class="btn btn-primary edit-btn"
                                            data-id="{{ $chapter->id }}"
                                            data-name="{{ $chapter->chapter_name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editChapterModal"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.settings.deleteChapter', $chapter->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Chapter Modal -->
            <div class="modal fade" id="editChapterModal" tabindex="-1" aria-labelledby="editChapterModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" id="editChapterForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title custom-heading" id="editChapterModalLabel">Edit Club Name</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="chapterName" class="form-label">Club Name</label>
                                    <input type="text" class="form-control" id="chapterName" name="chapter_name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn custom-btn">Update</button>
                                <button type="button" class="btn custom-btn " data-bs-dismiss="modal" id="cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JavaScript to handle edit button click -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editButtons = document.querySelectorAll('.edit-btn');
                    const form = document.getElementById('editChapterForm');
                    const nameInput = document.getElementById('chapterName');

                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const name = this.getAttribute('data-name');

                            nameInput.value = name;
                            form.action = `/admin/settings/chapter/update/${id}`;
                        });
                    });
                });
            </script>




            <!-- Membership Types Tab -->
            <div class="tab-pane fade" id="membership">
                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; max-width: 1000px; width: 100%;">
                        <h5 class="mb-3 custom-heading">Membership Types</h5>
                        <table class="table table-striped table-bordered dt-responsive nowrap text-center" id="membershipTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($membershipTypes as $membership)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $membership->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button
                                            class="btn btn-primary edit-btn"
                                            data-id="{{ $membership->id }}"
                                            data-name="{{ $membership->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editMembershipModal"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.settings.deleteMembership', $membership->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editMembershipModal" tabindex="-1" aria-labelledby="editMembershipModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" id="editMembershipForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title custom-heading" id="editMembershipModalLabel">Edit Membership Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="membershipName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="membershipName" name="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn custom-btn">Update</button>
                                <button type="button" class="btn custom-btn " data-bs-dismiss="modal" id="cancel">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JavaScript to handle edit -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editButtons = document.querySelectorAll('.edit-btn');
                    const form = document.getElementById('editMembershipForm');
                    const nameInput = document.getElementById('membershipName');

                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const name = this.getAttribute('data-name');

                            nameInput.value = name;
                            form.action = `/admin/settings/membership/update/${id}`;
                        });
                    });
                });
            </script>


            <div class="tab-pane fade" id="Regions">
                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="overflow-x: auto; max-width: 1000px; width: 100%;">
                        <h5 class="mb-3 custom-heading">Regions</h5>
                        <table class="table table-striped table-bordered dt-responsive nowrap text-center" id="regionTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center">Region Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($regions as $region)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $region->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button
                                            class="btn btn-primary edit-btn"
                                            data-id="{{ $region->id }}"
                                            data-name="{{ $region->name }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editRegionModal"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('region.destroy', $region->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Region Modal -->
            <div class="modal fade" id="editRegionModal" tabindex="-1" aria-labelledby="editRegionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" id="editRegionForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mb-3 custom-heading" id="editRegionModalLabel">Edit Region</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="region_id" id="editRegionId">
                                <div class="form-group">
                                    <label for="editRegionName">Region Name</label>
                                    <input type="text" class="form-control" id="editRegionName" name="name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn custom-btn">Update Region</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editButtons = document.querySelectorAll('.edit-btn');
                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const regionId = this.getAttribute('data-id');
                            const regionName = this.getAttribute('data-name');

                            document.getElementById('editRegionId').value = regionId;
                            document.getElementById('editRegionName').value = regionName;

                            // Set dynamic form action
                            const form = document.getElementById('editRegionForm');
                            form.action = `/regions/${regionId}`; // Route to update
                        });
                    });
                });
            </script>



        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#districtsTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        $('#districtTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        $('#chaptersTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        $('#membershipTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        $('#regionTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });


        // For Bootstrap 5 tabs
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust().responsive.recalc();
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Trigger SweetAlert on delete button click
        $('.delete-btn').on('click', function(e) {
            e.preventDefault(); // Prevent form submission

            var form = $(this).closest('form'); // Get the closest form
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize all tables only if not already initialized
        const tables = ['#districtsTable', '#districtTable', '#chaptersTable', '#membershipTable', '#regionTable'];

        tables.forEach(function(selector) {
            if (!$.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable({
                    responsive: true,
                    paging: true,
                    searching: true
                });
            }
        });
    });
</script>

<!-- SweetAlert delete confirmation -->
<script>
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        const form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            didOpen: () => {
                const confirmBtn = Swal.getConfirmButton();
                const cancelBtn = Swal.getCancelButton();

                // Confirm button gradient style
                confirmBtn.style.background = 'linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%)';
                confirmBtn.style.border = 'none';
                confirmBtn.style.color = 'white';

                // Cancel button gradient style
                cancelBtn.style.background = 'linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%)';
                cancelBtn.style.border = 'none';
                cancelBtn.style.color = 'white';

                // Add hover effect for cancel button
                cancelBtn.addEventListener('mouseenter', () => {
                    cancelBtn.style.background = 'gray';
                });
                cancelBtn.addEventListener('mouseleave', () => {
                    cancelBtn.style.background = 'linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%)';
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>




@endsection