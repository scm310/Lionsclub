@extends('MasterAdmin.layout')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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


    /* Fix DataTable layout spacing */
    .dataTables_length {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dataTables_length label {
        margin-bottom: 0;
        font-weight: 500;
    }

    .dataTables_length select {
        padding: 4px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        outline: none;
    }

    div.dataTables_wrapper div.dataTables_length select{
        width: 70px;
    }

    .dataTables_length label,
.dataTables_filter label {
    color: black !important;
    font-weight: 500;
}

/* Dropdown and input text color */
.dataTables_length select,
.dataTables_filter input {
    color: black !important;
}

  
    /* Rounded table borders */
    #approve {
        border-collapse: separate !important;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
    }

    #approve thead th:first-child {
        border-top-left-radius: 10px;
    }

    #approve thead th:last-child {
        border-top-right-radius: 10px;
    }

    #approve tbody tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }

    #approve tbody tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }

    /* Optional: Add shadow or soft border */
    #approve {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid #dee2e6;
    }

    .custom-heading {
        font-size: 1.8rem;
        text-align: center;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        color: white;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .custom-heading {
            font-size: 1.3rem;
        }

        table.dataTable {
            width: 100% !important;
        }
    }

    /* Style the expanded details row */
table.dataTable.dtr-inline.collapsed > tbody > tr > td.child {
    background-color: #f9f9f9;
    padding: 10px 15px;
}

/* Prevent table from stretching too wide on expand */
table.dataTable td.child ul {
    padding-left: 1rem;
    margin-bottom: 0;
}

table.dataTable td.child li {
    font-size: 0.9rem;
    line-height: 1.4;
    margin-bottom: 6px;
    list-style: none;
}

/* Optional: Add border or rounded corners to child content */
table.dataTable td.child {
    border-left: 3px solid #0f0b8c;
    border-radius: 5px;
}


#approve tbody tr:nth-child(odd) {
        background-color: #F0F8FF; /* Alice Blue */
    }

    #approve tbody tr:nth-child(even) {
        background-color: #B9D9EB; /* Soft pastel blue */
    }

    #approve td {
        padding: 10px;
        border-color: #ddd;
    }

    .page-item.active .page-link{
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border:none;
}

/* Smooth mobile layout */
@media (max-width: 768px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        text-align: center;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .card-body.p-4 {
        margin-left: -20px;
    }

    #approve td{
        padding: 28px;
    }
}


</style>

@php
    // This checks if all rows have 5 columns — if not, logs a warning
    echo "<script>console.warn('Rendered row count: ', document.querySelectorAll('#approve tbody tr').length);</script>";
@endphp

<div class="container mt-4">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Approve Member Information</h3>
     <!-- Approve Member List Card -->
<div class="card mb-4">
<!-- <div class="card-header" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); text-align: center; color: white;">
        <strong>Approve Member List</strong>
    </div> -->
    <div class="card-body p-4">
    <table class="table table-bordered table-hover nowrap" id="approve" style="width:100%">
    <thead class="thead-light">
        <tr>
            <th style="color: white; text-align: center;">S.No</th>
            <th style="color: white; text-align: center;">Member ID</th>
            <th style="color: white; text-align: center;">Member Name</th>
            <th style="color: white; text-align: center;">Changes</th>
            <th style="color: white; text-align: center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($allUpdates as $index => $update)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ optional($update->member)->member_id ?? 'N/A' }}</td>
                <td>{{ optional($update->member)->first_name }} {{ optional($update->member)->last_name }}</td>
                <td>
                    <div class="change-content">
                        @php
                            $changes = json_decode($update->data, true);
                            $original = $update->member ? $update->member->toArray() : [];
                            $hasChanges = false;
                            $ignoredFields = ['token', 'api_token', '_token'];
                            $dateFields = ['dob', 'anniversary_date', 'created_at', 'updated_at'];
                            $fieldLabels = [
                                'dob' => 'D.O.B',
                                'anniversary_date' => 'Anniversary Date',
                                'spouse_name' => 'Spouse Name',
                                'first_name' => 'First Name',
                                'last_name' => 'Last Name',
                                'suffix' => 'Suffix',
                            ];
                        @endphp

                        @if (is_array($changes) && count($changes))
                            <ul class="mb-0">
                                @foreach ($changes as $field => $newValue)
                                    @php
                                        $oldValue = $original[$field] ?? 'N/A';
                                        if (in_array($field, $dateFields)) {
                                            try {
                                                $oldValue = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('d-m-Y') : 'N/A';
                                                $newValue = $newValue ? \Carbon\Carbon::parse($newValue)->format('d-m-Y') : 'N/A';
                                            } catch (\Exception $e) {}
                                        }
                                        $label = $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field));
                                    @endphp

                                    @if (
                                        !in_array($field, $ignoredFields) &&
                                        $newValue !== null && $newValue !== '' &&
                                        $oldValue != $newValue
                                    )
                                        @php $hasChanges = true; @endphp
                                        <li>
                                            <strong>{{ $label }}:</strong>
                                            <span class="text-danger">{{ $oldValue }}</span> →
                                            <span class="text-success">{{ $newValue }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            @if (!$hasChanges && $update->status === 'approved')
                                <em class="text-success">Changes approved.</em>
                            @elseif (!$hasChanges)
                                <em class="text-muted">No actual value changes.</em>
                            @endif
                        @else
                            @if ($update->status === 'approved')
                                <em class="text-success">Changes approved.</em>
                            @else
                                <em class="text-muted">No changes found.</em>
                            @endif
                        @endif
                    </div>
                </td>
                <td>
                    <form action="{{ route('admin.approve-member', $update->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-outline-success"
                                title="Approve"
                                {{ $update->status === 'approved' ? 'disabled' : '' }}>
                            <i class="fas fa-check"></i>
                        </button>
                    </form>

                    <form action="{{ route('admin.reject-member', $update->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-outline-danger"
                                title="Reject"
                                {{ $update->status === 'rejected' ? 'disabled' : '' }}>
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



    </div>
</div>

    </div>
    </div>


<!-- DataTables Core -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Responsive extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- DataTables Core JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Responsive JS -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function () {
        $('#approve').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "No matching records found",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif
</script>


@endsection


