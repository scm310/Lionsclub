<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<style>
    .upload {
        border-radius: 24px;
    }

    .banner-img-container {
        position: relative;
        display: inline-block;
    }

    .banner-img {
        width: 100px;
        /* Initial size */
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img-container:hover .banner-img {
        transform: scale(1.5);
        /* Zoom out */
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

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_paginate {
        color: black !important;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_paginate {
        color: black !important;
    }

    /* Add borders to table */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100%;
    }

    table.dataTable th,
    table.dataTable td {
        border: 1px solid black !important;
        padding: 8px;
    }

    /* Make the page length dropdown (select) text black */
    .dataTables_length select {
        color: black !important;
    }

    /* Also, make the label text black */
    .dataTables_length label {
        color: black !important;
    }


    /* Push search and length dropdown down a little */
    .dataTables_length,
    .dataTables_filter {
        margin-top: 0.5rem;
        /* Adjust as needed */
    }

    /* Odd and even row color for ad1Table and ad2Table */
    #ad1Table tbody tr:nth-child(odd),
    #ad2Table tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
        /* Alice Blue */
    }

    #ad1Table tbody tr:nth-child(even),
    #ad2Table tbody tr:nth-child(even) {
        background-color: #B9D9EB;
        /* Soft pastel blue */
    }

    /* Table cell padding and border */
    #ad1Table td,
    #ad2Table td {
        padding: 10px;
        border-color: #ddd;
    }

    /* Active pagination button style */
    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="col-12 col-md-6 mb-4">
    <div class="card">
        <div class="card-body" style="background-color: #87cefa;">
            <h5 class="card-title text-center">Upload Left AD 1</h5>
            <form action="{{ route('upload.ad') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ad_type" value="ad1">

                <div class="mb-3">
                    <label for="image">AD size should be (400x300)*</label>
                    <input type="file" name="image" required class="form-control">
                </div>

                <div class="mb-3">
                    <label>Enter Website Link* </label>
                    <input type="text" name="website_link" placeholder="Enter Website Link" required
                        class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn w-40 mt-3 text-white"
                        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%;">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 mb-4"> <!-- Same for the second card -->
    <div class="card">
        <div class="card-body" style="background-color: #87cefa;">
            <h5 class="card-title text-center">Upload Left AD 2</h5>
            <form action="{{ route('upload.ad') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ad_type" value="ad2">

                <div class="mb-3">
                    <label for="image">AD size should be (400x300)*</label>
                    <input type="file" name="image" required class="form-control">
                </div>

                <div class="mb-3">
                    <label>Enter Website Link* </label>
                    <input type="text" name="website_link" placeholder="Enter Website Link" required
                        class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn w-40 mt-3 text-white"
                        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%;">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Tabs -->
<div class="overflow-auto">
    <ul class="nav nav-tabs mt-4 flex-nowrap d-flex" id="adTabs" role="tablist" style="white-space: nowrap;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ad1-tab" data-bs-toggle="tab" data-bs-target="#ad1" type="button"
                role="tab">
                Left AD 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ad2-tab" data-bs-toggle="tab" data-bs-target="#ad2" type="button"
                role="tab">
                Left AD 2
            </button>
        </li>
        <!-- Add more tabs here if needed -->
    </ul>
</div>
<div class="tab-content mt-3" id="adTabsContent">
    <div class="tab-pane fade show active" id="ad1" role="tabpanel">
        <div class="card">
            <!-- Header for Advertisement 1 -->
            <div class="card-header text-white text-center py-2" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
                <h5 class="mb-0 text-white"> Left AD 1 List</h5>
            </div>
            <br><br>
            <!-- Table inside card body, wrapped in responsive container -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap mb-0" id="ad1Table"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">S.No</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Website Link</th>
                                <th class="text-center">Date & Time</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($adimage) && count($adimage) > 0)
                            @foreach ($adimage as $index => $image)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="banner-img-container">
                                        <img class="banner-img"
                                            src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                            width="100" loading="lazy">
                                    </div>
                                </td>
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <a href="{{ $image->website_link }}" target="_blank" title="{{ $image->website_link }}">
                                        {{ \Illuminate\Support\Str::limit($image->website_link, 10) }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $image->created_at ? \Carbon\Carbon::parse($image->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                                </td>
                                <td>
                                    <form
                                        action="{{ route('delete.ad.image', ['id' => is_array($image) ? $image['id'] : $image->id, 'ad_type' => 'ad1']) }}"
                                        method="POST"
                                        class="delete-form"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to undo this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <div class="tab-pane fade" id="ad2" role="tabpanel">
        <div class="card">
            <!-- Header for Advertisement 2 -->
            <div class="card-header text-white text-center py-2" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
                <h5 class="mb-0 text-white"> Left AD 2 List</h5>
            </div>
            <br></br>
            <!-- Table wrapped in card body -->
            <div class="card-body p-0">
                <!-- Responsive wrapper to prevent table overflow on mobile -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap mb-0" id="ad2Table"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">S.No</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Website Link</th>
                                <th class="text-center">Date & Time</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($adimage2) && count($adimage2) > 0)
                            @foreach ($adimage2 as $index => $image)
                            <tr id="row-{{ $image->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="banner-img-container">
                                        <img class="banner-img"
                                            src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                            width="100">
                                    </div>
                                </td>
                                <td class="fold-url" data-url="{{ $image->website_link }}">
                                    <a href="{{ $image->website_link }}" target="_blank">{{ $image->website_link }}</a>
                                </td>

                                <td class="text-center">
                                    {{ $image->created_at ? \Carbon\Carbon::parse($image->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                                </td>
                                <td>
                                    <form action="{{ route('delete.ad.image', ['id' => $image->id, 'ad_type' => 'ad2']) }}"
                                        method="POST"
                                        class="delete-form"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
    // Attach the click event to all delete buttons
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the form from submitting immediately

            const form = this.closest('form'); // Find the closest form to the clicked button

            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    form.submit();
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.fold-url').forEach(function(td) {
            const url = td.getAttribute('data-url');
            if (url) {
                const folded = url.match(/.{1,10}/g).join('<wbr>'); // break every 20 characters
                td.querySelector('a').innerHTML = folded;
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


@if (session('sweetalert'))
<script>
    Swal.fire({

        confirmButtonText: 'OK'
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $('#ad1Table').DataTable({
            responsive: true,
            ordering: false,
            pageLength: 10
        });

        $('#ad2Table').DataTable({
            responsive: true,
            ordering: false,
            pageLength: 10
        });
    });
</script>