@extends('MasterAdmin.layout')
<style>

    /* Custom styles for the SweetAlert2 popup */
.small-popup {
    width: 400px !important;   /* Set the width of the popup */
    height: auto !important;    /* Set height to auto */
    padding: 20px !important;   /* Padding inside the popup */
}

/* Adjust the title size */
.small-title {
    font-size: 18px !important;  /* Reduce the font size of the title */
    text-align: center; /* Center the title text */
}

/* Adjust the content size */
.small-content {
    font-size: 14px !important;  /* Smaller font size for the content */
    padding: 10px !important;    /* Padding for content */
}

/* Adjust the size of the buttons */
.small-button {
    padding: 8px 16px !important;  /* Smaller padding for buttons */
    font-size: 14px !important;    /* Smaller font size for buttons */
    margin: 5px; /* Space between the buttons */
}

    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 25%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }


    /* #submit,#add {
        border-radius: 24px;
        width: 70px;

    } */

    th,td {
    text-transform: capitalize!important; /* Ensures each word is capitalized */
}


.btn-close{
    margin-right: 13px !important;
    margin-top: -1px !important;
}

.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}

.table th{
    color: white !important;
    background-color:#003366 !important;
    font-size: 15px !important;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white; /* Ensures text is readable */
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px; /* Optional rounded edges */
    display: inline-block; /* Adjusts width to fit content */
    width: 100%; /* Ensures it spans across the container */
}

.card-header{
    font-size:20px;
}


  /* Push search and length dropdown down a little */
  .dataTables_length,
    .dataTables_filter {
        margin-top: 0.5rem; /* Adjust as needed */
    }
    #imageTable1 tbody tr:nth-child(odd) {
        background-color: #F0F8FF; /* Alice Blue */
    }

    #imageTable1 tbody tr:nth-child(even) {
        background-color: #B9D9EB; /* Soft pastel blue */
    }

    #imageTable1 td {
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



@media (max-width: 767.98px) {
    .dataTables_length {
      
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
    }
}
@media (max-width: 767.98px) {
    .delete-btn {
        z-index: 10;
        position: relative;
    }


    #imageTable1 td{
        padding: 28px;
    }
}


</style>


@section('content')
<!-- Button to trigger the modal -->

<div class="container mt-4">

    <div class="white-container">

        <h3 class="mb-3 custom-heading">Membership Awards</h3>
        <div class="d-flex justify-content-end" style="margin-bottom: 5px;">
    <button type="button" class="btn custom-btn"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%; color:#fff;"
        data-bs-toggle="modal" data-bs-target="#addAwardModal">
        + Add Award
    </button>
</div>



        @include('admin.partial.alerts')

    <!-- Membership Award Form -->
    <div class="card mb-4" style="background-color:#87cefa;">
    <div class="d-flex flex-column flex-md-row justify-content-end align-items-start align-items-md-center p-3">
        
    </div>


        <div class="card-body">
            <form action="{{ route('membership.awards.storeMembershipAward') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                    <label for="name" class="form-label fw-bold">Member Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Enter the Name">
                    </div>

                    <div class="col-md-3">
                        <label for="award" class="form-label fw-bold">Award</label>
                        <select class="form-control" id="award" name="awards_id" required>
                            <option value="">Select Award</option>
                            @foreach($awards as $award)
                            <option value="{{ $award->id }}">{{ $award->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="chapter" class="form-label fw-bold">Club</label>
                        <select class="form-control" id="chapter" name="chapter_id" required>
                            <option value="">Select Club</option>
                            @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}">{{ $chapter->chapter_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2  mt-4">
                        <button type="submit" id="submit"   style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%; color:#fff;" class="btn custom-btn">Save</button>
                    </div>
                </div>

      
            </form>
        </div>

    </div>


  <!-- Modal for Adding New Award -->
<div class="modal fade" id="addAwardModal" tabindex="-1" aria-labelledby="addAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #87cefa;">
            <div class="modal-header">
                <h5 class="modal-title" id="addAwardModalLabel">Add New Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('membership.awards.storeAward') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="awardName" class="form-label">Award Name</label>
                        <input type="text" class="form-control" id="awardName" name="name" required>
                    </div>
                    <div style="text-align: center;">
    <button type="submit" id="submit"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%; color: #fff;"
        class="btn custom-btn">
        Save Award
    </button>
</div>

                </form>
            </div>
        </div>
    </div>
</div>



   <!-- Display Membership Award Records -->
<div class="card">
<div class="card-header text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white;">
    Membership Award List
</div>


    <div class="card-body">
        <table id="imageTable1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Member Name</th>
                    <th>Award</th>
                    <th>Club</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    @foreach($records as $record)
    <tr>
        <td>{{ $loop->iteration }}</td> <!-- Serial Number -->
        <td>{{ $record->name }}</td>
        <td>{{ $record->award->name }}</td>

        <!-- Check if the chapter relationship exists -->
        <td>{{ $record->chapter ? $record->chapter->chapter_name : 'No Chapter' }}</td>

        <td>
            <!-- Delete Button -->
            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $record->id }}" data-title="{{ $record->name }}">
                <i class="fas fa-trash"></i> <!-- Trash icon -->
            </button>
        </td>
    </tr>
    @endforeach
</tbody>

        </table>
    </div>
</div>


</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).on('click', '.delete-btn', function () {
    const button = $(this);
    const recordId = button.data("id");
    const recordTitle = button.data("title");

    Swal.fire({
        title: "Are you sure?",
        text: `You are about to delete the membership award record: "${recordTitle}"`,
        icon: "warning",
        showCancelButton: true,
       
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        customClass: {
        confirmButton: 'swal2-confirm',
        cancelButton: 'swal2-cancel'
    }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/membership-awards/${recordId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Deleted!",
                        text: data.success,
                        icon: "success",
                        confirmButtonColor: "#28a745"
                    }).then(() => {
                        // ✅ Refresh the page after success
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.error || "There was an error deleting the record.",
                        icon: "error",
                        confirmButtonColor: "#dc3545"
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error!",
                    text: "There was an error processing your request.",
                    icon: "error",
                    confirmButtonColor: "#dc3545"
                });
            });
        }
    });
});
</script>



<script>
    $(document).ready(function () {
        $('#imageTable1').DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            pageLength: 10,
            dom: '<"row align-items-center mb-3"<"col-md-6"l><"col-md-6 text-end"f>>rt<"row"<"col-md-5"i><"col-md-7"p>>'
        });
    });
</script>



@endsection
