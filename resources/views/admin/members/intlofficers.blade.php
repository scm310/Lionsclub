@extends('MasterAdmin.layout')

@section('content')
<style>
    
    #myTabs .nav-item {
    margin-right: 1px; /* Adds space between tabs */
}

#myTabs .nav-link {
    background: linear-gradient(90deg, rgb(22, 35, 72) 0%, rgb(139, 102, 241) 100%);
    color: white;
    border: none;
    padding: 10px 15px; /* Increases padding for better spacing */
    border-radius: 5px; /* Rounds corners slightly */
}

#myTabs .nav-link.active {
    background: linear-gradient(90deg, rgb(22, 35, 72) 0%, rgb(139, 102, 241) 100%);
    color: #FFD700;
    font-weight: bold;
    border-bottom: 3px solid yellow;
}

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
<div class="container mt-4">
<h5 class="text-center">Add Member Directory Information</h5>
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#internationalOfficer">Add International Officer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab2">District Governor</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab3">DG Team</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab4"> Chapter</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab5"> District Chairpersons</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab6">Region Member</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab7">Past Governor</a>
        </li>
      
    </ul>

    <div class="tab-content mt-3">
        <!-- International Officer Form and Table -->
        <div class="tab-pane fade show active" id="internationalOfficer">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4 class="mb-0">Add International Officer</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Form to Add Officer -->
                    <form action="{{ route('international.officers.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" id="position" class="form-control" required>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="district_id" class="form-label">District</label>
            <select name="district_id" id="district_id" class="form-control" required>
                <option value="">Select District</option>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->district_name }} ({{ $district->district_code }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-4">
            <label for="profile_image" class="form-label">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*" required>
        </div>
    </div>

    <div class="mt-3">
    <button type="submit" class="btn custom-btn">Add Officer</button>
</div>

</form>

                </div>
            </div>

            <!-- Display Officers in Table -->
            <div class="card shadow-lg mt-4">
                <div class="card-header">
                    <h4 class="mb-0">International Officers List</h4>
                </div>
                <div class="card-body">
                <table class="table table-bordered mt-5">
    <thead class="table">
        <tr>
            <th>ID</th>
            <th>Profile Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Company</th>
            <th>Address</th>
            <th>District</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($officers as $officer)
            <tr>
                <td>{{ $officer->id }}</td>
                <td>
                    @if($officer->profile_image)
                        <img src="{{ asset('storage/' . $officer->profile_image) }}" width="50" height="50" class="rounded-circle">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $officer->name }}</td>
                <td>{{ $officer->email }}</td>
                <td>{{ $officer->position }}</td>
                <td>{{ $officer->company_name }}</td>
                <td>{{ $officer->address }}</td>
                <td>{{ $officer->district->district_name }} ({{ $officer->district->district_code }})</td>
                <td>
                    <form action="{{ route('international.officers.destroy', $officer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

                </div>
            </div>
        </div>

        <!-- Placeholder Content for Other Tabs -->
        <div class="tab-pane fade" id="tab2">
    <div class="card">
        <div class="card-body">
            <h5>Add District Governor</h5>
            @include('admin.members.add_district_governor')
        </div>
    </div>
</div>

<div class="tab-pane fade" id="tab3">
    <div class="card">
        <div class="card-body">
            <h5>Add DG Team Member</h5>
            @include('admin.members.adddgteam')
        </div>
    </div>
</div>

<div class="tab-pane fade" id="tab4">
    <div class="card">
        <div class="card-body">
            @include('admin.members.addchaptermember', ['chapters' => $chapters])
        </div>
    </div>
</div>

<div class="tab-pane fade" id="tab5">
    <div class="card">
      @include('admin.members.addteam')
    </div>
</div>



<div class="tab-pane fade" id="tab6">
    <div class="card">
       @include('admin.members.addregion')
    </div>
</div>

<div class="tab-pane fade" id="tab7">
    <div class="card">
      @include('admin.members.pastgovernor')
    </div>
</div>

        <div class="tab-pane fade" id="tab8">
            <div class="card">
                <div class="card-body">
                    <h5>Tab 8 Content Goes Here</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
