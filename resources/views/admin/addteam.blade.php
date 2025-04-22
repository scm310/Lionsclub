@extends('MasterAdmin.layout')

@section('content')
<style>
    /* Common styles for all tab sections */
.nav-tabs {
    border-bottom: none; /* Removes default tab border */
}

.nav-tabs .nav-item {
    margin-right: 1px; /* Adds space between tabs */
}

.nav-tabs .nav-link {
    background: linear-gradient(90deg, rgb(22, 35, 72) 0%, rgb(139, 102, 241) 100%);
    color: white;
    border: none;
    padding: 10px 15px; /* Increases padding for better spacing */
    border-radius: 5px; /* Rounds corners slightly */
}

.nav-tabs .nav-link.active {
    background: linear-gradient(90deg, rgb(22, 35, 72) 0%, rgb(139, 102, 241) 100%);
    color: #FFD700;
    font-weight: bold;
    border-bottom: 3px solid yellow;
}

</style>
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
<div class="container mt-4">
<h5 class="text-center">Add Information</h5>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('districts.index') ? 'active' : '' }}" href="{{ route('districts.index') }}">Add District</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('chapter.index') ? 'active' : '' }}" href="{{ route('chapter.index') }}">Add Chapter</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}" href=" {{ route('teams.index') }}">Add Team</a>
    </li>
</ul>

    <div class="card shadow-lg mt-4">
        <div class="card-header">
            <h4 class="mb-0">Add Team</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Add Team Form -->
            <form action="{{ route('team.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="team_name" class="form-label">Team Name</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label for="team_code" class="form-label">Team Code</label>
                        <input type="text" name="team_code" id="team_code" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>

                    <div class="col-md-3 mt-5">
                        <button type="submit" class="btn custom-btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
    <div class="card-header">
        <h4 class="mb-0">Stored Teams</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th>ID</th>
                    <th>Team Name</th>
                    <th>Team Code</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{ $team->id }}</td>
                    <td>{{ $team->team_name }}</td>
                    <td>{{ $team->team_code }}</td>
                    <td>{{ $team->location }}</td>
                    <td>
                      
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</div>
@endsection
