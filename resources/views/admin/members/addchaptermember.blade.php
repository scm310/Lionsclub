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
<h5>Add Chapter Member</h5>
<form action="{{ route('addChapterMember') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Name -->
        <div class="col-md-4 mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <!-- Email -->
        <div class="col-md-4 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <!-- Phone -->
        <div class="col-md-4 mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
    </div>

    <div class="row">
        <!-- Address -->
        <div class="col-md-4 mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <!-- Role Dropdown -->
        <div class="col-md-4 mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="" selected disabled>Select Role</option>
                <option value="1">President</option>
                <option value="2">Secretary</option>
                <option value="3">Treasurer</option>
                <option value="4">Member</option>
            </select>
        </div>
        <!-- Chapter Dropdown -->
        <div class="col-md-4 mb-3">
            <label for="chapter_id" class="form-label">Chapter</label>
            <select class="form-control" id="chapter_id" name="chapter_id" required>
                <option value="" selected disabled>Select Chapter</option>
                @if(isset($chapters) && count($chapters) > 0)
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->chapter_name }}</option>
                    @endforeach
                @else
                    <option disabled>No Chapters Available</option>
                @endif
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Profile Image Upload -->
        <div class="col-md-4 mb-3">
            <label for="profile_image" class="form-label">Profile Image</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
        </div>
    </div>

    <button type="submit" class="btn custom-btn">Add Chapter Member</button>
</form>
