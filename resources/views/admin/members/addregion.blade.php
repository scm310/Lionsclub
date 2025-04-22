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
<div class="card-body">
    <h5 class="mb-3">Add Region Member</h5>
    <form action="{{ route('regionmembers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Name -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
            </div>
            <!-- Email -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
            </div>
            <!-- Phone -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
            </div>
            <!-- Address -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>
            </div>
            <!-- M.NO -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="m_no" class="form-label">M.NO</label>
                    <input type="text" id="m_no" name="m_no" class="form-control" required>
                </div>
            </div>
            <!-- Chapter Dropdown -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="chapter_id" class="form-label">Chapter</label>
                    <select id="chapter_id" name="chapter_id" class="form-control" required>
                        <option value="">Select Chapter</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}">{{ $chapter->chapter_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Region Dropdown -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="region" class="form-label">Region</label>
                    <select id="region" name="region" class="form-control" required>
                        <option value="">Select Region</option>
                        <option value="Region 1">Region 1</option>
                        <option value="Region 2">Region 2</option>
                        <option value="Region 3">Region 3</option>
                        <option value="Region 4">Region 4</option>
                    </select>
                </div>
            </div>
            <!-- Position Dropdown -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <select id="position" name="position" class="form-control" required>
                        <option value="">Select Position</option>
                        <option value="Region Chairperson">Region Chairperson</option>
                        <option value="Zone Chairperson Zone 1">Zone Chairperson Zone 1</option>
                        <option value="Zone Chairperson Zone 2">Zone Chairperson Zone 2</option>
                        <option value="Zone Chairperson Zone 4">Zone Chairperson Zone 4</option>
                    </select>
                </div>
            </div>
            <!-- Profile Image Upload -->
            <div class="col-md-4">
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*" required>
            </div>
        </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn custom-btn">Add Region Member</button>
    </form>
</div>
