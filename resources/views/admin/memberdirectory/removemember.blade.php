@extends('MasterAdmin.layout')

{{-- Include jQuery and DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>



@section('content')

<style>
        .white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}

.table th{
    color: white !important;
    background-color:#003366;
    font-size: 15px;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white; /* Ensures text is readable */
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px; /* Optional rounded edges */
    display: inline-block; /* Adjusts width to fit content */
    width: 100%; /* Ensures it spans across the container */
}

   /* Target the "Show entries" label */
   .dataTables_length label {
        color: black !important;
    }

    /* Target the "Search" label */
    .dataTables_filter label {
        color: black !important;
    }

    /* Optional: make the dropdown and input text black too */
    .dataTables_length select,
    .dataTables_filter input {
        color: black !important;
    }

    .dataTables_length select {
        width: 80px !important; /* Adjust width as needed */
      /* Optional: text color */
    }

    th.sorting,
    th.sorting_asc,
    th.sorting_desc {
        pointer-events: none;
        cursor: default;
        background-image: none !important;
    }

    @media (max-width: 768px) {
    .white-container {
        padding: 10px;
    }

    .custom-heading {
        font-size: 18px;
        padding: 8px;
    }

    #roleDropdown {
        width: 100%;
    }

    .dataTables_length, .dataTables_filter {
        text-align: left !important;
    }
}

@media (max-width: 768px) {
    /* Center the DataTables controls */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        text-align: center !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        width: 30%;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        width: 80% !important;
        margin-top: 5px;
    }
}

.page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}

#complaintTable tbody tr:nth-child(odd) {
        background-color: #F0F8FF; 
}

#complaintTable tbody tr:nth-child(even) {
    background-color: #B9D9EB; 
}
</style>
<div class="container mt-4">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Remove Member Role</h3>
        <form method="GET" action="{{ route('members.remove') }}">
    <div class="d-flex justify-content-center align-items-center mb-3">
    <label for="roleDropdown" class="me-2 fw-bold text-dark">Select Role:</label>

        <div class="col-md-6">
            <select id="roleDropdown" name="role" class="form-control" onchange="this.form.submit()">
              
                <option value="internationalofficers" {{ $role == 'internationalofficers' ? 'selected' : '' }}>International Officers</option>
                <option value="dg_team" {{ request('role') == 'dg_team' ? 'selected' : '' }}>DG Team</option>
                <option value="district_governors" {{ request('role') == 'district_governors' ? 'selected' : '' }}>District Governor</option>
                <option value="club_positions" {{ request('role') == 'club_positions' ? 'selected' : '' }}>Club Position</option>
                <option value="region_members" {{ request('role') == 'region_members' ? 'selected' : '' }}>Region Member</option>
                <option value="past_governors" {{ request('role') == 'past_governors' ? 'selected' : '' }}>Past Governor</option>
                <option value="district_chairpersons" {{ request('role') == 'district_chairpersons' ? 'selected' : '' }}>District Chairperson</option>
            </select>
        </div>
    </div>
</form>

<table class="table table-striped table-bordered text-center bg-white rounded nowrap" id="complaintTable" style="width:100%">


<thead>
<tr>
    <th style="color: white; text-align: center; text-transform: capitalize;">S.No</th>
    <th style="color: white; text-align: center; text-transform: capitalize;">Name</th>
    <th style="color: white; text-align: center; text-transform: capitalize;">Position</th>

    @if(!in_array(request('role'), ['dg_team', 'club_positions']))
    <th style="color: white; text-align: center; text-transform: capitalize;">Year</th>
    @endif

    @if(request('role') === 'region_members')
    <th style="color: white; text-align: center; text-transform: capitalize;">Zone</th>
    <th style="color: white; text-align: center; text-transform: capitalize;">Region</th>
    @endif

    <th>Actions</th>
</tr>
</thead>

<tbody id="roleData">
@foreach($members as $index => $member)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
    <td>{{ $member->position }}</td>

    @if(!in_array(request('role'), ['dg_team', 'club_positions']))
    <td>{{ $member->year }}</td>
    @endif

    @if(request('role') === 'region_members')
    <td>{{ $member->zone }}</td>
    <td>{{ $member->region }}</td>
    @endif

    <td>
    <form method="POST" action="{{ route('admin.member.role.delete', ['role' => $role ?? 'internationalofficers', 'id' => $member->id]) }}">
    @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Remove Position</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>


</table>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#complaintTable').DataTable({
            "pageLength": 10,
            "ordering": false,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": -1 } // Disable ordering for the "Actions" column
            ]
        });
    });
</script>


@endsection
