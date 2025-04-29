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
        height: 38px !important;
        user-select: none;
        -webkit-user-select: none;
    }

    .select2-selection__placeholder {
        transform: translateY(7px) !important;
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        min-height: 600px;
        /* Keeps initial height but allows growth */
        height: auto;
        /* Grows based on content */
    }


    .table th {
        color: white !important;
        background-color: #003366;
        font-size: 15px;
    }

    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        /* Ensures text is readable */
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        /* Optional rounded edges */
        display: inline-block;
        /* Adjusts width to fit content */
        width: 100%;
        /* Ensures it spans across the container */
    }

    @media (max-width: 767.98px) {
        .white-container {
            height: 800px;
        }
    }

    .card {
        background-color: #87cefa;
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
                    text: '{{ session('
                    success ') }}',
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
                    text: '{{ session('
                    error ') }}',
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
        <!-- Bootstrap 5 (if not already loaded) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            .role-tab-btn {
                background: linear-gradient(to right, #2196F3, #64B5F6);
                border: none;
                padding: 10px 12px;
                border-radius: 6px;
                color: #fff;
                font-weight: 600;
                position: relative;
                transition: background 0.3s;
                font-size: 15.5px;
            }

            .role-tab-btn:not(:last-child) {
                margin-right: 8px;
            }

            .role-tab-btn.active::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 5%;
                width: 90%;
                height: 4px;
                background: #ffeb3b;
                border-radius: 2px;
            }

            .role-tab-btn:hover {
                background: linear-gradient(to right, #1E88E5, #42A5F5);
            }

            .role-tab-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0px;
            }

            /* hide the real select but keep it in the DOM */
            #roleDropdown {
                display: none;
            }

            .role-tab-btn:not(:last-child) {
                margin-right: 2px;
            }

            .card1 {
                background-color: #87cefa;
            }

            .responsive-card {
                width: 60%;
                margin-top: 40px;
            }

            .custom-dropdown {
                height: 38px;
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
                    width: 90%;
                    /* Make form wider on small screens */
                    padding: 20px;
                }

                .import-btn {
                    position: static;
                    /* Moves the import button to normal flow */
                    display: block;
                    margin-bottom: 15px;
                }

                .row {
                    flex-direction: column;
                    /* Stack form fields vertically */
                }

                .text-center {
                    margin-top: 30px;
                }
            }

            .select2-container--default .select2-selection--single,
            .select2-results__option,
            .custom-dropdown {
                font-size: 14px !important;
            }


            /* For mobile view */
            @media (max-width: 767px) {
                .role-tab-group {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                    padding: 10px 0;
                }

                .role-tab-group .d-flex {
                    display: flex;
                    gap: 10px;
                    /* Add some space between buttons */
                }

                .role-tab-btn {
                    flex-shrink: 0;
                    /* Prevent buttons from shrinking */
                    white-space: nowrap;
                    padding: 10px 20px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    background-color: #f1f1f1;
                    cursor: pointer;
                }
            }
        </style>


        <!-- Right side: Role Tabs -->
        <div class="col-12">
            <div class="role-tab-group d-block d-md-none">
                <!-- Display tabs horizontally on mobile view -->
                <div class="d-flex justify-content-between">
                    <button class="role-tab-btn" data-role="International officers">International Officers</button>
                    <button class="role-tab-btn" data-role="DG Team">DG Team</button>
                    <button class="role-tab-btn" data-role="Past Governor">Past District Governors</button>
                    <button class="role-tab-btn" data-role="District Chairperson">District Chairperson</button>
                    <button class="role-tab-btn" data-role="Region member">Region Members</button>
                    <!-- <button class="role-tab-btn" data-role="Club Position">Clubs</button> -->
                </div>
            </div>

            <!-- For desktop and medium view, the default vertical tabs layout will be kept as is -->
            <div class="d-none d-md-block">
                <div class="role-tab-group">
                    <button class="role-tab-btn" data-role="International officers">International Officers</button>
                    <button class="role-tab-btn" data-role="DG Team">DG Team</button>
                    <button class="role-tab-btn" data-role="Past Governor">Past District Governors</button>
                    <button class="role-tab-btn" data-role="District Chairperson">District Chairperson</button>
                    <button class="role-tab-btn" data-role="Region member">Region Members</button>
                    <!-- <button class="role-tab-btn" data-role="Club Position">Clubs</button> -->
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-12 d-flex flex-column flex-md-row justify-content-center justify-content-md-around">
            <!-- Separate container for Assign Member Dropdown -->
            <div class="card shadow-sm p-4 mt-4 card1 col-12 col-md-4 mb-3">
                <div class="d-flex flex-column">
                    <label for="assignMemberDropdown">Assign Member:</label>
                    <select id="assignMemberDropdown" class="form-control custom-dropdown">
                        <option value="">Search & Select Member</option>
                    </select>
                </div>
            </div>

            <!-- Main container for Role and Form -->
            <div class="card shadow-sm p-4 mt-4 card1 col-12 col-md-7 mb-3">
                <div class="d-flex flex-column">
                    <select id="roleDropdown" class="form-control mb-3">
                        <option value="">Select Role</option>
                        <option value="International officers">International Officers</option>
                        <option value="DG Team">DG Team</option>
                        <option value="District Governor">District Governor</option>
                        <option value="Club Position">Club Position</option>
                        <option value="Region member">Region Member</option>
                        <option value="Past Governor">Past Governor</option>
                        <option value="District Chairperson">District Chairperson</option>
                    </select>

                    <div class="row justify-content-center mb-3">
                        <!-- Includes based on role selection -->
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
        </div>





        <!-- Hidden select to drive your JS-show/hide logic -->

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.role-tab-btn');
                const dropdown = document.getElementById('roleDropdown');

                function activate(role) {
                    tabs.forEach(btn => btn.classList.toggle('active', btn.dataset.role === role));
                    dropdown.value = role;
                    // fire your existing change handler
                    dropdown.dispatchEvent(new Event('change'));
                }

                // wire click on each tab
                tabs.forEach(btn =>
                    btn.addEventListener('click', () => activate(btn.dataset.role))
                );

                // make the first tab active on load
                if (tabs.length) {
                    activate(tabs[0].dataset.role);
                }
            });
        </script>



    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Include jQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 with AJAX search for assigning a member
    $('#assignMemberDropdown').select2({
        placeholder: "Search & Select Member",
        ajax: {
            url: "{{ route('search.member') }}", // URL for the search endpoint
            type: "POST",
            dataType: "json",
            delay: 250,  // Delay before sending the request
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"  // CSRF Token for security
            },
            data: function(params) {
                return {
                    query: params.term  // Pass the search term to the backend
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(member) {
                        return {
                            id: member.id,  // Member ID to use for selection
                            text: member.full_name + ' (Member ID: ' + member.member_id + ')'
                        };
                    })
                };
            }
        }
    }).on('select2:select', function(e) {
        let selectedMemberId = e.params.data.id;

        console.log("Selected Member ID:", selectedMemberId);

        // Set the selected member ID in all forms
        $('#dg_member_id').val(selectedMemberId);
        $('input[name="member_id"]').val(selectedMemberId);
        $('#region_member_id').val(selectedMemberId);

        // Enable Role Dropdown
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

    // Show or hide Zone field based on Position selection
    $('#region_position').on('change', function() {
        let selectedPosition = $(this).val();
        if (selectedPosition === "Zone Chairperson") {
            $('#zoneField').show();
        } else {
            $('#zoneField').hide();
        }
    });

    // Default selected tab
    $(".role-tab-btn[data-role='International officers']").trigger("click");
});
</script>




<script>
    // For enabling drag on mobile view
    document.addEventListener('DOMContentLoaded', () => {
        const roleTabGroup = document.querySelector('.role-tab-group .d-flex');

        let isDragging = false;
        let startX, scrollLeft;

        roleTabGroup.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - roleTabGroup.offsetLeft;
            scrollLeft = roleTabGroup.scrollLeft;
        });

        roleTabGroup.addEventListener('mouseleave', () => {
            isDragging = false;
        });

        roleTabGroup.addEventListener('mouseup', () => {
            isDragging = false;
        });

        roleTabGroup.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - roleTabGroup.offsetLeft;
            const walk = (x - startX) * 2; // Multiplier for scroll speed
            roleTabGroup.scrollLeft = scrollLeft - walk;
        });
    });
</script>

@endsection