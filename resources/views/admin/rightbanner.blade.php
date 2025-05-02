

<style>
    .banner-img-container {
    position: relative;
    display: inline-block;
}

.banner-img {
    width: 100px; /* Initial size */
    height: auto;
    transition: transform 0.3s ease-in-out;
}

.banner-img-container:hover .banner-img {
    transform: scale(1.5); /* Zoom out */

}

/* Apply box shadow to tables */
#table-image1, #table-image2, #table-image3 {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Apply soft box-shadow */
    border-radius: 5px; /* Optional: Add rounded corners */
    overflow: hidden;
}

/* Push search and length dropdowns down a little */
.dataTables_length, .dataTables_filter {
    margin-top: 0.5rem; /* Adjust as needed */
}

/* Alternating row colors */
#table-image1 tbody tr:nth-child(odd),
#table-image2 tbody tr:nth-child(odd),
#table-image3 tbody tr:nth-child(odd) {
    background-color: #F0F8FF; /* Alice Blue */
}

#table-image1 tbody tr:nth-child(even),
#table-image2 tbody tr:nth-child(even),
#table-image3 tbody tr:nth-child(even) {
    background-color: #B9D9EB; /* Soft pastel blue */
}

/* Padding and border for table cells */
#table-image1 td, #table-image2 td, #table-image3 td {
    padding: 10px;
    border-color: #ddd;
}



</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var activeTab = "{{ session('activeTab') }}";
        if (activeTab) {
            var tabElement = new bootstrap.Tab(document.querySelector('[href="#' + activeTab + '"]'));
            tabElement.show();
        }
    });
</script>


@php
    $images = [
        ['title' => 'Upload Right Ad 1', 'route' => 'upload.image1'],
        ['title' => 'Upload Right Ad 2', 'route' => 'upload.image2'],
        ['title' => 'Upload Right Ad 3', 'route' => 'upload.image3'],
    ];
@endphp

<div class="row">
    @foreach ($images as $image)
        <div class="col-md-4">
            <div class="card mb-4" style="background-color: #87cefa;">
                <div class="card-body">
                    <h5 class="card-title  text-center">{{ $image['title'] }}</h5>
                    <form action="{{ route($image['route']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="rightbanner" value="{{ $image['title'] }}">
                       
                        <input type="file" name="image" required class="form-control">
                        <small style="font-size: 12px;">Note: Ad size should be (400x300)px</small>
                        <label class="mt-2">Enter Website Link*</label>
                        <input type="text" name="website_link" required class="form-control mt-1" placeholder="Enter Website Link">
                        <div class="text-center">
    <button type="submit" class="btn w-40 mt-3 text-white"
        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5%;">
       Upload
    </button>
</div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>




<div class="overflow-auto">
    <ul class="nav nav-tabs mt-4 flex-nowrap d-flex" id="imageTabs" role="tablist" style="white-space: nowrap;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="image1-tab" data-bs-toggle="tab" data-bs-target="#image1" type="button" role="tab">
          Right Ad 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="image2-tab" data-bs-toggle="tab" data-bs-target="#image2" type="button" role="tab">
            Right Ad 2
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="image3-tab" data-bs-toggle="tab" data-bs-target="#image3" type="button" role="tab">
          Right Ad 3
            </button>
        </li>
    </ul>
</div>


<div class="tab-content mt-3" id="imageTabsContent">
 <!-- Image 1 Tab -->
<div class="tab-pane fade show active" id="image1" role="tabpanel">
    <div class="card">
           <!-- Card Header with Gradient Background -->
           <div class="card-header text-white text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
            <h5 class="mb-0 text-white">Right Ad 1 List</h5>
        </div>
        <br><br>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-image1">
                    <thead>
                        <tr>
                            <th style="color: white; text-align: center;">S.No</th>
                            <th style="color: white; text-align: center;">Image</th>
                            <th style="color: white; text-align: center;">Website Link</th>
                            <th style="color: white; text-align: center;">Date & Time</th>
                            <th style="color: white; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($image1 as $index => $img)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="banner-img-container">
                                    <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                                </div>
                            </td>

                            <td style="max-width: 200px; word-break: break-word; white-space: normal;">
    <a href="{{ $img->website_link }}" target="_blank" title="{{ $img->website_link }}">
        {{ $img->website_link }}
    </a>
</td>


                            <td class="text-center">
                                {{  $img->created_at ? \Carbon\Carbon::parse( $img->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                            </td>

                            <td>
                                <form action="{{ route('delete.image1', $img->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 1">
                                        <i class="fas fa-trash"></i>
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
</div>


<!-- Image 2 Tab -->
<div class="tab-pane fade" id="image2" role="tabpanel">
    <div class="card">
         <!-- Card Header with Gradient Background -->
         <div class="card-header text-white text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
            <h5 class="mb-0 text-white">Right Ad 2  List</h5>
        </div>
        <br><br>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-image2">
                    <thead>
                        <tr>
                            <th style="color: white; text-align: center;">S.No</th>
                            <th style="color: white; text-align: center;">Image</th>
                            <th style="color: white; text-align: center;">Website Link</th>
                            <th style="color: white; text-align: center;">Date & Time</th>
                            <th style="color: white; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($image2 as $index => $img)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="banner-img-container">
                                    <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                                </div>
                            </td>
                            <td style="max-width: 200px; word-break: break-word; white-space: normal;">
                            <a href="{{ $img->website_link  }}" target="_blank" title="{{ $img->website_link }}">
                                    {{ $img->website_link }}
                                </a>
                            </td>

                            <td class="text-center">
                                {{  $img->created_at ? \Carbon\Carbon::parse( $img->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                            </td>

                            <td>
                                <form action="{{ route('delete.image2', $img->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 2">
                                        <i class="fas fa-trash"></i>
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
</div>

<!-- Image 3 Tab -->
<div class="tab-pane fade" id="image3" role="tabpanel">
    <div class="card">
           <!-- Card Header with Gradient Background -->
           <div class="card-header text-white text-center" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5);">
            <h5 class="mb-0 text-white">Right Ad 3  List</h5>
        </div>
        <br><br>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-image3">
                    <thead>
                        <tr>
                            <th style="color: white; text-align: center;">S.No</th>
                            <th style="color: white; text-align: center;">Image</th>
                            <th style="color: white; text-align: center;">Website Link</th>
                            <th style="color: white; text-align: center;">Date & Time</th>
                            <th style="color: white; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($image3 as $index => $img)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="banner-img-container">
                                    <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                                </div>
                            </td>
                            <td style="max-width: 200px; word-break: break-word; white-space: normal;">
                                <a href="{{ $img->website_link  }}" target="_blank" title="{{ $img->website_link }}">
                                    {{ $img->website_link }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{  $img->created_at ? \Carbon\Carbon::parse( $img->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                            </td>
                            <td>
                                <form action="{{ route('delete.image3', $img->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 3">
                                        <i class="fas fa-trash"></i>
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
</div>

</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default form submission

            const form = this.closest('form');
            const imageName = this.getAttribute('data-name');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${imageName}. This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');
            const imageName = this.getAttribute('data-name') || 'this image';

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${imageName}. This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>



<script>
    $(document).ready(function () {
        $('#table-image1,#table-image2,#table-image3').DataTable({
            "pageLength": 10,
            "ordering": false,
            "searching": true,
            "lengthChange": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100]
        });
    });
    </script>


@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
