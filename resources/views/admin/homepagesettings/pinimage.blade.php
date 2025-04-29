@extends('MasterAdmin.layout')

@section('content')

<style>
.custom-btn {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: 0.3s;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white;
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px;
    display: inline-block;
    width: 100%;
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

.custom-confirm-btn {
    background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 18px;
    margin-right: 10px;
    font-weight: 600;
    transition: background 0.3s ease;
}

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
.alert{
    width: 300px;
    margin-left: 340px;
    margin-top: 19px;
}
.page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}

.zoom-img {
        transition: transform 0.3s ease;
        max-width: 100px;
        height: auto;
        cursor: pointer;
    }

    .zoom-img:hover {
        transform: scale(1.8);
        z-index: 10;
        position: relative;
    }
</style>


<div class="container mt-4">
    <div class="white-container p-4 shadow rounded bg-white">

        <h3 class="mb-3 custom-heading">Upload District Logo</h3>

        <div class="card" style="max-width: 500px; margin: 0 auto; background-color:#87cefa;">
            <div class="card-body">
                <form action="{{ route('pinimage.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image</label>
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="custom-btn">Upload</button>
                    </div>
                </form>
            </div>
        </div>


        @if(session('success'))
        <div class="alert alert-success fade-up" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger fade-up" id="error-alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display uploaded images -->
    @if($images->count())
    <div class="mt-4">
        <h4 class="custom-heading">Uploaded District Logo</h4>
        <div class="table-responsive">
        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
        <thead style="background-color:#003366 !important;">
        <tr>
                        <th>S.No</th>
                        <th>Logo</th>
                        <th>Date & time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($images as $image)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Pin Image" class="zoom-img">


                        </td>
                        <td>{{ $image->created_at->format('d M Y, h:i A') }}</td>

                        <td>
    <form id="delete-form-{{ $image->id }}" action="{{ route('images.destroy', $image->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $image->id }})">
        <i class="fas fa-trash-alt"></i>
    </button>
</td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="text-center mt-5">
        <p>No images uploaded yet.</p>
    </div>
    @endif

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
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "pageLength": 10
                });
            });
        </script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This image will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: ' Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: false, // or just remove this line
        customClass: {
            confirmButton: 'custom-confirm-btn',
            cancelButton: 'custom-cancel-btn'
        },
        buttonsStyling: false // Needed to apply custom classes
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
<script>
    setTimeout(function () {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.opacity = '0';
        if (errorAlert) errorAlert.style.opacity = '0';
    }, 3000); // Hide after 3 seconds
</script>



@endsection
