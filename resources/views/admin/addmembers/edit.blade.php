@extends('MasterAdmin.layout')

@section('content')
    <style>
        .nav-tabs .nav-link {
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            color: white;
            border: none;
            border-radius: 5px;
            margin: 0 5px;
            /* Adds spacing between tabs */
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            color: white;
            font-weight: bold;
            border-bottom: 3px solid yellow;
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

        /* This will apply the font-size to all elements inside .small-font */
        .small-font,
        .small-font input,
        .small-font select,
        .small-font textarea,
        .small-font label,
        .small-font button {
            font-size: 0.85rem;
        }


        a.custom-btn {
            display: inline-flex;
            /* Ensures `<a>` behaves like `<button>` */
            padding: 10px 20px;
        }

        label {
            color: black;
        }

        .custom-btn {
            background: linear-gradient(115deg, #0f0b8c, #77dcf5);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;

            transition: 0.3s;
        }

        .custom-btn:hover {
            background: linear-gradient(115deg, #0f0b8c, #77dcf5);
            color: white;
        }

        .cancel-btn {
            background: linear-gradient(115deg, #0f0b8c, #77dcf5);
            color: white;
            padding: 7px 20px;
            font-size: 16px;

            transition: 0.3s;
            border: none;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background: grey;
            color: white;
        }


        .card1 {
            background-color: #87cefa;
        }
    </style>
    <div class="container mt-4">
        <div class="white-container">
            <h3 class="mb-3 custom-heading">Edit Member </h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif



            <form class="small-font" action="{{ route('members.update', $member->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="memberTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal"
                            role="tab">Personal Details</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="official-tab" data-bs-toggle="tab" href="#official" role="tab">Official
                            Details</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="memberTabContent">
                    <!-- Personal Tab -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="card shadow rounded-3 p-4 mb-5" style="margin-top: -20px; background-color: #87cefa;">

                            <div class="row">
                                <div class="col-md-3">

                                    <label>Salutation*</label>
                                    <input type="text" name="salutation" class="form-control"
                                        value="{{ $member->salutation }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>First Name*</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $member->first_name }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Last Name*</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $member->last_name }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Suffix</label>
                                    <input type="text" name="suffix" class="form-control" value="{{ $member->suffix }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Spouse Name</label>
                                    <input type="text" name="spouse_name" class="form-control"
                                        value="{{ $member->spouse_name }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Date of Birth*</label>
                                    <input type="date" name="dob" class="form-control" value="{{ $member->dob }}"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label>Anniversary Date</label>
                                    <input type="date" name="anniversary_date" class="form-control"
                                        value="{{ old('anniversary_date', $member->anniversary_date ? \Carbon\Carbon::parse($member->anniversary_date)->format('Y-m-d') : '') }}">



                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Mailing Address Line 1</label>
                                    <input type="text" name="mailing_address_line_1" class="form-control"
                                        value="{{ $member->mailing_address_line_1 }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Mailing Address Line 2</label>
                                    <input type="text" name="mailing_address_line_2" class="form-control"
                                        value="{{ $member->mailing_address_line_2 }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Mailing Address Line 3</label>
                                    <input type="text" name="mailing_address_line_3" class="form-control"
                                        value="{{ $member->mailing_address_line_3 }}">
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Mailing City</label>
                                    <input type="text" name="mailing_city" class="form-control"
                                        value="{{ $member->mailing_city }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Mailing State/Province</label>
                                    <input type="text" name="mailing_state" class="form-control"
                                        value="{{ $member->mailing_state }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Mailing Country</label>
                                    <input type="text" name="mailing_country" class="form-control"
                                        value="{{ $member->mailing_country }}">
                                </div>
                            </div>


                            <div class="row mt-3 align-items-end">
                                <div class="col-md-4">
                                    <label>Zip Code</label>
                                    <input type="text" name="mailing_zip" class="form-control"
                                        value="{{ $member->mailing_zip }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Profile Photo*</label>
                                    <input type="file" name="profile_photo" class="form-control" >
                                </div>
                                <div class="col-md-4">
                                    @if ($member->profile_photo)
                                        <label>Current Photo</label><br>
                                        <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}"
                                            class="mt-2 rounded" width="50" alt="Profile Photo">
                                    @endif
                                </div>
                            </div>


                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn custom-btn" onclick="showOfficialTab()">Next</button>
                            </div>
                        </div>

                    </div>

                    <!-- Official Tab -->
                    <div class="tab-pane fade" id="official" role="tabpanel">
                        <div class="card shadow rounded-3 p-4 mb-5" style="margin-top: -20px; background-color: #87cefa;">

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Parent Multiple District*</label>
                                    <select name="parent_multiple_district" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($parentMultipleDistricts as $multipleDistrict)
                                            <option value="{{ $multipleDistrict->id }}"
                                                {{ $multipleDistrict->id == $member->parent_multiple_district ? 'selected' : '' }}>
                                                {{ $multipleDistrict->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Parent District*</label>
                                    <select name="parent_district" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $member->parent_district ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @php use Illuminate\Support\Str; @endphp

                                <div class="col-md-4">
                                    <label>Account Name*</label>
                                    <select name="account_name" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($chapters as $chapter)
                                            <option value="{{ $chapter->id }}"
                                                {{ $chapter->id == $member->account_name ? 'selected' : '' }}>
                                                {{ Str::title(strtolower($chapter->chapter_name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Preferred Email*</label>
                                    <select name="preferred_email" class="form-control">
                                        <option value="personal"
                                            {{ $member->preferred_email == 'personal' ? 'selected' : '' }}>Personal
                                        </option>
                                        <option value="official"
                                            {{ $member->preferred_email == 'official' ? 'selected' : '' }}>Official
                                        </option>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Personal Email</label>
                                    <input type="email" name="email_address" class="form-control"
                                        value="{{ $member->email_address }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Work Email</label>
                                    <input type="email" name="work_email" class="form-control"
                                        value="{{ $member->work_email }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Alternate Email</label>
                                    <input type="email" name="alternate_email" class="form-control"
                                        value="{{ $member->alternate_email }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Preferred Phone*</label>
                                    <select name="preferred_phone" class="form-control" required>
                                        <option value="mobile"
                                            {{ $member->preferred_phone == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                        <option value="home" {{ $member->preferred_phone == 'home' ? 'selected' : '' }}>
                                            Home</option>
                                        <option value="work" {{ $member->preferred_phone == 'work' ? 'selected' : '' }}>
                                            Work</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Mobile Number</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ $member->phone_number }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Home Number</label>
                                    <input type="text" name="home_number" class="form-control"
                                        value="{{ $member->home_number }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Work Number</label>
                                    <input type="text" name="work_number" class="form-control"
                                        value="{{ $member->work_number }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Member ID*</label>
                                    <input type="text" name="member_id" class="form-control"
                                        value="{{ $member->member_id }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Membership Full Type*</label>
                                    <select name="membership_full_type" class="form-control" required>
                                        @foreach ($membershipTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $type->id == $member->membership_full_type ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Fax</label>
                                    <input type="text" name="fax" class="form-control"
                                        value="{{ $member->fax }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Membership Type*</label>
                                    <select name="membership_type" class="form-control" required>
                                        <option value="Leo Club"
                                            {{ $member->membership_type == 'Leo Club' ? 'selected' : '' }}>Leo Club
                                        </option>
                                        <option value="Lions Club"
                                            {{ $member->membership_type == 'Lions Club' ? 'selected' : '' }}>Lions Club
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn custom-btn">Update Member</button>
                                <a href="{{ route('members.list') }}" class="btn cancel-btn">Cancel</a>
                            </div>


                        </div>
                    </div>


            </form>
        </div>
    </div>





    <script>
        function showOfficialTab() {
            const triggerEl = document.querySelector('#official-tab');
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Email fields logic
            const preferredEmailSelect = document.querySelector('select[name="preferred_email"]');
            const personalEmailInput = document.querySelector('input[name="email_address"]');
            const workEmailInput = document.querySelector('input[name="work_email"]');
            const alternateEmailInput = document.querySelector('input[name="alternate_email"]');

            function updateEmailFields() {
                if (preferredEmailSelect.value === 'official') {
                    // When "official" is selected, disable Personal Email
                    personalEmailInput.disabled = true;
                    workEmailInput.disabled = false;
                    alternateEmailInput.disabled = false;
                } else if (preferredEmailSelect.value === 'personal') {
                    // When "personal" is selected, disable Work Email
                    personalEmailInput.disabled = false;
                    workEmailInput.disabled = true;
                    alternateEmailInput.disabled = false;
                }
            }

            preferredEmailSelect.addEventListener('change', updateEmailFields);
            updateEmailFields();

            // Phone fields logic
            const preferredPhoneSelect = document.querySelector('select[name="preferred_phone"]');
            const mobileNumberInput = document.querySelector('input[name="phone_number"]');
            const homeNumberInput = document.querySelector('input[name="home_number"]');
            const workNumberInput = document.querySelector('input[name="work_number"]');

            function updatePhoneFields() {
                if (preferredPhoneSelect.value === 'work') {
                    // When "work" is selected:
                    // - Mobile Number remains enabled
                    // - Home Number is disabled
                    mobileNumberInput.disabled = false;
                    homeNumberInput.disabled = true;
                } else if (preferredPhoneSelect.value === 'home') {
                    // When "home" is selected:
                    // - Mobile Number is disabled
                    // - Home Number is enabled
                    mobileNumberInput.disabled = true;
                    homeNumberInput.disabled = false;
                } else if (preferredPhoneSelect.value === 'mobile') {
                    // When "mobile" is selected, enable both Mobile and Home Numbers
                    mobileNumberInput.disabled = false;
                    homeNumberInput.disabled = false;
                }
                // Work Number is always enabled
                workNumberInput.disabled = false;
            }

            preferredPhoneSelect.addEventListener('change', updatePhoneFields);
            updatePhoneFields();
        });
    </script>
@endsection
