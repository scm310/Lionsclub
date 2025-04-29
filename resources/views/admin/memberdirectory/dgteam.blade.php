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

<form id="dgTeamForm" action="{{ route('dgteam.store') }}" method="POST" style="display: none;">
    @csrf

    <div class="container d-flex justify-content-center">
        <div class="w-75"> <!-- Reduced width -->
            <h5 class="text-center mt-4 mb-4">Assign DG Team Member</h5>

            <input type="hidden" name="member_id" id="dg_member_id">

            <div class="row justify-content-center mb-4">

                <!-- Year Radio Buttons -->
                <div class="col-md-6">
                    <label class="form-label d-block">Select Year</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="year" id="currentYear"
                            value="CurrentYear" required>
                        <label class="form-check-label" for="currentYear">Current Year</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="year" id="upcomingYear"
                            value="UpCommingYear" required>
                        <label class="form-check-label" for="upcomingYear">Upcoming Year</label>
                    </div>
                </div>


                <!-- Position Dropdown -->
                <div class="col-md-6">
                    <label for="dgPosition" class="form-label">Select Position</label>
                    <select name="position" id="dgPosition" class="form-control">
                        <option value="">Select Position</option>
                        <option value="District Governor">District Governor</option>
                        <option value="Past District Governor">Past District Governor</option>
                        <option value="1st Vice Governor">1st Vice Governor</option>
                        <option value="2nd Vice Governor">2nd Vice Governor</option>
                        <option value="Cabinet Secretary">Cabinet Secretary</option>
                        <option value="Cabinet Treasurer">Cabinet Treasurer</option>
                    </select>
                </div>



            </div>

            <!-- Submit Button Centered -->
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <button type="submit" class="btn custom-btn px-4">Assign</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    $(document).ready(function () {
    // Initially, make sure the "Past District Governor" option is visible
    $('#dgPosition option[value="Past District Governor"]').show();

    // When the radio button for the upcoming year is selected
    $('#upcomingYear').on('change', function () {
        if ($(this).is(':checked')) {
            // Hide the "Past District Governor" option when Upcoming Year is selected
            $('#dgPosition option[value="Past District Governor"]').hide();
        }
    });

    // When the radio button for the current year is selected
    $('#currentYear').on('change', function () {
        if ($(this).is(':checked')) {
            // Show the "Past District Governor" option when Current Year is selected
            $('#dgPosition option[value="Past District Governor"]').show();
        }
    });
});

</script>