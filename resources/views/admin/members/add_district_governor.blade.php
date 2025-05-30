<style>
    .custom-btn {
    background: rgb(30,144,255);
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50%;
    transition: 0.3s;
}

.custom-btn:hover {
    background: linear-gradient(159deg, rgba(153,186,221,1) 0%, rgba(30,144,255,1) 100%);
    color: white;
}
</style>

<form action="{{ route('international.officers.storeGovernor') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-2">
        <div class="col-md-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="district_id" class="form-label">District Code</label>
            <select name="district_id" id="district_id" class="form-control" required>
                <option value="">Select District</option>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->district_code }} ({{ $district->district_name }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label for="profile_image" class="form-label">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*" required>
        </div>
    </div>

    <div class="mt-3">
    <button type="submit" class="btn custom-btn">Add District Governor</button>
</div>
</form>
