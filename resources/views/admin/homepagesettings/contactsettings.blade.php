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

.fade-message {
    width: 316px;
    margin-left: 362px;
    opacity: 1;
    transition: opacity 1s ease-in-out;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .fade-message {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }
}


/* Mobile responsive */
@media (max-width: 768px) {
    .alert {
        width: 104%; /* or a smaller fixed width like 250px */
        margin-left: auto;
        margin-right: auto;
    }
}

.question-column {
        max-width:  350px;
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
        width:350px;
    }

</style>

<div class="container mt-4 ">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Contact Settings</h3>

        @if(session('success'))
        <div class="alert alert-success fade-message">
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
        var table = $('#imageTable1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "pageLength": 10,
            // Optional: For better mobile support
            "columnDefs": [
                {
                    "targets": -1, // assuming the delete button is in the last column
                    "orderable": false, // Disable ordering for delete button column
                    "searchable": false // Disable search for delete button column
                }
            ]
        });

        // Handling delete button click
        $('#imageTable1').on('click', '.delete-btn', function() {
            var row = $(this).closest('tr'); // Get the closest row
            var rowIndex = table.row(row).index(); // Get the index of the row

            // Show SweetAlert confirmation
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
                    // If confirmed, remove the row from DataTable
                    table.row(row).remove().draw();
                }
            });
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
<script>
    setTimeout(function() {
        const alert = document.querySelector('.fade-message');
        if (alert) {
            alert.style.opacity = '0';
        }
    }, 3000);
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

@endsection
