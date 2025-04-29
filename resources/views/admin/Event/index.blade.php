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

    /* Remove bottom border (the thin line) from the tab navigation */
.nav-tabs {
    border-bottom: none !important;
}

    .nav-tabs .nav-item {
        margin-right: 1px;
    }

    .nav-tabs .nav-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        font-weight: bold;
        border-bottom: 3px solid yellow;
    }

    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        color: white;
    }


    .image-preview {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
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

    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        .custom-btn {
            font-size: 14px;
            padding: 8px 16px;
            width: 100%;
            border-radius: 5%;
            margin-left: 0px;
        }

        .card {
            width: 100% !important;
            padding: 20px;
        }
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

    /* Responsive adjustments for screens smaller than 768px */
@media only screen and (max-width: 768px) {
    /* Make tab navigation more readable */
    .nav-tabs .nav-link {
        padding: 10px 8px;
        font-size: 14px;
        text-align: center;
    }

    /* Adjust card widths */
    .card {

        width: 127% !important;
        margin: 7px -35px !important;

    }

    /* Make headings smaller */
    .custom-heading, h5 {
        font-size: 18px !important;
        text-align: center;
    }

    /* Improve spacing inside forms */
    .form-group label,
    .form-control,
    .form-check-label {
        font-size: 14px;
    }

    .form-control {
        padding: 10px;
    }

    /* Full-width submit button */
    .custom-btn {
        width: 31% !important;
        margin-top: 10px;
        margin-left: 2px;
    }

    /* Adjust table font and make it responsive */
    table {
        font-size: 14px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .dataTables_wrapper {
        overflow-x: auto;
    }

    /* Reduce padding/margins for compact layout */
    .p-4 {
        padding: 1rem !important;
    }

    .mt-4, .my-4 {
        margin-top: 1rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }


    .form-select{
    width:0px;
}

}

.select2-container .select2-results__option {
    color: black;
}

/* Selected item text color */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: black;
}

.form-select{
    width:275px;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 38px !important;
    user-select: none;
    -webkit-user-select: none;
    border: 1px solid rgb(226, 223, 223) !important; /* Add this line for grey border */
}
.select2-container--open .select2-search__field::placeholder {
    font-size: 14px !important;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    font-size: 14px;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #575757 !important;
}



    @media (max-width: 768px) {
        table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before {
            top: 50%;
            transform: translateY(-50%);
        }
    }

      /* Default image size for desktop */
      #completedEventsTable td img {
        width: 60px;
        height: auto;
    }

    /* Reduce image size for mobile screens */
    @media (max-width: 768px) {
        #completedEventsTable td img {
            width: 60px;
            height: auto;
        }
    }


    .page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}


.question-column {
        max-width:  162px;
        height: 26px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding: 0px;
        text-align: left;
        cursor: pointer;
        transition: height 0.3s ease-in-out;
    }

    /* Expanded state - applies when clicked */
    .question-column.expanded{
        height: auto;
        white-space: normal;
        word-wrap: break-word;
        width:200px;
    }

    #imageTable1 tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
}

#imageTable1 tbody tr:nth-child(even) {
    background-color: #B9D9EB;
}

#completedEventsTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
}

#completedEventsTable tbody tr:nth-child(even) {
    background-color: #B9D9EB;
}

.card1{
        background-color:#87cefa;
    }

    .zoom-image {
        transition: transform 0.3s ease-in-out; /* Smooth zoom transition */
        cursor: pointer;
    }

    .zoom-image:hover {
        transform: scale(1.8); /* Zoom in on hover */
    }

    .alert{
        width: 254px;
    margin-left: 406px;
    }
</style>

<div class="container mt-4 ">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Events</h3>

        @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

       


        <ul class="nav nav-tabs d-flex flex-wrap" id="bannerTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab1">Add Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab2">Completed Events</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="tab1">
                <div class="d-flex  align-items-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8">
                            <div class="container-fluid"> <!-- Changed container to container-fluid for full width -->
                            <div class="card shadow-lg p-4" style="    width: 1000px;
    background-color: #87cefa;
    margin-left: -164px;
">
    <!-- Form -->
    <form action="{{ route('events_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Row 1: Event Name, Activity Level, Multiple District, District, Club -->
            <div class="col-md-3 mb-3">
                <label class="form-label">Event Name</label>
                <input type="text" class="form-control" name="event_name" placeholder="Enter event name" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Activity Level</label>
                <input type="text" class="form-control" name="activity_level" placeholder="Enter activity level" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Multiple District</label>
                <select name="multiple_district_id" class="form-control" required>
                    <option value="">Select Multiple District</option>
                    @foreach($multipleDistricts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">District</label>
                <select name="district_id" class="form-control" required>
                    <option value="">Select District</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Club</label>
                <select name="club_id" class="form-control" required>
                    <option value="">Select Club</option>
                    @foreach($clubs as $club)
                        <option value="{{ $club->id }}">{{ $club->chapter_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Row 2: Creator, Activity Duration, Start Date, End Date, Activity Type -->
            <div class="col-md-3 mb-3">
                <label class="form-label">Creator</label>
                <input type="text" class="form-control" name="creator" placeholder="Enter creator name" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Activity Duration</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" name="activity_duration" value="Single Day" class="form-check-input" required> 
                    <label class="form-check-label">Single Day</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="activity_duration" value="Multiple Day" class="form-check-input">
                    <label class="form-check-label">Multiple Day</label>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" required>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Activity Type</label>
                <select name="activity_type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="Service Activity">Service Activity</option>
                    <option value="Fundraiser">Fundraiser</option>
                    <option value="Meeting">Meeting</option>
                    <option value="Donation">Donation</option>
                </select>
            </div>

            <!-- Row 3: Cause, Total Volunteers, Description, Upload Event Image -->
            <div class="col-md-3 mb-3">
                <label class="form-label">Cause</label>
                <select name="cause" class="form-control" required>
                    <option value="">Select Cause</option>
                    <option value="Honor">Honor</option>
                    <option value="Environment">Environment</option>
                    <option value="Childhood Cancer">Childhood Cancer</option>
                    <option value="Diabetics">Diabetics</option>
                    <option value="Vision">Vision</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Total Volunteers</label>
                <input type="number" class="form-control" name="total_volunteers" placeholder="Enter total volunteers" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter description" rows="3" required></textarea>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Upload Event Image</label>
                <input type="file" class="form-control" name="event_invitation" accept="image/*">
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


</div>




                                <!-- Table for Displaying Stored Events -->
                                <div class="card shadow-lg p-4 mt-4" style="width: 153%; margin-left: -170px;">
                                    <h5 class="text-center custom-heading">Events List</h5>
                                    <div class="table-responsive">
                                        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
                                            <thead style="background-color:#003366 !important;">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Event Name</th>
                                                    <th>Event Date</th>
                                                    <th>Invitation</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($events as $event)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ Str::title($event->event_name) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @php
                                                            $imagePath = 'event_invitations/' . $event->event_invitation;
                                                            $defaultImage = 'event_invitations/default-invitation.png'; // must be in storage/app/public/event_invitations

                                                            // Decide which image to use
                                                            if ($event->event_invitation && Storage::disk('public')->exists($imagePath)) {
                                                                $imageToShow = asset('storage/app/public/' . $imagePath);
                                                            } else {
                                                                $imageToShow = asset('storage/app/public/' . $defaultImage);
                                                            }
                                                        @endphp

                                                        <img src="{{ $imageToShow }}" alt="Invitation" width="100">
                                                    </td>


                                                  <td>
    <!-- Edit Button -->
    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> <!-- Edit icon -->
    </a>

    <!-- Delete Form with SweetAlert -->
    <form id="delete-form-{{ $event->id }}" action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $event->id }})">
            <i class="fas fa-trash"></i><!-- Trash icon -->
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
            </div>

            <!-- completed event form  -->
            <div class="tab-pane fade" id="tab2">
                <div class="container mt-1">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <div class="card shadow-lg p-4 card1">
                                <h4 class="mb-4 text-center">Completed Events</h4>

                                <!-- Event Form -->
                                <form action="{{ route('store_completed_event') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="eventSelect" class="form-label" style="font-size:16px;">Select Event</label><br>
                                            <select class="form-select" name="event_id" id="eventSelect" style="font-size:12px; width: 100%;" data-placeholder="Search & Select Event">
                                                <option value="" disabled selected>-- Select an Event --</option>
                                                @foreach(\App\Models\Event::where('event_date', '<', now())->latest()->get() as $event)
                                                    <option value="{{ $event->id }}">
                                                        {{ $event->event_name }} - {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="venue" class="form-label" style="font-size:16px;">Event Venue</label>
                                            <input type="text" class="form-control" style="font-size:14px;" name="venue" id="venue" placeholder="Enter Event Venue" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="details" class="form-label" style="font-size:16px;">Event Details</label>
                                            <textarea class="form-control" style="font-size:14px;"  name="details" id="details" rows="4" placeholder="Enter Event Details" required></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" style="font-size:16px;">Add Photos (Max 3)</label>
                                            <input type="file" class="form-control" style="font-size:14px;"  name="images[]" multiple accept="image/*" id="imageUpload" onchange="validateImages()" required>
                                            <small class="text-danger" id="imageError"></small>
                                        </div>
                                    </div>

                                    <script>
                                        function validateImages() {
                                            let input = document.getElementById('imageUpload');
                                            let errorMsg = document.getElementById('imageError');

                                            if (input.files.length > 3) {
                                                errorMsg.textContent = "You can upload a maximum of 3 images.";
                                                input.value = ""; // Clear the input field
                                            } else {
                                                errorMsg.textContent = ""; // Clear error message if valid
                                            }
                                        }
                                    </script>

<div class="d-flex justify-content-center mt-3">
    <button type="submit" class="btn custom-btn w-40 upload">Submit</button>
</div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- View Table -->
                   <!-- View Table -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-lg p-4">
            <h4 class="text-center mb-4 custom-heading">Completed Events List</h4>
            <div class="table-responsive">
            <table id="completedEventsTable" class="table table-bordered table-striped dt-responsive nowrap" style="width: 100%;">
    <thead style="background-color:#003366;">
        <tr>
            <th></th> <!-- Plus icon column -->
            <th class="all">S.No</th>
            <th class="all">Event Name</th>
            <th class="none">Venue</th>
            <th class="none" style="width:100px;">Details</th>
            <th class="none">Images</th>
            <th class="none">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($completedEvents as $index => $event)
        <tr>
            <td></td>
            <td>{{ $index + 1 }}</td>
            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: wrap;">
                {{ Str::title($event->event->event_name ?? 'N/A') }}
            </td>

            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $event->venue }}">
                {{ Str::title($event->venue) }}
            </td>
                        <td>
                <div class="question-column" onclick="toggleAsk(this, {{ $event->id }})">
                    {{ Str::title($event->details) }}
                </div>
            </td>
            <td>
                @php
                    $images = is_string($event->images) ? json_decode($event->images, true) : $event->images;
                @endphp
                @if(is_array($images) && !empty($images))
                    @foreach($images as $image)
                        <img src="{{ asset('storage/app/public/' . $image) }}" alt="Event Image" width="60" class="m-1 zoom-image">
                    @endforeach
                @else
                    <span>No images</span>
                @endif
            </td>
            <td>
                <form id="delete-form-{{ $event->id }}" action="{{ route('completed-events.delete', $event->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $event->id }})">
                        <i class="fas fa-trash"></i>
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>
            let previousExpanded = null; // Track the previously expanded row

            function toggleAsk(element, eventId) {
                // If there is a previously expanded row and it's not the current one, collapse it
                if (previousExpanded && previousExpanded !== element) {
                    previousExpanded.classList.remove('expanded');
                }

                // Toggle the current row's expanded state
                element.classList.toggle('expanded');

                // Update the previousExpanded variable to the current element
                previousExpanded = element.classList.contains('expanded') ? element : null;
            }
        </script>


      <!-- SweetAlert CDN -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- Required Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>



        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("imageUpload").addEventListener("change", function(event) {
                    const previewContainer = document.getElementById("imagePreview");
                    const files = event.target.files;
                    previewContainer.innerHTML = "";

                    if (files.length > 3) {
                        document.getElementById("imageLimitMsg").classList.remove("d-none");
                        event.target.value = "";
                        return;
                    } else {
                        document.getElementById("imageLimitMsg").classList.add("d-none");
                    }

                    Array.from(files).forEach(file => {
                        const imgElement = document.createElement("img");
                        imgElement.src = URL.createObjectURL(file);
                        previewContainer.appendChild(imgElement);
                    });
                });

                const dateInput = document.getElementById("eventDate");
                const today = new Date().toISOString().split("T")[0];
                dateInput.setAttribute("min", today);
            });
        </script>
<script>
    function confirmDelete(eventId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'custom-confirm-btn',
                cancelButton: 'custom-cancel-btn'
            },
            didOpen: () => {
                const confirmBtn = document.querySelector('.custom-confirm-btn');
                const cancelBtn = document.querySelector('.custom-cancel-btn');

                // Set initial gradient styles
                confirmBtn.style.background = 'linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%)';
                confirmBtn.style.border = 'none';
                confirmBtn.style.color = '#fff';

                cancelBtn.style.background = 'linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%)';
                cancelBtn.style.border = 'none';
                cancelBtn.style.color = '#fff';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${eventId}`).submit();
            }
        });
    }
</script>

<style>
/* Smooth animation */
.custom-cancel-btn {
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* On hover, change to solid gray */
.custom-cancel-btn:hover {
    background: #777575 !important;
    transform: scale(1.05);
}
</style>



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
        function initResponsiveTable() {
            const isMobile = window.innerWidth <= 768;

            $('#completedEventsTable').DataTable({
                destroy: true,
                responsive: isMobile ? {
                    details: {
                        type: 'column',
                        target: 0 // First column shows "+"
                    }
                } : false,
                columnDefs: isMobile ? [
                    { className: 'control', orderable: false, targets: 0 }, // '+' icon
                    { targets: [0, 1], visible: true }, // Show S.No and Event Name
                    { targets: '_all', visible: true } // All visible; responsive will collapse rest
                ] : [
                    { targets: 0, visible: false } // Hide the plus icon on desktop
                ],
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: false,
                info: true,
                pageLength: 10
            });
        }

        $(document).ready(function () {
            initResponsiveTable();

            $(window).on('resize', function () {
                $('#completedEventsTable').DataTable().destroy();
                initResponsiveTable();
            });
        });
    </script>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eventDateInput = document.getElementById('eventDate');
        const today = new Date();
        // Set to tomorrow
        today.setDate(today.getDate() + 1);
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const minDate = `${yyyy}-${mm}-${dd}`;
        eventDateInput.min = minDate;
    });
</script>


<script>
    $(document).ready(function() {
        $('#eventSelect').select2({
            placeholder: $('#eventSelect').data('placeholder'),
            allowClear: true
        });

        // Add placeholder inside the search box
        $('#eventSelect').on('select2:open', function () {
            setTimeout(function () {
                $('.select2-container--open .select2-search__field').attr('placeholder', 'Search for an event...');
            }, 0);
        });
    });
</script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required by Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    // Auto fade up and remove the alert
    setTimeout(() => {
        const alertBox = document.querySelector('.alert');
        if(alertBox) {
            alertBox.classList.remove('show');
            alertBox.classList.add('fade');
            setTimeout(() => {
                alertBox.remove();
            }, 500); // remove after fade-out
        }
    }, 3000); // show for 3 seconds
</script>

        @endsection
