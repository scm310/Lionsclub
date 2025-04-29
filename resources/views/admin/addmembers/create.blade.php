@extends('MasterAdmin.layout')
@section('content')
    <style>
        .nav-tabs {
            border-bottom: none;
            gap: 1px;
        }

        .nav-tabs .nav-link {
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;

        }



        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: white;
            border-bottom: 3px solid yellow;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .white-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .table th {
            color: white !important;
            background-color: #003366;
            font-size: 15px;
        }

        .custom-heading {
            text-align: center;
            white-space: nowrap;
            padding: 5px;
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

        .custom-btn {
            background: rgb(30, 144, 255);
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 24px;

        }

        .custom-btn:hover {
            background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
            color: white;
        }



        .form-label {
            font-size: 14px;
        }

        .form-control {
            font-size: 12px;
        }

        .form-control::placeholder {
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .form-label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
                /* Add spacing between label and input */
            }

            .form-control {
                margin-bottom: 15px;
                /* Add spacing between input fields */
            }
        }

        .card {
            background-color: #87cefa;
        }

        input.filled {
            color: white !important;
        }
    </style>


    <div class="container mt-4">
        <div class="white-container">
            <h3 class="mb-3 custom-heading">Add Member </h3>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


<!-- Tab Navigation -->

<div class="d-flex justify-content-between align-items-end mb-3">
    <ul class="nav nav-tabs" id="memberTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
                type="button" role="tab">Personal Details</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="official-tab" data-bs-toggle="tab" data-bs-target="#official"
                type="button" role="tab">Official Details</button>
        </li>
    </ul>

    <!-- Import Form -->
    <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center ms-3">
        @csrf
        <label for="import_file" class="form-label mb-0 me-2 text-dark">Upload Member List</label>
        <input type="file" name="import_file" id="import_file" class="form-control form-control-sm me-2" required>
        <button type="submit" class="btn custom-btn mb-1" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5px;">
            Import
        </button>
    </form>
</div>




            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <!-- Tab Content -->
                <div class="card shadow-lg mb-4">
                    <div class="tab-content p-3 border border-top-0" id="memberTabsContent">
                        <!-- Personal Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">

                            <!-- First Row -->
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label">Salutation*</label>
                                    <input type="text" name="salutation" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">First Name*</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name*</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="suffix" class="form-control">
                                </div>
                            </div>

                            <!-- Second Row -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Spouse Name</label>
                                    <input type="text" name="spouse_name" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth*</label>
                                    <input type="date" name="dob" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Anniversary Date</label>
                                    <input type="date" name="anniversary_date" class="form-control">
                                </div>
                            </div>

                            <!-- Third Row -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Profile Photo*</label>
                                    <input type="file" name="profile_photo" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Address Line 1</label>
                                    <input type="text" name="mailing_address_line_1" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Address Line 2</label>
                                    <input type="text" name="mailing_address_line_2" class="form-control">
                                </div>
                            </div>

                            <!-- Fourth Row -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Address Line 3</label>
                                    <input type="text" name="mailing_address_line_3" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mailing City</label>
                                    <input type="text" name="mailing_city" class="form-control" placeholder="City">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mailing State/Province</label>
                                    <input type="text" name="mailing_state" class="form-control">
                                </div>
                            </div>

                            <!-- Fifth Row -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Country</label>
                                    <input type="text" name="mailing_country" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mailing Zip/Postal Code</label>
                                    <input type="text" name="mailing_zip" class="form-control">
                                </div>
                            </div>
                            <!-- Next Button -->
                            <div class="row mt-4">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="button" class="btn custom-btn" id="nextToOfficial"
                                        style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5px;">
                                        Next
                                    </button>
                                </div>
                            </div>



                        </div>

                        <!-- Official Tab -->
                        <div class="tab-pane fade" id="official" role="tabpanel">

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Parent Multiple District*</label>
                                    <select name="parent_multiple_district" id="parent_multiple_district"
                                        class="form-control" required>
                                        <option value="">Select Multiple District</option>
                                        @foreach ($parentMultipleDistricts as $multipleDistrict)
                                            <option value="{{ $multipleDistrict->id }}">{{ $multipleDistrict->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Parent District*</label>
                                    <select name="parent_district" id="parent_district" class="form-control" required>
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Account Name*</label>
                                    <select name="account_name" class="form-control" required>
                                        <option value="">Select Account</option>
                                        @foreach ($chapters as $chapter)
                                            <option value="{{ $chapter->id }}">
                                                {{ \Illuminate\Support\Str::title(strtolower($chapter->chapter_name)) }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="form-label">Preferred Email*</label>
                                    <select name="preferred_email" class="form-control" id="preferredEmail" required>
                                        <option value="">Select Email</option>
                                        <option value="personal">Personal</option>
                                        <option value="official">Official</option>

                                    </select>
                                </div>
                                <div class="col-md-3" id="emailInputDiv">
                                    <label class="form-label">Personal Email</label>
                                    <input type="email" name="email_address" class="form-control" id="emailInput">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Work Email</label>
                                    <input type="email" name="work_email" class="form-control" id="workEmail">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Alternate Email</label>
                                    <input type="email" name="alternate_email" class="form-control"
                                        id="alternateEmail">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="form-label">Preferred Phone*</label>
                                    <select name="preferred_phone" class="form-control" id="preferredPhone" required>
                                        <option value="">Select Phone</option>
                                        <option value="mobile">Mobile</option>
                                        <option value="home">Home</option>
                                        <option value="work">Work</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="phone_number" class="form-control" id="mobileNumber"
                                        maxlength="10" pattern="\d{10}" title="Enter 10-digit number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Home Number</label>
                                    <input type="text" name="home_number" class="form-control" id="homeNumber"
                                        maxlength="10" pattern="\d{10}" title="Enter 10-digit number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Work Number</label>
                                    <input type="text" name="work_number" class="form-control" id="workNumber"
                                        maxlength="10" pattern="\d{10}" title="Enter 10-digit number"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                </div>

                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label class="form-label">Member ID*</label>
                                    <input type="text" name="member_id" class="form-control" id="memberId" required>
                                    <small id="memberIdError" class="text-danger" style="display: none;">This ID already
                                        exists</small>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Membership Full Type*</label>
                                    <select name="membership_full_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        @foreach ($membershipTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="display: block;">Membership Type*</label>
                                    <select name="membership_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="Leo Club">Leo Club</option>
                                        <option value="Lions Club">Lions Club</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fax</label>
                                    <input type="text" name="fax" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Submit Button - only show on Official tab -->
                <div class="row mt-4" id="submitSection" style="display: none;">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn custom-btn"
                            style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5px;">
                            Save Member
                        </button>
                    </div>
                </div>



            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle tab switch
                document.getElementById('personal-tab').addEventListener('click', function() {
                    document.getElementById('submitSection').style.display = 'none';
                });

                document.getElementById('official-tab').addEventListener('click', function() {
                    document.getElementById('submitSection').style.display = 'block';
                });

                // Also handle the "Next" button to switch to Official tab
                document.getElementById('nextToOfficial').addEventListener('click', function() {
                    let officialTab = new bootstrap.Tab(document.querySelector('#official-tab'));
                    officialTab.show();
                    document.getElementById('submitSection').style.display = 'block';
                });
            });
        </script>
    @endpush
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('
                                                    success ') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // Handle 'Next' button click to switch tab
            $('#nextToOfficial').click(function() {
                $('#official-tab').tab('show');
                $('#submitSection').show(); // Show Save button
            });

            // If user switches back to Personal tab manually
            $('#personal-tab').on('click', function() {
                $('#submitSection').hide(); // Hide Save button again
            });

            // Your existing parent district AJAX
            $('#parent_multiple_district').change(function() {
                var multipleDistrictId = $(this).val();
                if (multipleDistrictId) {
                    $.ajax({
                        url: '{{ route('get.districts') }}',
                        type: 'GET',
                        data: {
                            parent_multiple_district_id: multipleDistrictId
                        },
                        success: function(data) {
                            $('#parent_district').empty().append(
                                '<option value="">Select District</option>');
                            $.each(data, function(key, district) {
                                $('#parent_district').append('<option value="' +
                                    district.id + '">' + district.name + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#parent_district').empty().append('<option value="">Select District</option>');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#preferredPhone').change(function() {
                let selectedValue = $(this).val();
                if (selectedValue) {
                    $('#phoneInputDiv').show();
                } else {
                    $('#phoneInputDiv').hide();
                    $('#phoneNumber').val('');
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let preferredEmail = document.getElementById("preferredEmail");
            let emailInputDiv = document.getElementById("emailInputDiv");

            preferredEmail.addEventListener("change", function() {
                if (this.value === "official" || this.value === "personal") {
                    emailInputDiv.style.display = "block";
                } else {
                    emailInputDiv.style.display = "none";
                }
            });
        });
    </script>




    <script>
        // Handle Preferred Email Logic
        document.getElementById('preferredEmail').addEventListener('change', function() {
            let workEmail = document.getElementById('workEmail');
            if (this.value === 'official') {
                workEmail.removeAttribute('disabled');
            } else {
                workEmail.setAttribute('disabled', 'disabled');
            }
        });

        // Handle Preferred Phone Logic
        document.getElementById('preferredPhone').addEventListener('change', function() {
            let phoneInputs = document.querySelectorAll('.phone-input');
            phoneInputs.forEach(input => input.setAttribute('disabled', 'disabled'));
            document.getElementById(this.value + 'Phone').removeAttribute('disabled');

        });
    </script>


    <script>
        document.getElementById("memberId").addEventListener("keyup", function() {
            let memberId = this.value;
            let errorMsg = document.getElementById("memberIdError");

            if (memberId.length > 0) {
                fetch("{{ route('members.checkMemberId') }}?member_id=" + memberId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            errorMsg.style.display = "inline";
                        } else {
                            errorMsg.style.display = "none";
                        }
                    });
            } else {
                errorMsg.style.display = "none";
            }
        });
    </script>


    <script>
        document.getElementById("preferredEmail").addEventListener("change", function() {
            let preferredType = this.value;
            let personalEmail = document.getElementById("emailInput");
            let workEmail = document.getElementById("workEmail");

            // Reset all fields to be enabled first
            personalEmail.disabled = false;
            workEmail.disabled = false;

            if (preferredType === "official") {
                personalEmail.disabled = true; // Disable personal email
            } else if (preferredType === "personal") {
                workEmail.disabled = true; // Disable work email
            }
        });
    </script>
    <script>
        document.getElementById("preferredPhone").addEventListener("change", function() {
            let preferredType = this.value;
            let mobileNumber = document.getElementById("mobileNumber");
            let homeNumber = document.getElementById("homeNumber");
            let workNumber = document.getElementById("workNumber");

            // Enable all fields initially
            mobileNumber.disabled = false;
            homeNumber.disabled = false;
            workNumber.disabled = false;

            // Handle selection logic
            if (preferredType === "mobile") {
                homeNumber.disabled = true; // Disable home, enable mobile + work
            } else if (preferredType === "home") {
                mobileNumber.disabled = true; // Disable mobile, enable home + work
            } else if (preferredType === "work") {
                homeNumber.disabled = true; // Disable home, enable work + mobile
            }
        });
    </script>
@endsection
