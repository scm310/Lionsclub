<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>



<style>
    .member {
        border-radius: 24px !important;
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
        background-color: #f8f9fa;
        /* Light background */
        color: black;
        padding: 20px;
        /* Adds space inside the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
        overflow: hidden;
        /* Ensures rounded corners work */
        width: 100%;
        border-radius: 10px;

        margin-top: -36px;

    }

    .table-responsive th,
    td {
        text-align: center !important;
    }

    /* Styles for the DataTable */
    #complaintTable {
        overflow: hidden;
        /* Ensures proper edge handling */
    }

    /* Ensuring the table header has a proper background */
    #complaintTable thead th,
    #Table thead th {
        background-color: #ffffff;
        /* Dark background for better contrast */
        color: rgb(0, 0, 0);
        /* White text */
    }

    /* Table row hover effect */
    #complaintTable tbody tr:hover {
        background-color: #e9ecef;
        /* Light grey hover effect */
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


    /* Push search and length dropdown down a little */
  .dataTables_length,
    .dataTables_filter {
        margin-top: 0.5rem; /* Adjust as needed */
    }
    #birthdaysTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF; /* Alice Blue */
    }

    #birthdaysTable tbody tr:nth-child(even) {
        background-color: #B9D9EB; /* Soft pastel blue */
    }

    #birthdaysTable td {
        padding: 10px;
        border-color: #ddd;
    }


    
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
        <div class="card shadow-lg p-4" style="background-color: #87cefa;">
                <h4 class="text-center mb-4">Governor Details</h4>

                <script>
                    setTimeout(function() {
                        document.querySelectorAll('.fade-message').forEach(el => {
                            el.style.transition = "opacity 0.5s";
                            el.style.opacity = "0";
                            setTimeout(() => el.remove(), 500); // Remove after fading out
                        });
                    }, 3000); // 3 seconds
                </script>



                <!-- Member Form -->
                <form action="{{ route('admin.addMember') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div>
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"  placeholder="Governor Name" required>
                    </div>

                    <div>
    <label>Role</label>
    <input type="text" name="role" class="form-control" placeholder="Enter Your Role" value="District Governor" required>
</div>


                    <div >
                        <label>Upload Profile Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="text-center">
    <button type="submit" class="btn w-50 mt-3 text-white"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%;">
      Submit
    </button>
</div>

                </form>
            </div>
        </div>
    </div>

    <!-- Display Members -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card shadow-lg p-4">
            <div class="card-header text-white text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
    <h5 class="mb-0 text-white">Governor Details</h5>
</div>


                <table class="table table-striped table-bordered dt-responsive nowrap" id="birthdaysTable"
                    style="width: 100%; overflow-x: auto;">
                    <thead style="background-color:#003366;">
    <tr>
        <th style="text-align: center; color: white;">Name</th>
        <th style="text-align: center; color: white;">Role</th>
        <th style="text-align: center; color: white;">Image</th>
        <th style="text-align: center; color: white;">Action</th> <!-- Add Action Column -->
    </tr>
</thead>

                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->role }}</td>
                                <td>
                                <img src="{{ asset('storage/app/public/' . $member->image) }}"
     width="50"
     height="50"
     loading="lazy"
     alt="{{ $member->name }}">

                                </td>
                                <td>
                                <form action="{{ route('admin.deleteMember', $member->id) }}" method="POST" class="delete-member-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm sweet-delete" data-name="{{ $member->name }}">
        <i class="fas fa-trash-alt"></i>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // DataTables + SweetAlert2 for "Member List"
    $(document).ready(function () {
        $('#birthdaysTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: false,
            searching: true,
            lengthChange: true,
            info: true,
            lengthMenu: [10, 25, 50, 100]
        });
    });

    // ✅ Mobile-safe SweetAlert2 delete (event delegation)
    $(document).on('click', '.sweet-delete', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const memberName = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${memberName}". This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ✅ Show SweetAlert after success (optional)
    @if (session('sweetalert'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('sweetalert') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

