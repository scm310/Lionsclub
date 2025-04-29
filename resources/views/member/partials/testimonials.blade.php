<div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
    <form action="{{ route('member.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="testimonial-wrapper">
            @forelse($testimonials as $index => $testimonial)
                <div class="testimonial-row mt-3">
                    <input type="hidden" name="testimonial_id[]" value="{{ $testimonial->id }}">

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Client Name</label>
                            <input type="text" name="client_name[]" class="form-control" value="{{ $testimonial->client_name ?? '' }}" placeholder="Client Name" required>
                        </div>
                        <div class="col-md-3">
                            <label>Company Name</label>
                            <input type="text" name="company_name[]" class="form-control" value="{{ $testimonial->company_name ?? '' }}" placeholder="Company Name" required>
                        </div>
                        <div class="col-md-3">
                            <label>Upload Image</label>
                            <input type="file" name="image[]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Designation</label>
                            <input type="text" name="designation[]" class="form-control" value="{{ $testimonial->designation ?? '' }}" placeholder="Designation" required>
                        </div>
                    </div>

                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label>Testimonial</label>
                            <textarea name="testimonial[]" class="form-control" rows="3" placeholder="Write testimonial..." required>{{ $testimonial->testimonial ?? '' }}</textarea>
                        </div>
                        <div class="col-md-3">
                            @if(!empty($testimonial->image))
                                <img src="{{ asset('storage/app/public/' . $testimonial->image) }}" width="80" class="mt-2">
                            @endif
                        </div>
                        <div class="col-md-3 text-end mt-2">
                            @if(!empty($testimonial->id))
                                <!-- Updated delete button to use SweetAlert2 -->
                                <a href="{{ route('member.testimonials.destroy', $testimonial->id) }}" 
                                   class="btn btn-danger btn-sm delete-testimonial-btn">
                                    Delete
                                </a>
                            @else
                                <button type="button" class="btn btn-danger remove-btn mt-4">Remove</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="testimonial-row mt-3">
                    <input type="hidden" name="testimonial_id[]" value="">
                    <div class="row mb-3">
                        <div class="col-md-3"><label>Client Name</label><input type="text" name="client_name[]" class="form-control"></div>
                        <div class="col-md-3"><label>Company Name</label><input type="text" name="company_name[]" class="form-control"></div>
                        <div class="col-md-3"><label>Upload Image</label><input type="file" name="image[]" class="form-control"></div>
                        <div class="col-md-3"><label>Designation</label><input type="text" name="designation[]" class="form-control"></div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-10"><label>Testimonial</label><textarea name="testimonial[]" class="form-control" rows="3"></textarea></div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger remove-btn mt-4">Remove</button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-3">
            <button type="button" id="add-more" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">
                Add More
            </button>
            <button type="submit" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">
                Save Testimonials
            </button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Add More Fields
    document.getElementById('add-more').addEventListener('click', function () {
        const wrapper = document.getElementById('testimonial-wrapper');
        const newField = `
            <div class="testimonial-row mt-3">
                <input type="hidden" name="testimonial_id[]" value="">
                <div class="row mb-3">
                    <div class="col-md-3"><label>Client Name</label><input type="text" name="client_name[]" class="form-control"></div>
                    <div class="col-md-3"><label>Company Name</label><input type="text" name="company_name[]" class="form-control"></div>
                    <div class="col-md-3"><label>Upload Image</label><input type="file" name="image[]" class="form-control"></div>
                    <div class="col-md-3"><label>Designation</label><input type="text" name="designation[]" class="form-control"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-10"><label>Testimonial</label><textarea name="testimonial[]" class="form-control" rows="3"></textarea></div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger remove-btn mt-4">Remove</button>
                    </div>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', newField);
    });

    // Remove testimonial (local remove)
    $(document).on('click', '.remove-btn', function () {
        if (confirm('Are you sure you want to delete this testimonial?')) {
            $(this).closest('.testimonial-row').remove();
        }
    });

    // SweetAlert2 delete confirmation for testimonial deletion
    $(document).on('click', '.delete-testimonial-btn', function (e) {
        e.preventDefault(); // Prevent the default link behavior
        
        const deleteUrl = $(this).attr('href');  // Get the delete URL
        
        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete URL if confirmed
                window.location.href = deleteUrl;
            }
        });
    });
</script>
