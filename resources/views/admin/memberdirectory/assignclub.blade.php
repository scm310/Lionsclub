@extends('MasterAdmin.layout')

@section('content')
<!-- DataTables CSS -->
<style>
    /* Fix text color issue in Select2 dropdown */
    .select2-container--default .select2-selection--single {
        color: black !important;
        background-color: white !important;
    }

    .select2-dropdown {
        color: black !important;
        background-color: white !important;
    }

    .select2-results__option {
        color: black !important;
    }

    .select2-container .select2-selection__placeholder {
        color: #6c757d !important;
    }

    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5) !important;
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5% !important;
        transition: 0.3s;
    }

    .custom-btn:hover {
        color: white;
    }


    .select2-container .select2-selection--single {
        box-sizing: border-box !important;
        cursor: pointer !important;
        display: block !important;
        height: 38px !important;
        user-select: none;
        -webkit-user-select: none;
    }

    .select2-selection__placeholder {
        transform: translateY(7px) !important;
    }

    .white-container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        min-height: 100px;
        /* Optional: just a starting base height */
        height: auto !important;
        /* This ensures it grows */
        overflow: visible;
    }


    .table th {
        color: white !important;
        background-color: #003366;
        font-size: 15px;
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

    @media (max-width: 767.98px) {
        .white-container {
            height: 800px;
        }
    }

    .card {
        background-color: #87cefa;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
    }

    .card {
        border-radius: 10px;
        background-color: #87cefa;
    }

    .card-body {
        padding: 15px;
    }

    table.table {
        border-radius: 10px;
        overflow: hidden;
        /* ensures rounding is visible */
    }

    #membersTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
    }

    #membersTable tbody tr:nth-child(even) {
        background-color: #B9D9EB;
    }

    @media (max-width: 767px) {
        #chapterDropdown {
            width: 100% !important;
        }
    }

    @media (max-width: 767px) {
        #searchInput {
            width: 100% !important;
        }
    }

    /* Styles for DataTable container */
    .table-responsive {
        background-color: #f8f9fa;
        color: black;
        padding: 22px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        border-radius: 10px;
        margin-top: -28px;

    }

    .table-responsive th,
    td {
        text-align: center !important;
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

    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }

    #birthdaysTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
    }

    #birthdaysTable tbody tr:nth-child(even) {
        background-color: #B9D9EB;
    }

    @media screen and (max-width: 768px) {
        .custom-btn {
            width: 100% !important;
        }
    }
</style>

<div class="container mt-4">
    <div class="white-container position-relative">
        <!-- Header -->
        <h3 class="mb-3 custom-heading">Assign Member Position</h3>


        <!-- Member Selection & Role -->
        <div class="card shadow-sm p-4 mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-center mb-4">Assign Club Position</h5>
                    <form action="{{ route('assign.club') }}" method="GET" id="chapterForm">
                        <div class="mb-4">
                            <label for="chapterDropdown" class="form-label fw-bold">Select Club</label>

                            <select name="chapter_id" class="form-select select2" id="chapterDropdown" style="width:100%;" onchange="document.getElementById('chapterForm').submit();">
                                <option value="">-- Select Club --</option>
                                @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                    {{ $chapter->chapter_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>


            </div>


            @if(count($members))
            <form action="{{ route('assign.clubposition') }}" method="POST">
                @csrf
                <div class="row mt-4">

                    <div class="col-md-8">

                        <!-- Select All Checkbox (Right-aligned) -->
                        <div class="d-flex justify-content-end mb-1" id="selectAllContainer" style="display: none; margin-right: 40px;">
                            <div>
                                <input type="checkbox" id="selectAllCheckbox">
                                <label for="selectAllCheckbox">Select All</label>
                            </div>
                        </div>


                        <!-- Members Table -->
                        <div class="table-responsive" style="background-color:white;">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="birthdaysTable" style="width: 100%; overflow-x: auto;">
                                <thead style="background-color:#003366;">

                                    <tr>
                                        <th>S.No</th>
                                        <th>Member ID</th>
                                        <th>Full Name</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $member)
                                    <tr>
                                        <td>{{$loop-> iteration}}</td>
                                        <td>{{ $member->member_id }}</td>
                                        <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                                        <td>
                                            <input type="checkbox" name="member_ids[]" value="{{ $member->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="">
                            <h5 class="text-center mb-4">Assign Role</h5>
                            <div class="mb-3">
                                <label for="position" class="form-label fw-bold">Select Position</label>
                                <select name="position" id="position" class="form-select">
                                    <option value="">Select Position</option>
                                    <option value="President">President</option>
                                    <option value="Secretary">Secretary</option>
                                    <option value="Treasurer">Treasurer</option>
                                    <option value="Member">Member</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn custom-btn w-80">Assign Member</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- JavaScript Section -->
            <script>
    document.addEventListener('DOMContentLoaded', function () {
        const positionSelect = document.getElementById('position');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const selectAllContainer = document.getElementById('selectAllContainer');

        function getCheckboxes() {
            return document.querySelectorAll('input[name="member_ids[]"]');
        }

        function resetCheckboxListeners(checkboxes) {
            checkboxes.forEach(cb => {
                const newCb = cb.cloneNode(true);
                cb.parentNode.replaceChild(newCb, cb);
            });
        }

        function enableSingleSelection(checkboxes) {
            resetCheckboxListeners(checkboxes);
            checkboxes.forEach(cb => {
                cb.addEventListener('click', function () {
                    if (this.checked) {
                        checkboxes.forEach(other => {
                            if (other !== this) other.checked = false;
                        });
                    }
                });
            });
        }

        function enableMultiSelection(checkboxes) {
            resetCheckboxListeners(checkboxes);
            // No special logic needed
        }

        positionSelect.addEventListener('change', function () {
            const role = this.value;
            const checkboxes = getCheckboxes();

            if (role === 'President' || role === 'Secretary' || role === 'Treasurer') {
                selectAllContainer.style.display = 'none';
                selectAllCheckbox.checked = false;

                // Ensure only one checkbox is selected
                let firstCheckedFound = false;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        if (!firstCheckedFound) {
                            firstCheckedFound = true;
                        } else {
                            cb.checked = false;
                        }
                    }
                });

                enableSingleSelection(checkboxes);

            } else if (role === 'Member') {
                selectAllContainer.style.display = 'block';
                enableMultiSelection(checkboxes);
            } else {
                selectAllContainer.style.display = 'none';
                resetCheckboxListeners(checkboxes);
            }
        });

        selectAllCheckbox.addEventListener('change', function () {
            const checkboxes = getCheckboxes();
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Optional: Search Functionality (Make sure you have an element with id="searchInput" if using this)
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
                document.querySelectorAll('#birthdaysTable tbody tr').forEach(row => {
                    const id = row.cells[1].textContent.toLowerCase(); // Member ID
                    const name = row.cells[2].textContent.toLowerCase(); // Full Name
                    row.style.display = (id.includes(searchValue) || name.includes(searchValue)) ? '' : 'none';
                });
            });
        }
    });
</script>

            @endif




        </div>

    </div>

</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('
            success ') }}',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'swal-ok-button'
            }
        });

        // Custom button style
        const style = document.createElement('style');
        style.innerHTML = `
                .swal-ok-button {
                    background: linear-gradient(115deg, #0f0b8c, #77dcf5) !important;
                    border: none;
                    color: white !important;
                }
            `;
        document.head.appendChild(style);
    });
</script>
@endif


@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('
            error ') }}',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif



<script>
    $(document).ready(function() {
        $('#birthdaysTable').DataTable({
            "pageLength": 10, // Set initial page length
            "ordering": false, // Disable sorting
            "searching": true, // Enable search
            "lengthChange": true, // Show "Show X entries" dropdown
            "info": true, // Show "Showing X of X entries"
            "lengthMenu": [10, 25, 50, 100] // Dropdown options
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