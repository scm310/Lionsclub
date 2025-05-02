@extends('MasterAdmin.layout')

@section('content')
<style>
    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: auto;
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

    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;
        align-items: center !;
        justify-content: center;
        transition: 0.3s;
    }

    .white-container {
        background-color: #fff;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .custom-heading {
        color: rgb(255, 255, 255);
        font-weight: 600;
    }

    label.form-label {
        font-weight: 500;
        color: #333;
    }


    .table th {
        color: white !important;
        font-size: 15px;
    }

    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }

    #completedEventsTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
    }

    #completedEventsTable tbody tr:nth-child(even) {
        background-color: #B9D9EB;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        color: #000000;
    }

    div.dataTables_wrapper div.dataTables_length select {
        display: inline-block;
        width: 60px;
    }

    /* Customizing the SweetAlert2 confirm button */
    .swal2-confirm {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        /* Ensure text is visible */
        border: none !important;
        /* Remove default border */
        padding: 10px 20px;
        /* Optional: Adjust padding to make the button bigger */
    }

    /* Customizing the SweetAlert2 cancel button */
    .swal2-cancel {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        /* Ensure text is visible */
        border: none !important;
        /* Remove default border */
        padding: 10px 20px;
        /* Optional: Adjust padding to make the button bigger */
    }

    @media (max-width: 767.98px) {
    .custom-container {
        height: 480px !important;
    }
}
</style>

<div class="container mt-4 white-container">
    <h2 class="mb-4 text-center custom-heading">Announcements</h2>
    <div class="white-container rounded shadow custom-container" style="background-color: #87cefa; max-width:500px; height:400px;">
        <div class="container">

            <!-- Add this to your layout or Blade file in the <head> section -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            {{-- Display success message --}}
            @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('
                    success ') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
            @endif

            {{-- Display validation errors --}}
            @if ($errors->any())
            <script>
                Swal.fire({
                    title: 'Oops!',
                    text: '{{ implode('
                    ', $errors->all()) }}', // Combine all errors into one string
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
            @endif


            <form action="{{ route('admin.announcement.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Date & Image Row --}}
                <div class="row mb-2">
                    {{-- Date --}}
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6">
                        <label for="image" class="form-label">Image (optional)</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                    </div>
                </div>

                {{-- Subject --}}
                <div class="mb-2">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                </div>

                {{-- Message --}}
                <div class="mb-2">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" rows="5" class="form-control" required   maxlength="250"></textarea>
                </div>

                {{-- Submit Button --}}
                <div class="text-center">
                    <button type="submit" class="btn custom-btn">Submit</button>
                </div>
            </form>

        </div>
    </div>


    <h2 class="mt-3 custom-heading">Announcements List</h2>
    <div class="table-responsive white-container">
        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
            <thead style="background-color:#003366 !important;">
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($announcements as $announcement)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d-m-Y h:i A') }}</td>

                    <td>{{ $announcement->subject }}</td>
                    <td>{{ $announcement->message }}</td>
                    <td>
                        @if($announcement->image)
                        <img src="{{ asset('storage/app/public/' . $announcement->image) }}" alt="Image" width="80">
                        @else
                        <img src="{{ asset('assets/images/default1.jpg') }}" alt="Default Image" width="80">
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('admin.announcement.destroy', $announcement->id) }}" method="POST" id="delete-form-{{ $announcement->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $announcement->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#imageTable1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "pageLength": 10
        });
    });
</script>

<script>
    function confirmDelete(announcementId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this announcement?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('delete-form-' + announcementId).submit();
            }
        });
    }
</script>




@endsection