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
        background-color: #f8f9fa;
        /* Light background */
        color: black;
        padding: 20px;
        /* Adds space inside the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
        width: 100%;
        border-radius: 10px;

        margin-top: -20px;

    }

    .table-responsive th {
        text-align: center !important;
        color: white !important;
    }

    .table-responsive td {
        text-align: center !important;
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

    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
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

    .question-column {
        max-width: 350px;
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
    .question-column.expanded {
        height: auto;
        white-space: normal;
        word-wrap: break-word;
        width: 350px;
    }


    @media screen and (max-width: 768px) {


        .question-column {
            max-width: 280px;
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
        .question-column.expanded {
            height: auto;
            white-space: normal;
            word-wrap: break-word;
            width: 280px;
            text-align: justify;
        }


    .responsive-alert {
        width: 90%;
    }

    #success-alert{
        width:93% !important;
    }

    }
</style>

<div class="container mt-4 ">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Contact Settings</h3>

        @if(session('success'))
        <div id="success-alert" class="alert alert-success text-center mx-auto" style="width: 50%;">
            {{ session('success') }}
        </div>
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
                        <button type="submit" class="custom-btn">Save</button>
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

                        <td style="width: 400px;">
                            <div class="question-column" onclick="toggleAddress(this, {{ $contact->id }})">
                                {{ $contact->address ?? 'No address available' }}
                            </div>
                        </td>

                        <td>{{ $contact->created_at->format('d-m-Y H:i:s') }}</td>


                        <td>
                            <!-- Edit Button -->

                            <!-- Delete Button -->
                            <form action="{{ route('contact.delete', $contact->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-btn">
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
        var table = $('#imageTable1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "pageLength": 10,
            "columnDefs": [{
                "targets": -1,
                "orderable": false,
                "searchable": false
            }]
        });

        // Handle delete button click
        $('#imageTable1').on('click', '.delete-btn', function(e) {
            e.preventDefault(); // Prevent default button behavior

            let form = $(this).closest('form'); // Get the form

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
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit Laravel delete form
                }
            });
        });
    });
</script>





<script>
    let previousExpanded = null; // Track the previously expanded row

    function toggleAddress(element, contactId) {
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


<script>
    setTimeout(function() {
        let alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 500); // Wait for fade out
        }
    }, 3000); // 3 seconds
</script>


@endsection
