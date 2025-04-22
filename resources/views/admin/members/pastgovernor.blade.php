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
            <h5 class="mb-3">Add Past District Governor</h5>
            <form action="{{ route('pastdistrictgovernors.store') }}" method="POST" enctype="multipart/form-data">
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
                    <!-- Blood Group -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="blood_group" class="form-label">Blood Group</label>
                            <input type="text" id="blood_group" name="blood_group" class="form-control" required>
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
                    <!-- Spouse Name -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="spouse_name" class="form-label">Spouse Name</label>
                            <input type="text" id="spouse_name" name="spouse_name" class="form-control">
                        </div>
                    </div>
                    <!-- Year of Joining -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="year_of_joining" class="form-label">Year of Joining</label>
                            <input type="date" id="year_of_joining" name="year_of_joining" class="form-control" required>
                        </div>
                    </div>
                    <!-- Profile Photo Upload -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Profile Photo</label>
                            <input type="file" id="profile_photo" name="profile_photo" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <!-- PDG Dropdown -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="pdg" class="form-label">PDG</label>
                            <select id="pdg" name="pdg" class="form-control" required>
                                <option value="">Select PDG</option>
                                <option value="Club Constitution & Trust">Club Constitution & Trust</option>
                                <option value="Service Activities">Service Activities</option>
                                <option value="Eye Care">Eye Care</option>
                                <option value="Leadership">Leadership</option>
                                <option value="Foundation Coordinator">Foundation Coordinator</option>
                                <option value="Membership">Membership</option>
                                <option value="Hunger Relief">Hunger Relief</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn custom-btn">Add Past Governor</button>
            </form>
        </div>