{{-- Display existing clients --}}
@foreach($clients as $client)
    <form action="{{ route('client.update', $client->id) }}" method="POST" class="mb-3 d-flex align-items-end">
        @csrf
        @method('PUT')
        <div class="row w-100">
            <div class="col-md-2"><input type="text" name="client_name" class="form-control" value="{{ $client->client_name }}"></div>
            <div class="col-md-2"><input type="text" name="company_name" class="form-control" value="{{ $client->company_name }}"></div>
            <div class="col-md-3"><input type="text" name="comapny_fullform" class="form-control" value="{{ $client->comapny_fullform }}"></div>
            <div class="col-md-3"><input type="text" name="designation" class="form-control" value="{{ $client->designation }}"></div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-sm text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Update</button>
            </div>
            <div class="col-md-1">
            <a href="{{ route('client.delete', $client->id) }}" class="btn btn-sm btn-danger" onclick="return confirmDelete(event)">Delete</a>
            </div>
        </div>
    </form>
@endforeach

{{-- New Clients Form --}}
<form action="{{ route('client.store') }}" method="POST">
    @csrf
    <div id="clientFields">
        <div class="row clientRow mb-3">
            <div class="col-md-2"><input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required></div>
            <div class="col-md-2"><input type="text" name="company_name[]" class="form-control" placeholder="Company Name" required></div>
            <div class="col-md-3"><input type="text" name="comapny_fullform[]" class="form-control" placeholder="Company Full Form" required></div>
            <div class="col-md-3"><input type="text" name="designation[]" class="form-control" placeholder="Designation" required></div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeClient">X</button>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="button" class="btn text-white me-2" id="addClient" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Add More</button>
        <button type="submit" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">Submit</button>
    </div>
</form>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addClient').addEventListener('click', function () {
        let fieldHTML = `
            <div class="row clientRow mb-3">
                <div class="col-md-2"><input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required></div>
                <div class="col-md-2"><input type="text" name="company_name[]" class="form-control" placeholder="Company Name" required></div>
                <div class="col-md-3"><input type="text" name="comapny_fullform[]" class="form-control" placeholder="Company Full Form" required></div>
                <div class="col-md-3"><input type="text" name="designation[]" class="form-control" placeholder="Designation" required></div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeClient">X</button>
                </div>
            </div>`;
        document.getElementById('clientFields').insertAdjacentHTML('beforeend', fieldHTML);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeClient')) {
            e.target.closest('.clientRow').remove();
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