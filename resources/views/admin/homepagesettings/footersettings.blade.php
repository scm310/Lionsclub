@extends('MasterAdmin.layout')
@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<!-- DataTables base CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables responsive extension CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

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
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
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

    .table-responsive {
background-color: #f8f9fa; /* Light background */
color:black;
padding: 20px; /* Adds space inside the container */
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
overflow: hidden; /* Ensures rounded corners work */
width:100%;
border-radius: 10px;

margin-top:-20px;

}
.table-responsive th{
    text-align:center !important;
    color:white !important;
}
.table-responsive td{
    text-align:center !important;
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
</style>

<div class="container mt-4 ">
    <div class="white-container">

        <h3 class="custom-heading text-white mb-4">Footer Settings</h3>

        {{-- Include SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('
                error ') }}',
                confirmButtonColor: '#d33',
            });
        </script>
        @endif

        <div class="card" style="max-width: 700px; margin: 0 auto; background-color:#87cefa; padding:16px;">

        <form action="{{ route('footer.store') }}" method="POST" >
            @csrf
            <div class="form-row row mb-3">
                <div class="form-group col-md-6">
                    <label class="form-label text-dark">Copyright Text</label>
                    <input type="text" name="copyright" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label text-dark">Facebook Link</label>
                    <input type="text" name="facebook" class="form-control">
                </div>
            </div>

            <div class="form-row row mb-3">
                <div class="form-group col-md-6">
                    <label class="form-label text-dark">Twitter Link</label>
                    <input type="text" name="twitter" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label text-dark">Instagram Link</label>
                    <input type="text" name="instagram" class="form-control">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn custom-btn px-4 py-2">Submit</button>
            </div>
        </form>
    </div>

    {{-- Show saved footer settings --}}
    <div class="mt-5">
        <h4 class="custom-heading">Footer Records</h4>
        <div class="table-responsive">
            <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
                <thead style="background-color:#003366 !important;">
                    <tr>
                        <th>S.No</th>
                        <th>Copyright</th>
                        <th>Facebook</th>
                        <th>Twitter</th>
                        <th>Instagram</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($footers as $footer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $footer->copyright_text }}</td>
                        <td><a href="{{ $footer->facebook_link }}" target="_blank">{{ $footer->facebook_link }}</a></td>
                        <td><a href="{{ $footer->twitter_link }}" target="_blank">{{ $footer->twitter_link }}</a></td>
                        <td><a href="{{ $footer->instagram_link }}" target="_blank">{{ $footer->instagram_link }}</a></td>
                        <td>
                            <form action="{{ route('footer.delete', $footer->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
</div>
</div>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>


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


@endsection
