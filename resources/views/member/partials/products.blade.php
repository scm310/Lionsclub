
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
    <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="product-wrapper">
            <div class="row product-entry">
                <div class="col-md-4">
                    <label>Product Name</label>
                    <input type="text" name="product_name[]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Product Image</label>
                    <input type="file" name="product_image[]" class="form-control">
                </div>
                {{-- <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div> --}}
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="button" class="btn custom-btn w-40 upload" onclick="addMoreProduct()" >+ Add More</button>
            <button type="submit" class="btn custom-btn w-40 upload">Save and Next</button>
        </div>
        
    </form>
</div>

<script>
  function addMoreProduct() {
    const wrapper = document.getElementById('product-wrapper'); // Corrected container ID
    const entry = document.createElement('div');
    entry.className = 'row product-entry';
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
    wrapper.appendChild(entry); // Append new row to the wrapper
  }

  function removeProduct(element) {
    element.closest('.product-entry').remove(); // Remove the product entry row
  }
</script>

