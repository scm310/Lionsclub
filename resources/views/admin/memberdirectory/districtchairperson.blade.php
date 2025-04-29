<!-- SweetAlert2 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<style>
    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }
</style>

<div id="districtChairpersonForm" style="display: none;">
    <h5 class="text-center mt-3">Assign District Chairperson</h5>

    <!-- Input Fields Centered -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <label for="district_position">Position & Events:</label>
            <input type="text" name="position" id="district_position" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="district_year">Year:</label>
            <input type="text" name="year" id="district_year" class="form-control" required>
        </div>
    </div>

    <!-- Button in Next Row and Centered -->
    <div class="row mt-3">
        <div class="col text-center">
            <input type="hidden" name="member_id" id="district_chairperson_member_id">
            <button type="submit" class="btn custom-btn" onclick="submitDistrictChairperson()">Assign</button>
        </div>
    </div>
</div>

<script>
    function submitDistrictChairperson() {
        let memberId = $('#district_chairperson_member_id').val();
        let position = $('#district_position').val();
        let year = $('#district_year').val();

        if (!memberId || !position || !year) {
            // Show SweetAlert if fields are empty
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill all fields.',
            });
            return;
        }

        $.ajax({
            url: "{{ route('assign.districtChairperson') }}",
            type: "POST",
            data: {
                member_id: memberId,
                position: position,
                year: year,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // Show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Assigned!',
                    text: response.message,
                });

                // Clear the input fields after success
                $('#district_position, #district_year').val('');
            },
            error: function(xhr) {
                // Show error message with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "Error: " + xhr.responseJSON.message,
                });
            }
        });
    }
</script>