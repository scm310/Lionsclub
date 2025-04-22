<div id="editBannerModal" class="modal fade" tabindex="-1" aria-labelledby="editBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateBannerForm"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="banner_id" id="banner_id">
                    <input type="hidden" name="title" id="title">


                    <div class="form-group">
                        <label>Banner Image</label>
                        <img id="bannerPreview" src="" width="100">
                        <input type="file" name="image_path" class="form-control mt-2">
                    </div>

                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" name="url" id="banner_url" class="form-control" placeholder="URL">
                    </div>

                    <div class="form-group">
                        <label>Created At</label>
                        <input type="text" id="created_at" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Updated At</label>
                        <input type="text" id="updated_at" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Edit button click event

        document.querySelectorAll(".edit-btn").forEach(button => {
    button.addEventListener("click", function () {
        const bannerId = this.getAttribute("data-id");
        const title = encodeURIComponent(this.getAttribute("data-title")); // Encode title for URL safety

        console.log(`Fetching Banner - ID: ${bannerId}, Title: ${title}`);

        // Send ID and Title using GET method
        fetch(`/banner/${bannerId}/edit?title=${title}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("updateBannerForm").action = `/banner/update/${bannerId}`;
                document.getElementById("banner_id").value = data.id;
                document.getElementById("bannerPreview").src = "/storage/app/public/" + data.image_path;
                document.getElementById("banner_url").value = data.url;
                document.getElementById("created_at").value = data.created_at;
                document.getElementById("updated_at").value = data.updated_at;
                document.getElementById("title").value = title;

                // Show modal
                $('#editBannerModal').modal('show');
            })
            .catch(error => console.error("Error fetching banner:", error));
    });
});


        // Delete button click event

    // document.querySelectorAll(".delete-btn").forEach(button => {
    //     button.addEventListener("click", function () {
    //         const bannerId = this.getAttribute("data-id");
    //         const bannerTitle = this.getAttribute("data-title");

    //         if (confirm(`Are you sure you want to delete the banner: "${bannerTitle}"?`)) {
    //             fetch(`/banner/delete/${bannerId}`, {
    //                 method: "DELETE",
    //                 headers: {
    //                     "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //                     "Content-Type": "application/json"
    //                 },
    //                 body: JSON.stringify({ title: bannerTitle }) // Send title in request
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 alert(data.success);
    //                 location.reload();
    //             })
    //             .catch(error => console.error("Error deleting banner:", error));
    //         }
    //     });
    // });


    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Edit button click event
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                const bannerId = this.getAttribute("data-id");
                const title = encodeURIComponent(this.getAttribute("data-title")); // Encode title for URL safety

                console.log(`Fetching Banner - ID: ${bannerId}, Title: ${title}`);

                // Send ID and Title using GET method
                fetch(`/banner/${bannerId}/edit?title=${title}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("updateBannerForm").action = `/banner/update/${bannerId}`;
                        document.getElementById("banner_id").value = data.id;
                        document.getElementById("bannerPreview").src = "/storage/app/public/" + data.image_path;
                        document.getElementById("banner_url").value = data.url;
                        document.getElementById("created_at").value = data.created_at;
                        document.getElementById("updated_at").value = data.updated_at;
                        document.getElementById("title").value = title;

                        // Show modal
                        $('#editBannerModal').modal('show');
                    })
                    .catch(error => console.error("Error fetching banner:", error));
            });
        });



    });
</script>

{{-- Delete button click event using SweetAlert --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Restore the previously active tab
        const tabId = sessionStorage.getItem('activeTab');
        if (tabId) {
            const triggerEl = document.querySelector(`a[href="${tabId}"]`);
            if (triggerEl) {
                new bootstrap.Tab(triggerEl).show();
            }
            sessionStorage.removeItem('activeTab');
        }

        // Event delegation for delete buttons (handles dynamically loaded elements and mobile)
        document.addEventListener("click", function (e) {
            const button = e.target.closest(".delete-btn");
            if (button) {
                const bannerId = button.getAttribute("data-id");
                const bannerTitle = button.getAttribute("data-title");

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete the banner: "${bannerTitle}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/banner/delete/${bannerId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ title: bannerTitle })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', data.success, 'success').then(() => {
                                    // Save currently active tab before reload
                                    const activeTab = document.querySelector('.nav-link.active');
                                    if (activeTab) {
                                        sessionStorage.setItem('activeTab', activeTab.getAttribute('href'));
                                    }
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', data.error || 'Something went wrong.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error("Error deleting banner:", error);
                            Swal.fire('Error!', 'There was a problem deleting the banner.', 'error');
                        });
                    } else {
                        Swal.fire('Cancelled', 'The banner was not deleted.', 'info');
                    }
                });
            }
        });
    });
</script>


