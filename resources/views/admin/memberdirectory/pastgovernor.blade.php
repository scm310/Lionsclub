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

<form action="{{ route('store.past.governor') }}" method="POST">
    @csrf
    <div id="pastGovernorForm" style="display: none;">
        <h5 class="text-center mt-3">Assign Past District Governor</h5>
        <input type="hidden" name="member_id" id="past_governor_member_id">

        <!-- Centered Fields Row -->
        <div class="row justify-content-center mt-3">
            <div class="col-md-4">
                <label for="past_governor_position">Position & Events:</label>
                <select name="position" id="past_governor_position" class="form-control">
                    <option value="">Select Position</option>
                    <option value="Audit Committee">Audit Committee</option>
                    <option value="Leo Chairman">Leo Chairman</option>
                    <option value="Enviroinment">Enviroinment</option>
                    <option value="Diabetics">Diabetics</option>
                    <option value="Club Constitution & Trust">Club Constitution & Trust</option>
                    <option value="Service Activities">Service Activities</option>
                    <option value="Eye Care">Eye Care</option>
                    <option value="Leadership">Leadership</option>
                    <option value="Foundation Coordinator">Foundation Coordinator</option>
                    <option value="Membership">Membership</option>
                    <option value="Hunger Relief">Hunger Relief</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="past_governor_year">Year:</label>
                <input type="text" name="year" id="past_governor_year" class="form-control">
            </div>
        </div>

        <!-- Centered Button Row -->
        <div class="row mt-3">
            <div class="col text-center">
                <button type="submit" class="btn custom-btn">Assign</button>
            </div>
        </div>
    </div>
</form>
