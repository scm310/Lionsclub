<div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $savedTestimonials = \App\Models\Testimonial::where('member_id', Auth::guard('member')->id())->get();
        @endphp

<form action="{{ route('member.testimonials.store') }}"  method="POST" enctype="multipart/form-data">
    @csrf
    <div id="testimonial-wrapper">
        @forelse($testimonials as $index => $testimonial)
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

            <!-- Second Row (Testimonial + Image + Remove) -->
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
                @if(!empty($testimonial->id))
                <form action="{{ route('member.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>


                @else
                    <button type="button" class="btn btn-danger mt-4 remove-btn">Remove</button>
                @endif
            </div>
        @empty
            <div class="mt-3">
                <input type="hidden" name="testimonial_id[]" value="">
                <div class="row mb-3 mt-1">
                    <div class="col-md-3"><label>Client Name</label><input type="text" name="client_name[]" class="form-control"></div>
                    <div class="col-md-3"><label>Company Name</label><input type="text" name="company_name[]" class="form-control"></div>
                    <div class="col-md-3"><label>Upload Image</label><input type="file" name="image[]" class="form-control"></div>
                    <div class="col-md-3"><label>Designation</label><input type="text" name="designation[]" class="form-control"></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-10"><label>Testimonial</label><textarea name="testimonial[]" class="form-control" rows="3"></textarea></div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger mt-4 remove-btn">Remove</button>
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

    <script>
        document.getElementById('add-more').addEventListener('click', function () {
            const wrapper = document.getElementById('testimonial-wrapper');
            const newField = `
               
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
                            <button type="button" class="btn btn-danger mt-4 remove-btn">Remove</button>
                        </div>
                
                </div>`;
            wrapper.insertAdjacentHTML('beforeend', newField);
        });

        $(document).on('click', '.remove-btn', function () {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        $(this).closest('.testimonial-row').remove();  // Removes the testimonial row from the DOM
    }
});



$(document).on('click', '.remove-btn', function () {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        $(this).closest('.testimonial-row').remove();
    }
});

    </script>