<style>
    .custom-btn {
        background: rgb(30,144,255);
        background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153,186,221,1) 0%, rgba(30,144,255,1) 100%);
        color: white;
    }
</style>

<form id="districtGovernorForm" action="{{ route('store.district_governor') }}" method="POST" class="mt-4" style="display: none;">
    @csrf
    <h5 class="text-center mt-3">Assign District Governor</h5>

    <input type="hidden" name="member_id" id="dg_member_id">

    <!-- Centered Form Fields -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <label for="position">Position:</label>
            <select name="position" id="position" class="form-control">
                <option value="">Select Position</option>
                <option value="District Governor">District Governor</option>
                <option value="First Vice District Governor">First Vice District Governor</option>
                <option value="Second Vice District Governor">Second Vice District Governor</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="year">Year:</label>
            <input type="text" name="year" id="year" class="form-control" placeholder="Enter Year">
        </div>
    </div>

    <!-- Centered Button -->
    <div class="row mt-3">
        <div class="col text-center">
            <button type="submit" class="btn custom-btn">Assign</button>
        </div>
    </div>
</form>
