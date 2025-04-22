<style>

.gradient-btn {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5%;
    color: white;
    border: none;
    padding: 8px 20px;
    font-weight: 500;
    transition: none; /* remove smooth hover transition */
}

/* This completely removes hover styling */
.gradient-btn:hover {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    color: white;
    box-shadow: none;
    transform: none;
}



  .banner-img-container {
    position: relative;
    display: inline-block;
    overflow: hidden; /* Prevent image overflow on zoom */
    width: 100px;
    height: auto;
}

.banner-img-container img {
    display: block;
    width: 100%;
    height: auto;
}


.banner-img-container:hover .banner-img {
    transform: scale(1.5);
    z-index: 1;
}


.delete-button {
    position: relative;
    z-index: 2;
}



  /* Push search and length dropdown down a little */
  .dataTables_length,
    .dataTables_filter {
        margin-top: 0.5rem; /* Adjust as needed */
    }
    #popbanner tbody tr:nth-child(odd) {
        background-color: #F0F8FF; /* Alice Blue */
    }

    #popbanner tbody tr:nth-child(even) {
        background-color: #B9D9EB; /* Soft pastel blue */
    }

    #popbanner td {
        padding: 10px;
        border-color: #ddd;
    }

    .page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}

.swal2-styled.swal2-confirm {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        border: none !important;
    }

    .swal2-styled.swal2-cancel {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        border: none !important;
        transition: background-color 0.3s ease;
    }

    .swal2-styled.swal2-cancel:hover {
        background: grey !important;
    }


    


    @media (max-width: 768px) {
        .table td img {
            width: 80px;
        }
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 767.98px) {
    .responsive-card {
        width: 110% !important;
    }
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var activeTab = "{{ session('activeTab') }}";
        if (activeTab) {
            var tabElement = new bootstrap.Tab(document.querySelector('[href="#' + activeTab + '"]'));
            tabElement.show();
        }
    });
</script>

<div class="row">
    <div class="col-md-12 d-flex justify-content-center align-items-center">
    <div class="card w-60 responsive-card" style="background-color: #87cefa;">

            <div class="card-body">
                <h5 class="card-title text-center">Upload Popup AD</h5><br>
                <form action="{{ route('popup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="image"> AD size should be (800x500)*</label>
                    <input type="file" name="image" required class="form-control mt-2">
                    <label>Enter Website Link* </label>
                    <input type="text" name="link" class="form-control mt-2" placeholder="Enter Website Link">

                    <div class="text-center mt-3">
    <button type="submit" class="btn custom-btn upload gradient-btn">
        Upload
    </button>
</div>


                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow">
        <div class="card-header text-white text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
    <h5 class="mb-0 text-white">Popup AD List</h5>
</div>

            <br>
            <div class="card-body">
            <div class="table-responsive" style="min-width: 100%; overflow-x: auto;">
    <table class="table table-striped table-bordered dt-responsive nowrap w-100" id="popbanner" style="width: 100%;">
        <thead class="bg-dark text-white text-center text-capitalize">
            <tr>
                <th>S.No</th>
                <th>Image</th>
                <th>Website Link</th>
                <th>Date & Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($popup as $index => $banner)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        <div class="banner-img-container">
                            <img src="{{ asset('storage/app/public/' . $banner->image) }}" alt="Popup Image" class="banner-img" loading="lazy" style="max-width: 120px;">
                        </div>
                    </td>
                    <td>
                        <a href="{{ $banner->link }}" target="_blank" title="{{ $banner->link }}" class="d-inline-block text-truncate" style="max-width: 100%;">
                            {{ \Illuminate\Support\Str::limit($banner->link, 10) }}
                        </a>
                    </td>
                    <td class="text-center">
                        @if($banner->created_at)
                            @php
                                $date = \Carbon\Carbon::parse($banner->created_at)->format('d-m-Y');
                                $time = \Carbon\Carbon::parse($banner->created_at)->format('h:i A');
                            @endphp
                            {{ $date }}<br><small>{{ $time }}</small>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('popup.destroy', $banner->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $banner->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
 <!-- table-responsive -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->

<!-- DataTables Core -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables Responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable
    $('#popbanner').DataTable({
        responsive: true,
        pageLength: 10,
        ordering: false,
        searching: true,
        lengthChange: true,
        info: true,
        lengthMenu: [10, 25, 50, 100]
    });
});

// ✅ SweetAlert2 delete with event delegation (works inside DataTables child rows too)
$(document).on('click', '.delete-button', function (e) {
    e.preventDefault();
    let form = $(this).closest('form');

    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>

