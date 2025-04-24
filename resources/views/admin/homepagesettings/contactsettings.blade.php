@extends('MasterAdmin.layout')

@section('content')

<style>
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


#imageTable1 tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
}

#imageTable1 tbody tr:nth-child(even) {
    background-color: #B9D9EB;
}
/* Fix arrow alignment in DataTables dropdown */
.dataTables_length select {
        appearance: none;
        /* Remove default arrow */
        -webkit-appearance: none;
        -moz-appearance: none;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23000"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 30px;
        /* Add padding for the arrow */
        cursor: pointer;
    }

    /* Ensure consistency in dropdown size and alignment */
    .dataTables_length label {
        display: flex;
        align-items: center;
    }

    .dataTables_length select:focus {
        outline: none;
        box-shadow: 0 0 5px #007bff;
        /* Add focus effect */
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 52px;
    }
    .page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}
.custom-btn {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: 0.3s;
}


.custom-confirm-btn,
.custom-cancel-btn {
    background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 18px;
    font-weight: 600;
    transition: background 0.3s ease;
}

.custom-cancel-btn:hover {
    background: gray;
}

/* Add spacing between confirm and cancel buttons */
.swal2-actions .custom-confirm-btn {
    margin-right: 10px;
}


</style>

<div class="container mt-4 ">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Contact Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card" style="max-width: 500px; margin: 0 auto; background-color:#87cefa;">
    <div class="card-body">
    <form method="POST" action="{{ route('contact.store') }}">
        @csrf
        <div class="mb-3">
            <label style="color:black;">Address:</label>
            <textarea name="address" class="form-control" rows="4">{{ $contact->address ?? '' }}</textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="custom-btn">Save Settings</button>
        </div>
    </form>
</div>
</div>

    <div class="table-responsive mt-4">
        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
        <thead style="background-color:#003366 !important;">

            <tr>
                <th>S.No</th>
                <th>Address</th>
                <th>Date & time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $contact->address ?? 'No address available' }}</td>
                    <td>{{ $contact->created_at->format('d-m-Y H:i:s') }}</td>
z

                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                        <!-- Delete Button -->
                        <form action="{{ route('contact.delete', $contact->id) }}" method="POST" style="display:inline;" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm delete-btn">
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

<!-- Required Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
$(document).ready(function () {
    $('.delete-btn').on('click', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'custom-confirm-btn',
                cancelButton: 'custom-cancel-btn'
            },
            buttonsStyling: false // Important to apply your own styles
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});


</script>
@endsection
