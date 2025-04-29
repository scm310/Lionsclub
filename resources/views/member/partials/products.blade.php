<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
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
</style>

<div class="form-section">

    {{-- ✅ Existing Products --}}
    @foreach($products as $product)
        <form action="{{ route('update.product', $product->id) }}" method="POST" enctype="multipart/form-data" class="mb-3 d-flex align-items-end">
            @csrf
            @method('PUT')
            <div class="row w-100">
                <div class="col-md-4">
                    <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
                </div>
                <div class="col-md-4">
                    <input type="file" name="product_image" class="form-control">
                    @if ($product->product_image)
                        <small class="text-muted">Current: {{ $product->product_image }}</small>
                    @endif
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm custom-btn">Update</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('delete.product', $product->id) }}" class="btn btn-sm btn-danger" id="delete-product-{{ $product->id }}">
                        Delete
                    </a>
                </div>
            </div>
        </form>
    @endforeach

    {{-- ✅ New Product Form --}}
    <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="product-wrapper">
            <div class="row product-entry mb-3">
                <div class="col-md-4">
                    <label>Product Name</label>
                    <input type="text" name="product_name[]" class="form-control" placeholder="Enter product name" required>
                </div>
                <div class="col-md-4">
                    <label>Product Image</label>
                    <input type="file" name="product_image[]" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="button" class="btn custom-btn me-2" onclick="addMoreProduct()">+ Add More</button>
            <button type="submit" class="btn custom-btn">Save and Next</button>
        </div>
    </form>

</div>

{{-- ✅ JavaScript --}}
<script>
    function addMoreProduct() {
        const wrapper = document.getElementById('product-wrapper');
        const entry = document.createElement('div');
        entry.className = 'row product-entry mb-3';
        entry.innerHTML = `
            <div class="col-md-4">
                <label>Product Name</label>
                <input type="text" name="product_name[]" class="form-control" placeholder="Enter product name" required>
            </div>
            <div class="col-md-4">
                <label>Product Image</label>
                <input type="file" name="product_image[]" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        `;
        wrapper.appendChild(entry);
    }

    function removeProduct(element) {
        element.closest('.product-entry').remove();
    }

    // Add SweetAlert confirmation for delete button
    document.querySelectorAll('[id^="delete-product-"]').forEach(function (deleteButton) {
        deleteButton.addEventListener('click', function (e) {
            e.preventDefault();  // Prevent default link behavior

            const deleteUrl = deleteButton.getAttribute('href');  // Get the URL for the delete action

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
    });
</script>
