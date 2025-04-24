@extends('MasterAdmin.layout')

@section('content')

<style>
    /* Fix text color issue in Select2 dropdown */
    .select2-container--default .select2-selection--single {
        color: black !important;
        background-color: white !important;
    }

    .select2-dropdown {
        color: black !important;
        background-color: white !important;
    }

    .select2-results__option {
        color: black !important;
    }

    .select2-container .select2-selection__placeholder {
        color: #6c757d !important;
    }

    .custom-btn {
    background: linear-gradient(115deg, #0f0b8c, #77dcf5) !important;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5% !important;
    transition: 0.3s;
}

.custom-btn:hover {
    color: white;
}


.select2-container .select2-selection--single {
    box-sizing: border-box !important;
    cursor: pointer !important;
    display: block !important;
    height:38px !important;
    user-select: none;
    -webkit-user-select: none;
}
.select2-selection__placeholder{
    transform:translateY(7px) !important;
}

.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    min-height: 600px; /* Keeps initial height but allows growth */
    height: auto;       /* Grows based on content */
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

@media (max-width: 767.98px) {
    .white-container {
        height: 800px;
    }
}

.card{
      background-color:#87cefa;
}
</style>

<div class="container mt-4">
    <div class="white-container position-relative">
        <!-- Header -->
        <h3 class="mb-3 custom-heading">Assign Member Position</h3>

        <!-- Import Button in Next Row, Right-Aligned -->
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="{{ route('show.import.form') }}" class="btn custom-btn">
                    + Import
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif


        <script>
            setTimeout(function() {
                let alertBox = document.querySelector(".alert");
                if (alertBox) {
                    alertBox.classList.remove("show");
                    alertBox.classList.add("fade");
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        </script>

        <!-- Member Selection & Role -->
        <div class="card shadow-sm p-4 mt-4">
    <h5 class="text-center mb-4">Assign Member to a Role</h5>

    <div class="row justify-content-center mb-3">
        <div class="col-md-4 col-12">
            <label for="assignMember">Assign Member:</label>
            <select id="assignMemberDropdown" class="form-control custom-dropdown">
                <option value="">Search & Select Member</option>
            </select>
        </div>

        <div class="col-md-4 col-12">
            <label for="roleDropdown">Select Role:</label>
            <select id="roleDropdown" class="form-control custom-dropdown">
                <option value="">Select Role</option>
                <option value="International officers">International Officers</option>
                <option value="DG Team">DG Team</option>
                <option value="District Governor">District Governor</option>
             
                <option value="Region member">Region Member</option>
                <option value="Past Governor">Past Governor</option>
                <option value="District Chairperson">District Chairperson</option>
            </select>
        </div>
    </div>

    <!-- Include role-specific forms -->
    @include('admin.memberdirectory.internationalofficerform')
    @include('admin.memberdirectory.dgteam')
    @include('admin.memberdirectory.districtgovernor')
    @include('admin.memberdirectory.clubposition')
    @include('admin.memberdirectory.regionmember')
    @include('admin.memberdirectory.pastgovernor')
    @include('admin.memberdirectory.districtchairperson')
</div>

    </div>
</div>



<!-- Mobile Responsive Styles -->
<style>
    .responsive-card {
        width: 60%;
        margin-top: 40px;
    }

    .custom-dropdown {
        height:38px;
        padding: 8px 12px;
        appearance: none;
        border: 1px solid #ced4da;
        border-radius: 5px;
        background-color: white;
        width: 100%;
    }

    .import-btn {
        top: 10px;
        right: 10px;
    }

    @media (max-width: 768px) {
        .responsive-card {
            width: 90%; /* Make form wider on small screens */
            padding: 20px;
        }
        
        .import-btn {
            position: static; /* Moves the import button to normal flow */
            display: block;
            margin-bottom: 15px;
        }

        .row {
            flex-direction: column; /* Stack form fields vertically */
        }

        .text-center{
            margin-top:30px;
        }
    }

    .select2-container--default .select2-selection--single,
.select2-results__option,
.custom-dropdown {
    font-size: 14px !important;
}
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Include jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
   $(document).ready(function() {
    // Initialize Select2 with AJAX search
    $('#assignMemberDropdown').select2({
        placeholder: "Search & Select Member",
        ajax: {
            url: "{{ route('search.member') }}",
            type: "POST",
            dataType: "json",
            delay: 250,
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            data: function (params) {
                return { query: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(member => ({
                        id: member.id,
                        text: member.full_name
                    }))
                };
            }
        }
    }).on('select2:select', function(e) {
        let selectedMemberId = e.params.data.id;

        console.log("Selected Member ID:", selectedMemberId); // Debugging

        // Set the selected member ID in all forms
        $('#dg_member_id').val(selectedMemberId);
        $('input[name="member_id"]').val(selectedMemberId); // Ensure all forms receive the selected ID
        $('#region_member_id').val(selectedMemberId); // Assign to region member form

        // Enable Role Dropdown when a member is selected
        $('#roleDropdown').prop('disabled', false);
    });

    // Disable Role Dropdown by default
    $('#roleDropdown').prop('disabled', true);

    // Show Form Based on Role Selection
    $('#roleDropdown').on('change', function() {
        let selectedRole = $(this).val();

        // Hide all forms first
        $('#internationalOfficersForm, #dgTeamForm, #districtGovernorForm, #clubPositionForm, #regionMemberForm, #pastGovernorForm, #districtChairpersonForm').hide();

        // Show relevant form based on the selected role
        if (selectedRole === "International officers") {
            $('#internationalOfficersForm').show();
        } else if (selectedRole === "DG Team") {
            $('#dgTeamForm').show();
        } else if (selectedRole === "District Governor") {
            $('#districtGovernorForm').show();
        } else if (selectedRole === "Club Position") {
            $('#clubPositionForm').show();
        } else if (selectedRole === "Region member") {
            $('#regionMemberForm').show();
        } else if (selectedRole === "Past Governor") {
            $('#pastGovernorForm').show();
        } else if (selectedRole === "District Chairperson") {
            $('#districtChairpersonForm').show();
        }
    });

    // Show or hide Zone dropdown based on Position selection
    $('#region_position').on('change', function() {
        let selectedPosition = $(this).val();
        if (selectedPosition === "Zone Chairperson") {
            $('#zoneField').show();
        } else {
            $('#zoneField').hide();
        }
    });
});

</script>


@endsection
