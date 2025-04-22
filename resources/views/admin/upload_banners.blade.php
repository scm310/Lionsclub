@extends('MasterAdmin.layout')

@section('content')
    <style>
        .nav-tabs .nav-item {
            margin-right: 1px;

        }

        .nav-tabs .nav-link {
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            color: white;

            padding: 10px 15px;

            border-radius: 5px;

        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            color: #fff;
            font-weight: bold;
            border-bottom: 3px solid yellow;

        }

        .nav-tabs {
            border-bottom: none;
            margin-bottom: 4px;
        }


        .custom-btn {
            background: rgb(30, 144, 255);
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 50%;
            transition: 0.3s;
        }

        .custom-btn:hover {
            background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
            color: white;
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

        table#complaintTable thead .sorting:after,
        table#complaintTable thead .sorting:before {
            display: none !important;
        }

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

            border-radius: 10px;

        }

        /* Reduce the size of the "Show Entries" dropdown */
        .dataTables_length select {
            width: 70px !important;
            /* Reduced width */
            height: 30px;
            /* Smaller height */
            font-size: 12px;
            /* Smaller font */
            padding: 5px 10px;
            /* Adjust padding */
            border: 1px solid #ccc;
            /* Border styling */
            border-radius: 4px;
            /* Rounded corners */
            background: white;


            /* Custom arrow */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='gray' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8l-6 7a.5.5 0 0 1-.8 0l-6-7a.5.5 0 0 1-.1-.3z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 6px center;
            /* Adjust arrow position */
            background-size: 10px;
            /* Smaller arrow size */
        }

        /* On hover */
        .dataTables_length select:hover {
            border-color: #007bff;
            /* Highlight effect */
        }


        div.dataTables_wrapper div.dataTables_length select {
            width: 50px !important;
            display: inline-block;
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

           /* Push search and length dropdown down a little */
  .dataTables_length,
    .dataTables_filter {
        margin-top: 0.5rem; /* Adjust as needed */
    }
    #table-image4 tbody tr:nth-child(odd) {
        background-color: #F0F8FF; /* Alice Blue */
    }

    #table-image4 tbody tr:nth-child(even) {
        background-color: #B9D9EB; /* Soft pastel blue */
    }

    #table-image4 td {
        padding: 10px;
        border-color: #ddd;
    }

    .modal .modal-header .btn-close {
    position: absolute;
    top: 2.6875rem;
    right: 2.8125rem;
    color:#222;
   
}
.custom-gradient-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        color: white;
        border: none;
 
    }

    .custom-gradient-btn:hover {
        opacity: 0.9;
    }

    .custom-cancel-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        color: white;
        border: none;
    }

    .custom-cancel-btn:hover {
        background: grey !important;
        color: white;
    }

    </style>
    <div class="container mt-4">
        <div class="white-container">
            <h5 class="text-center"> </h5>
            <h3 class="mb-3 custom-heading">Upload Advertisements</h3>

            @include('admin.partial.alerts')


            <!-- Scrollable Tab Navigation -->
            <div class="overflow-auto">
                <ul class="nav nav-tabs flex-nowrap" id="bannerTabs" role="tablist" style="white-space: nowrap;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#uploadBanners" role="tab">Upload Top
                            AD</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">Upload Left AD</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab3" role="tab">Upload Right AD</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab">Upload Bottom AD</a>
                    </li>
                   
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab6" role="tab">Upload Popup AD</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab5" role="tab">Upload Governor Details</a>
                    </li>
                </ul>
            </div>


            <!-- Edit Icon with Rotation Effect -->
            @php
                $gsb = \App\Models\Generalbanner::first() ?? new stdClass(); // Prevent null errors
                $bannerNames = [
                    10000 => $gsb->{'10000'} ?? 'Default 10000',
                    5000 => $gsb->{'5000'} ?? 'Default 5000',
                    1000 => $gsb->{'1000'} ?? 'Default 1000',
                ];

                $bannerSizes = [
                    10000 => '1200x200',
                    5000 => '600x200',
                    1000 => '400x200',
                ];
            @endphp

         <!-- Edit Name Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #87cefa; color: black;"> <!-- Set text color to black -->
            <div class="modal-header">
                <h5 class="modal-title text-center" id="editModalLabel">Update AD Name</h5>
                <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>


            </div>
            <form id="editForm" action="{{ route('bannername') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="banner_type" id="banner-type">

                <div class="modal-body">
                    <label id="banner-label" for="banner-input">AD</label>
                    <input type="text" id="banner-input" name="banner_value" class="form-control" required>
                </div>

                <div class="modal-footer d-flex justify-content-center w-100">
    <button type="submit" class="btn custom-gradient-btn ms-2">Update</button>&nbsp;&nbsp;
    <button type="button" class="btn custom-cancel-btn" data-bs-dismiss="modal">Cancel</button>
</div>
            </form>
        </div>
    </div>
</div>


            <!-- Tab Content -->

            <div class="tab-content mt-3">
                <!-- Upload Banners Tab -->
                <div class="tab-pane fade show active" id="uploadBanners">
                    <div class="row">

                        @foreach ([10000, 5000, 1000] as $banner)
                            <div class="col-12 col-md-4 mb-4"> <!-- Full width on mobile, 3 columns on larger screens -->
                                <div class="card h-100">
                                    <div class="card-body" style="background-color: #87cefa;">
                                        <h5 class="card-title text-center">
                                            {{ $bannerNames[$banner] }}
                                            <i class="fas fa-edit text-primary rotate-icon "  data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-banner="{{ $banner }}"
                                                data-value="{{ $gsb->{$banner} ?? '' }}" data-id="{{ $gsb->id ?? '' }}"
                                                style="cursor: pointer; font-size: 12px;">
                                            </i>
                                        </h5>

                                        <form action="{{ route('upload.banner') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="image">AD size should be
                                                ({{ $bannerSizes[$banner] }})*</label>
                                            <input type="hidden" name="banner_type" value="{{ $banner }}">

                                            <div class="mb-3">
                                                <input type="file" name="image" required class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label>Enter Website Link* </label>
                                                <input type="Text" name="url" class="form-control"
                                                    placeholder="Enter Website Link" required>
                                            </div>

                                            <div class="text-center">
    <button type="submit" class="btn w-40 mt-3 text-white"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%;">
       Upload
    </button>
</div>
                                            <!-- Full width button -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @include('admin.banners.bannertables')
                </div>

                @include('admin.partial.Edit')

                <!-- Tab 2 Content -->
                <div class="tab-pane fade" id="tab2">
                    <div class="row">
                        @include('admin.leftbanner')
                    </div>
                </div>

                <!-- Tab 3 Content -->
                <div class="tab-pane fade" id="tab3" role="tabpanel">
                    <div class="row">
                        @include('admin.rightbanner')
                    </div>
                </div>

                <!-- Tab 4 Content -->
                <div class="tab-pane fade" id="tab4">


                    <div class="row">
                        <!-- Image Upload 1 -->
                        <div class="d-flex justify-content-center align-items-center">
                        <div class="card" style="background-color: #87cefa;">
    <div class="card-body">
        <h5 class="card-title text-center">Upload Bottom AD</h5>
        <form action="{{ route('upload.bottom.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="image">AD size should be (1353x180)*</label>
            <input type="file" name="image" required class="form-control mt-2">
            
            <label>Enter Website Link* </label>
            <input type="text" name="website_link" placeholder="Enter Website Link" class="form-control mt-1">
            
           
            <div class="text-center">
    <button type="submit" class="btn w-40 mt-3 text-white"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%; align-items: center;">
       Upload
    </button>
</div>
        </form>
    </div>
</div>

                        </div>
                    </div>



                    <!-- Display Uploaded Banners in Table -->
                    <div class="row mt-5">
                        <div class="col-md-12">
      
                        <div class="card">
    <div class="card-header text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
        <h5 class="mb-0 text-center text-white">Bottom AD List</h5>
    </div>
    <br><br>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="table-image4" style="width: 100%; overflow-x: auto;">
                <thead style="background-color:#003366;">
                    <tr>
                        <th style=" color: white; text-align: center; text-transform: capitalize;">S.No</th>
                        <th style=" color: white; text-align: center; text-transform: capitalize;">Image</th>
                        <th style=" color: white; text-align: center; text-transform: capitalize;">Website Link</th>
                        <th style=" color: white; text-align: center; text-transform: capitalize;">Date & Time</th>
                        <th style=" color: white; text-align: center; text-transform: capitalize;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="banner-img-container">
                                    <img class="banner-img" src="{{ asset('storage/app/public/' . $banner->image) }}" width="150" loading="lazy">
                                </div>
                            </td>
                            <td>
    <a href="{{ $banner->website_link }}" target="_blank" title="{{ $banner->website_link }}">
        {{ Str::limit($banner->website_link, 10) }}
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

                            <td>
                                <form action="{{ route('delete.bottom.banner', $banner->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger sweet-delete" data-name="Banner #{{ $loop->iteration }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash">
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
</div>

                        </div>
                    </div>

                </div>

                <!-- Tab 5 Content (Moved Inside tab-content) -->
                <div class="tab-pane fade" id="tab5">
                    <div class="row">
                        @include('admin.member')
                    </div>
                </div>

                <!-- Tab 5 Content (Moved Inside tab-content) -->
                <div class="tab-pane fade" id="tab6">
                    <div class="row">
                        @include('admin.popup')
                    </div>
                </div>

            </div>
            <!-- Closing .tab-content properly -->
        </div>


        <!-- Include Bootstrap JS for Tabs Functionality -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let tabGroups = ["#uploadTabs", "#pricingTabs"];

                tabGroups.forEach(groupId => {
                    let tabLinks = document.querySelectorAll(`${groupId} .nav-link`);
                    tabLinks.forEach(link => {
                        link.addEventListener("click", function() {
                            tabLinks.forEach(tab => tab.classList.remove("active"));
                            this.classList.add("active");
                        });
                    });
                });
            });
        </script>




        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.sweet-delete');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');
                        const name = this.getAttribute('data-name');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: `You are about to delete ${name}. This cannot be undone!`,
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
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editModal = document.getElementById('editModal');

                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const bannerType = button.getAttribute('data-banner');
                    const bannerValue = button.getAttribute('data-value');
                    const bannerId = button.getAttribute('data-id');

                    // Set form values
                    document.getElementById('banner-type').value = bannerType;
                    document.getElementById('edit-id').value = bannerId;
                    document.getElementById('banner-input').value = bannerValue;

                    // Update label dynamically
                    let label = '';
                    if (bannerType == '10000') label = 'Top AD 1';
                    else if (bannerType == '5000') label = 'Top AD 2';
                    else if (bannerType == '1000') label = 'Top AD 3';

                    document.getElementById('banner-label').innerText = label;
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $('#table-image4').DataTable({
                    "pageLength": 10,
                    "ordering": false,
                    "searching": true,
                    "lengthChange": true,
                    "info": true,
                    "lengthMenu": [10, 25, 50, 100]
                });
            });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tabId = @json(session('tab_id'));

                if (tabId) {
                    const triggerEl = document.querySelector(`a[href="#${tabId}"]`);
                    if (triggerEl) {
                        const tab = new bootstrap.Tab(triggerEl);
                        tab.show();
                    }
                }
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tabId = @json(session('tab_id'));
                const outerTab = @json(session('outerTab'));
                const innerTab = @json(session('activeTab'));

                // Handle original tabId
                if (tabId) {
                    const triggerEl = document.querySelector(`a[href="#${tabId}"]`);
                    if (triggerEl) {
                        const tab = new bootstrap.Tab(triggerEl);
                        tab.show();
                    }
                }

                // Handle outer tab (e.g., Upload Advertisement)
                if (outerTab) {
                    const outerTrigger = document.querySelector(`a[href="#${outerTab}"]`);
                    if (outerTrigger) {
                        const outerTabInstance = new bootstrap.Tab(outerTrigger);
                        outerTabInstance.show();
                    }
                }

                // Handle inner tab (e.g., ad1, ad2)
                if (innerTab) {
                    const innerTrigger = document.querySelector(`[data-bs-target="#${innerTab}"]`);
                    if (innerTrigger) {
                        const innerTabInstance = new bootstrap.Tab(innerTrigger);
                        innerTabInstance.show();
                    }
                }
            });
        </script>
    @endsection
