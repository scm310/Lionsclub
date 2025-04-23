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
</style>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">
    <div class="white-container p-4 shadow rounded bg-white">

        <h3 class="mb-3 custom-heading">Upload Pin Image</h3>

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

   

    <!-- Display uploaded images -->
    @if($images->count())
    <div class="mt-5">
        <h4 class="custom-heading">Uploaded Images</h4>
        <div class="table-responsive">
        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
        <thead style="background-color:#003366 !important;">
        <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Uploaded At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($images as $image)
                    <tr>
                        <td>{{ $image->id }}</td>
                        <td>
                        <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Pin Image" style="max-width: 100px; height: auto;">

                        
                        </td>
                        <td>{{ $image->created_at->format('d M Y, h:i A') }}</td>

                        <td>
    <form action="{{ route('images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
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
