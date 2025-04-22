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


<form id="dgTeamForm" action="{{ route('dgteam.store') }}" method="POST" style="display: none;">
    @csrf
    <h5 class="text-center mt-3">Assign DG Team Member </h5> <!-- Header Added -->

    <input type="hidden" name="member_id" id="dg_member_id">

    <div class="row mt-3">
    <!-- Position Dropdown -->
    <div class="col-md-6">
        <label for="dgPosition">Select Position:</label>
        <select name="position" id="dgPosition" class="form-control">
            <option value="">Select Position</option>
            <option value="District Governor">District Governor</option>
            <option value="Imm. Past District Governor">Imm. Past District Governor</option>
            <option value="First Vice District Governor">First Vice District Governor</option>
            <option value="Second Vice District Governor">Second Vice District Governor</option>
            <option value="District cabinet secretary">District Cabinet Secretary</option>
            <option value="District cabinet treasurer">District Cabinet Treasurer</option>
            <option value="GMT co ordinator (intl)">GMT Co-ordinator (Int)</option>
            <option value="GLT Co ordinator (Intl)">GLT Co-ordinator (Int)</option>
            <option value="GST co ordinator (intl)">GST Co-ordinator (Int)</option>
            <option value="District Guest Administration">District Guest Administration</option>
            <option value="Joint Cabinet Secretary">Joint Cabinet Secretary</option>
            <option value="Joint Cabinet Treasurer">Joint Cabinet Treasurer</option>
        </select>
    </div>

    <!-- Submit Button -->
    <div class="col-md-6 d-flex align-items-end">
        <button type="submit" class="btn custom-btn ">Assign</button>
    </div>
</div>

</form>
