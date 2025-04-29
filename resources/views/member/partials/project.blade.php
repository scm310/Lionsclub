


<!-- Display Stored Projects -->
<div class="mb-4">
    @foreach($projects as $project)
        <form action="{{ route('project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- First Row -->
            <div class="row">
                <div class="col-md-3">
                    <label>Project Name</label>
                    <input type="text" name="project_name" value="{{ $project->project_name }}" class="form-control mb-2" required>
                </div>
                <div class="col-md-3">
                    <label>Upload New Image</label>
                    <input type="file" name="project_image" class="form-control mb-2">
                </div>
                <div class="col-md-3">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ $project->location }}" class="form-control mb-2">
                </div>
                <div class="col-md-3">
                    <label>Client Name</label>
                    <input type="text" name="client_name" value="{{ $project->client_name }}" class="form-control mb-2">
                </div>
            </div>

            <!-- Second Row -->
            <div class="row">
                <div class="col-md-3">
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="{{ $project->company_name }}" class="form-control mb-2">
                </div>
                <div class="col-md-3">
                    <label>Stored Image</label><br>
                    <img src="{{ asset('storage/app/public/' . $project->project_image) }}" width="100" class="img-thumbnail mb-2" alt="Project Image">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button class="btn text-white btn-sm me-2" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">
                        Update
                    </button>

                    <!-- Updated Delete Button with SweetAlert -->
                    <a href="{{ route('project.delete', $project->id) }}" class="btn btn-danger btn-sm ms-2" onclick="return confirmDelete(event)" style="margin-left: 30px;">Delete</a>
                </div>
            </div>
        </form>
    @endforeach
</div>

<!-- Project Form -->
<form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="projectFields">
        <div class="row projectRow mb-3">
            <div class="col-md-3">
                <label>Project Name</label>
                <input type="text" name="project_name[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Project Image</label>
                <input type="file" name="project_image[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Location</label>
                <input type="text" name="location[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Client Name</label>
                <input type="text" name="client_name[]" class="form-control" required>
            </div>
            <div class="col-md-3 mt-2">
                <label>Company Name</label>
                <input type="text" name="company_name[]" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end mt-2">
                <button type="button" class="btn btn-danger removeRow">X</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 d-flex justify-content-center gap-3 mt-3">
            <button type="button" id="addMore" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;margin-right: 30px;">
                Add More
            </button>
            <button type="submit" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">
                Save Projects
            </button>
        </div>
    </div>
</form>

<script>
// SweetAlert for delete confirmation
function confirmDelete(event) {
    event.preventDefault(); // Prevent the default action (i.e., following the link)
    
    // SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, proceed with the delete by navigating to the link
            window.location.href = event.target.href;
        }
    });
}

document.getElementById('addMore').addEventListener('click', function () {
    const newRow = document.querySelector('.projectRow').cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    document.getElementById('projectFields').appendChild(newRow);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeRow')) {
        const rows = document.querySelectorAll('.projectRow');
        if (rows.length > 1) e.target.closest('.projectRow').remove();
    }
});
</script>
