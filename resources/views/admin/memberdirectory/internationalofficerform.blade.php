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

<div class="card-body" id="internationalOfficersForm" style="display: none;">
    <h5 class="text-center mt-3">Assign International Officers</h5>

    <form method="POST" action="{{ route('store.international.officer') }}">
        @csrf
        <input type="hidden" id="member_id" name="member_id">

        <div class="row mb-3">
            <!-- Position Dropdown -->
            <div class="col-md-6">
                <label for="position">Position:</label>
                <select name="position" id="position" class="form-control" style="color: black;">
                    <option value="">Select Position</option>
                    <option value="International Director">International Director</option>
                    <option value="Past International Director">Past International Director</option>
                    <option value="Third International President Endorsee">Third International President Endorsee</option>
                </select>
            </div>

            <!-- Year Input Field -->
            <div class="col-md-6">
                <label for="year">Year:</label>
                <input type="text" name="year" id="year" class="form-control" placeholder="Enter Year">
            </div>
        </div>

        <!-- Centered Assign Button on next row -->
        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn custom-btn">Assign</button>
            </div>
        </div>
    </form>
</div>
