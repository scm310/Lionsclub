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
            <h4 class="mb-0">Add Chapter</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Add Chapter Form -->
            <form action="{{ route('chapter.store') }}" method="POST">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <label for="chapter_name" class="form-label">Chapter Name</label>
                        <input type="text" name="chapter_name" id="chapter_name" class="form-control" required>
                    </div>

                    <div class="col-md-5">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn custom-btn mt-4">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Display Chapters in Table -->
    <div class="card shadow-lg mt-4">
        <div class="card-header">
            <h4 class="mb-0">Chapters List</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered mt-3">
                <thead class="table">
                    <tr>
                        <th>ID</th>
                        <th>Chapter Name</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chapters as $chapter)
                        <tr>
                            <td>{{ $chapter->id }}</td>
                            <td>{{ $chapter->chapter_name }}</td>
                            <td>{{ $chapter->location }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
