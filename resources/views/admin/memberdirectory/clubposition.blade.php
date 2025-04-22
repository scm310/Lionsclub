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

<form id="clubPositionForm" action="{{ route('assign.clubposition') }}" method="POST" style="display: none;">
    @csrf
    <h5 class="text-center mt-3">Assign Club Position</h5>

    <input type="hidden" name="member_id" id="club_member_id">

    <!-- Centered Dropdown -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <label for="clubPosition">Select Position:</label>
            <select name="position" class="form-control" required>
                <option value="">Select Position</option>
                <option value="President">President</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Member">Member</option>
            </select>
        </div>
    </div>

    <!-- Centered Button on Next Row -->
    <div class="row mt-3">
        <div class="col text-center">
            <button type="submit" class="btn custom-btn">Assign</button>
        </div>
    </div>
</form>
