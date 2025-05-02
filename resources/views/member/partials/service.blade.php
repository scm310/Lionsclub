{{-- Display existing services --}}
@foreach($services as $service)
    <form action="{{ route('service.update', $service->id) }}" method="POST" class="mb-3 d-flex align-items-end" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row w-100">
            <div class="col-md-3">
                <input type="text" name="service_name" class="form-control" value="{{ $service->service_name }}">
            </div>
            <div class="col-md-3">
              
                <input type="file" name="image" class="form-control mt-1">
                @if($service->image)
                    <img src="{{ asset('storage/app/public/' . $service->image) }}" width="60" height="60">
                @endif
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-sm text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Update</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('service.delete', $service->id) }}" class="btn btn-sm btn-danger" onclick="return confirmDelete(event)">Delete</a>
            </div>
        </div>
    </form>
@endforeach


{{-- New Service Form --}}
<form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="serviceFields">
        <div class="row serviceRow mb-3">
            <div class="col-md-3">
                <input type="text" name="service_name[]" class="form-control" placeholder="Service Name" required>
            </div>
            <div class="col-md-3">
                <input type="file" name="image[]" class="form-control" accept="image/*">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeService">Delete</button>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="button" class="btn text-white me-2" id="addService" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Add More</button>
        <button type="submit" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Submit</button>
    </div>
</form>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add new service row
    document.getElementById('addService').addEventListener('click', function () {
        let fieldHTML = `
            <div class="row serviceRow mb-3">
                <div class="col-md-3">
                    <input type="text" name="service_name[]" class="form-control" placeholder="Service Name" required>
                </div>
                <div class="col-md-4">
                    <input type="file" name="image[]" class="form-control" accept="image/*">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeService">Delete</button>
                </div>
            </div>`;
        document.getElementById('serviceFields').insertAdjacentHTML('beforeend', fieldHTML);
    });

    // Remove service row
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeService')) {
            e.target.closest('.serviceRow').remove();
        }
    });
});
</script>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(event) {
    event.preventDefault(); // Prevent the default link behavior (the delete request)
    
    // SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, navigate to the delete route
            window.location.href = event.target.href;
        }
    });
}
</script>
