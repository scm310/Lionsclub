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



<form id="regionMemberForm" style="display: none;" class="mt-4" method="POST" action="{{ route('assign.region.member') }}">
    @csrf

    <h5 class="text-center">Region Member Details</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="region_position">Position:</label>
                <select id="region_position" name="position" class="form-control" required>
                    <option value="">Select Position</option>
                    <option value="Region Chairperson">Region Chairperson</option>
                    <option value="Zone Chairperson">Zone Chairperson</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="region_year">Year:</label>
                <input type="text" name="year" id="region_year" class="form-control" placeholder="Enter Year" required>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="region">Region:</label>
                <select name="region" id="region" class="form-control" required>
                    <option value="">Select Region</option>
                    <option value="Region 1">Region 1</option>
                    <option value="Region 2">Region 2</option>
                    <option value="Region 3">Region 3</option>
                    <option value="Region 4">Region 4</option>
                </select>
            </div>
        </div>

        <div class="col-md-4" id="zoneField" style="display: none;">
            <div class="form-group">
                <label for="region_zone">Zone:</label>
                <select name="zone" id="region_zone" class="form-control">
                    <option value="">Select Zone</option>
                    <option value="Zone 1">Zone 1</option>
                    <option value="Zone 2">Zone 2</option>
                    <option value="Zone 3">Zone 3</option>
                </select>
            </div>
        </div>
    </div>

    <input type="hidden" name="region_member_id" id="region_member_id">

    <div class="text-center">
        <button type="submit" class="btn custom-btn mt-3">Assign</button>
    </div>
</form>
