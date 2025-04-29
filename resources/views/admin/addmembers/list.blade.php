@extends('MasterAdmin.layout')
@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    #memberDetailsBody th {
        text-transform: capitalize;
        font-size: 14px;
        /* Adjust header font size */
    }

    #memberDetailsBody td {
        font-size: 13px;
        /* Adjust data font size */
    }

    #memberDetailsContainer {
        font-size: 14px;
        /* Adjust overall font size */
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
        background-color: #003366;
        font-size: 15px;
    }

    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 5px;
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

    .bg-primary {
        background-color: rgba(0, 0, 0, 0.151) !important;
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

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }
</style>
<style>
    /* Add space between the table controls and the strip above */
    .dataTables_wrapper {
        margin-top: 10px;
        /* Adjust the value as needed */
    }

    /* Optionally, if you only want to move the search box and entries dropdown */
    .dataTables_length,
    .dataTables_filter {
        margin-top: 10px;
        /* Adjust the value as needed */
    }

    #membersTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
        /* Alice Blue */
    }

    #membersTable tbody tr:nth-child(even) {
        background-color: #B9D9EB;
        /* Soft pastel blue */
    }

    #membersTable td {
        padding: 10px;
        border-color: #ddd;
    }

    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }
</style>
<style>
    #membersTable th:nth-child(1),
    #membersTable td:nth-child(1) {
        width: 15%;
        /* Adjust as needed */
    }

    #membersTable th:nth-child(2),
    #membersTable td:nth-child(2) {
        width: 25%;
    }

    #membersTable th:nth-child(3),
    #membersTable td:nth-child(3) {
        width: 30%;
    }

    #membersTable th:nth-child(4),
    #membersTable td:nth-child(4) {
        width: 30%;
    }

    .btn-light:hover {
        color: rgb(242, 245, 248) !important;
        background-color: #e4e6e8 !important;
        border-color: #dfe1e3 !important;

    }
    /* Hide dropdown arrow */
.no-caret::after {
    display: none !important;
}

</style>
<div class="container mt-4">
    <div class="white-container">
        @if ($errors->any())
        <div class="alert alert-danger mt-2">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('
                                success ') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
        <h3 class="mb-3 custom-heading">Member List</h3>
        <div class="card shadow-lg">
            <div class="card-header text-white d-flex justify-content-between align-items-center bg-primary">
                <div class="d-flex align-items-center">
                    <!-- Import Form -->
                    <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center me-2">
                        @csrf

                        <label for="import_file" class="form-label mb-0 me-2 text-dark">Upload Member List</label>
                        <input type="file" name="import_file" id="import_file" class="form-control form-control-sm me-2" required>

                        <button type="submit" class="btn btn-light btn-sm me-2 custom-btn" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">Import</button>
                    </form>

                </div>


                <div class="d-flex justify-content-end">
    <!-- Add Members Button -->
    <a href="{{ route('members.add') }}" class="btn btn-secondary btn-sm custom-btn me-2"
       style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
        <i class="bi bi-gear-fill"></i> Add Members
    </a>

    <!-- Settings Button -->
    <a href="{{ route('admin.settings.view') }}" class="btn btn-secondary btn-sm custom-btn"
       style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
        <i class="bi bi-gear-fill"></i> Settings
    </a>
</div>


            </div>
            @include('admin.partial.alerts')
            <div class="row">
                <!-- Members Table (Initially full width) -->
                <div id="tableContainer" class="col-md-12">
                    <table id="membersTable" class="table table-bordered">
                        <thead class="table-white" style="text-transform: capitalize;">
                            <tr>
                                <th>S.No</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                {{-- <th>Parent District</th> --}}
                                <th>Account Name</th> <!-- New Column -->
                                {{-- <th>Membership Full Type</th> <!-- New Column --> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $key => $member)
                            <tr>
                                <td style="width: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $key + 1 }}</td>
                                <td style="width: 20px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <a class="view-member" data-id="{{ $member->id }}">
                                        {{ $member->member_id }}
                                    </a>
                                </td>
                                <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ Str::title($member->first_name) }} {{ Str::title($member->last_name) }}
                                </td>
                                {{-- <td>
                {{ $member->parentDistrict ? $member->parentDistrict->name : 'N/A' }}
                                </td> --}}
                                <td>{{ $member->account ? Str::title($member->account->chapter_name) : 'N/A' }}</td> <!-- Account Name -->
                                {{-- <td>{{ $member->membershipType ? $member->membershipType->name : 'N/A' }}</td> <!-- Membership Full Type --> --}}
                                <td style="width: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle no-caret" type="button" id="dropdownMenu{{ $member->id }}" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-ellipsis-v"></i>
</button>


    <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $member->id }}">
        <li>
            <a class="dropdown-item text-warning" href="{{ route('members.edit', $member->id) }}">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
        </li>
        <li>
            <a href="#"
               class="dropdown-item text-info"
               data-bs-toggle="modal"
               data-bs-target="#transferModal"
               data-member-id="{{ $member->id }}"
               data-club-name="{{ $member->account ? Str::title($member->account->chapter_name) : 'N/A' }}">
                <i class="fas fa-exchange-alt me-2"></i> Transfer
            </a>
        </li>
        <li>
            <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash-alt me-2"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>

</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Member Details (Initially hidden) -->
                <div id="memberDetailsContainer" class="col-md-4" style="display: none;">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Member Details</h5>
                            <div id="profilePhotoContainer"></div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody id="memberDetailsBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('members.transfer') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Transfer Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="transferMemberId">

                    <div class="mb-3">
                        <label for="current_club_name" class="form-label">Current Club Name</label>
                        <input type="text" class="form-control" id="current_club_name" name="current_club_name" readonly>
                    </div>


                    <div class="mb-3">
                    <label for="current_club_name" class="form-label"> Club Name</label>
                        <select class="form-select" id="new_club_id" name="new_club_id" required>
                            <option value="">Select a Club</option>
                            @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ Str::title($club->chapter_name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#membersTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": false, // Disable sorting
            "info": true, // Show info text
            "lengthMenu": [250, 500, 750, 1000], // Control entries per page
        });

        // Reduce font size of table data
        $('#membersTable tbody td').css("font-size", "13px"); // Adjust size as needed

        // Capitalize table headers
        $('#membersTable thead th').css("text-transform", "capitalize");

        // Increase width of "Show Entries" dropdown box
        setTimeout(function() {
            $('select[name="membersTable_length"]').css("width", "100px");
        }, 500);
    });
</script>
<!-- Initialize Bootstrap Tooltips -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                // Hover effect for cancel button
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var transferModal = document.getElementById('transferModal');
        transferModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var memberId = button.getAttribute('data-member-id');
            var clubName = button.getAttribute('data-club-name');

            document.getElementById('transferMemberId').value = memberId;
            document.getElementById('current_club_name').value = clubName;
        });
    });
</script>

@endsection
