@extends('memberlayout.sidebar')
@section('content')
<style>
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
</style>
<div class="container mt-4">
    <div class="card shadow-lg p-4 bg-white rounded">
        <!-- Profile Header Strip -->
        <h3 class="mb-0 custom-heading">Member Profile</h3>


        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
        @endif


        <!-- Nav Tabs -->
        <ul class="nav nav-tabs flex-wrap flex-start border-0 mt-2" id="profileTabs" role="tablist">
            <li class="nav-item m-0">
                <a class="nav-link active text-white  text-center custom-tab" id="tab-personal" data-toggle="tab" href="#personal" role="tab"
                    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; border-top-right-radius: 19px;">Member Details</a>
            </li>

            <!-- ✅ New Company Details Tab -->
            <li class="nav-item m-0">
                <a class="nav-link text-white  text-center custom-tab" id="tab-company" data-toggle="tab" href="#company" role="tab"
                    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; border-top-right-radius: 19px;">Company Details</a>
            </li>

            <li class="nav-item m-0">
                <a class="nav-link text-white  text-center custom-tab" id="tab-product" data-toggle="tab" href="#product" role="tab"
                    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; border-top-right-radius: 19px;">Product</a>
            </li>

            <li class="nav-item m-0">
                <a class="nav-link text-white  text-center custom-tab" id="tab-Service" data-toggle="tab" href="#Service" role="tab"
                    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; border-top-right-radius: 19px;">Service</a>
            </li>

            <li class="nav-item m-0">
                <a class="nav-link text-white  text-center custom-tab" id="tab-project" data-toggle="tab" href="#project" role="tab"
                    style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none; border-top-right-radius: 19px;">Project</a>
            </li>


        </ul>



        <!-- Tab Content -->
        <div class="tab-content mt-3">

            <!-- Parent & Account Details -->
            <div class="tab-pane fade " id="parent" role="tabpanel">
                <div class="container p-4" style=" background-color:#87cefa; border-radius: 8px;">
                    <form action="{{ route('member.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>Parent Multiple District</label>
                                <input type="text" class="form-control" value="{{ $parentMultipleDistrict }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Parent District</label>
                                <input type="text" class="form-control" value="{{ $parentDistrict }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Club Name</label>
                                <input type="text" class="form-control" value="{{ $accountName }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Membership Full Type</label>
                                <input type="text" class="form-control" value="{{ $membershipFullType }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Membership Type</label>
                                <input type="text" name="membership_type" class="form-control" value="{{ old('membership_type', $member->membership_type) }}" readonly>
                            </div>
                        </div>
                        <!-- Centered Update Button -->
                        <div class="text-center mt-4">
                            <!-- <button type="submit" class="btn text-white px-4 py-2" style="background-color: #003366; border-radius: 6px;">
                        Update
                    </button> -->
                        </div>

                </div>
            </div>


            <!-- Personal Details -->
            <div class="tab-pane fade  show active" id="personal" role="tabpanel">
                <div class="container p-4" style=" background-color:#87cefa;border-radius: 8px;">

                    @csrf

                    <div class="row">
                        <div class="col-md-3"><label>Member ID</label><input type="text" class="form-control" value="{{ $member->member_id }}" readonly></div>
                        <div class="col-md-3"><label>Salutation</label><input type="text" name="salutation" class="form-control" value="{{ old('salutation', $member->salutation) }}"></div>
                        <div class="col-md-3"><label>First Name *</label><input type="text" name="first_name" class="form-control" value="{{ old('first_name', $member->first_name) }}" required></div>
                        <div class="col-md-3"><label>Last Name *</label><input type="text" name="last_name" class="form-control" value="{{ old('last_name', $member->last_name) }}" required></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label>Suffix</label><input type="text" name="suffix" class="form-control" value="{{ old('suffix', $member->suffix) }}"></div>
                        <div class="col-md-3"><label>Spouse Name</label><input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name', $member->spouse_name) }}"></div>
                        <div class="col-md-3"><label>Date of Birth</label><input type="date" name="dob" class="form-control" value="{{ old('dob', $member->dob) }}"></div>
                        <div class="col-md-3"><label>Anniversary Date</label><input type="date" name="anniversary_date" class="form-control" value="{{ old('anniversary_date', \Carbon\Carbon::parse($member->anniversary_date)->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <!-- ✅ Profile Photo Upload Section -->
                    <div class="row mt-3">
                        <!-- Upload Field -->
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="profile_photo">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                            <small class="form-text text-muted">Note: Image Size 80x80 pixels</small>
                        </div>

                        <!-- Display Image -->
                        <div class="col-12 col-md-4 d-flex align-items-center">
                            @if($member->profile_photo)
                            <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}" width="80" class="rounded shadow border">
                            @endif
                        </div>
                    </div>







                    @csrf




                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <label>Mailing Address Line 1</label>
                            <input type="text" name="mailing_address_line_1" class="form-control" value="{{ old('mailing_address_line_1', $member->mailing_address_line_1) }}">
                        </div>
                        <div class="col-md-4">
                            <label>Mailing Address Line 2</label>
                            <input type="text" name="mailing_address_line_2" class="form-control" value="{{ old('mailing_address_line_2', $member->mailing_address_line_2) }}">
                        </div>
                        <div class="col-md-4">
                            <label>Mailing Address Line 3</label>
                            <input type="text" name="mailing_address_line_3" class="form-control" value="{{ old('mailing_address_line_3', $member->mailing_address_line_3) }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>City</label>
                            <input type="text" name="mailing_city" class="form-control" value="{{ old('mailing_city', $member->mailing_city) }}">
                        </div>
                        <div class="col-md-3">
                            <label>State</label>
                            <input type="text" name="mailing_state" class="form-control" value="{{ old('mailing_state', $member->mailing_state) }}">
                        </div>
                        <div class="col-md-3">
                            <label>Country</label>
                            <input type="text" name="mailing_country" class="form-control" value="{{ old('mailing_country', $member->mailing_country) }}">
                        </div>
                        <div class="col-md-3">
                            <label>ZIP Code</label>
                            <input type="text" name="mailing_zip" class="form-control" value="{{ old('mailing_zip', $member->mailing_zip) }}">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <label>Personal Address</label>
                            <input type="email" name="email_address" class="form-control" value="{{ old('email_address', $member->email_address) }}">
                        </div>
                        <div class="col-md-3">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $member->phone_number) }}">
                        </div>
                        <div class="col-md-3">
                            <label>Alternative Number</label>
                            <input type="text" name="work_number" class="form-control" value="{{ old('work_number', $member->work_number) }}">
                        </div>

                    </div>



                    <!-- ✅ Centered Update Button with Custom Color -->
                    <!-- Centered Update Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn text-white px-4 py-2" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-radius: 5px; color: #fff; border: none;">
                            Update
                        </button>
                    </div>
                    </form>
                </div>
            </div>









            <div class="tab-pane fade" id="project" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">

                    @include('member.partials.project')

                </div>
            </div>


            <div class="tab-pane fade" id="product" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
                    @include('member.partials.products')

                </div>
            </div>


            <div class="tab-pane fade" id="clients" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
                    @include('member.partials.clients')

                </div>
            </div>


            <div class="tab-pane fade" id="company" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
                    @include('member.partials.company')

                </div>
            </div>

            <div class="tab-pane fade" id="testimonials" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
                    @include('member.partials.testimonials')

                </div>
            </div>

            <div class="tab-pane fade" id="Service" role="tabpanel">
                <div class="container p-4" style="background-color:#87cefa; border-radius: 8px;">
                    @include('member.partials.Service')

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (needed for tabs) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const preferredEmail = document.getElementById("preferred_email");
        const workEmailInput = document.getElementById("work_email");

        const preferredPhone = document.querySelector('select[name="preferred_phone"]');
        const phoneInput = document.querySelector('input[name="phone_number"]');
        const workNumberInput = document.querySelector('input[name="work_number"]');
        const homeNumberInput = document.querySelector('input[name="home_number"]');

        function toggleEmailFields() {
            const selectedEmail = preferredEmail.value;

            if (selectedEmail === 'official') {
                workEmailInput.readOnly = false;
                workEmailInput.removeAttribute("disabled");
                document.querySelector('input[name="email_address"]').readOnly = true;
            } else if (selectedEmail === 'personal') {
                workEmailInput.readOnly = true;
                workEmailInput.setAttribute("disabled", true);
                document.querySelector('input[name="email_address"]').readOnly = false;
            } else {
                workEmailInput.readOnly = false;
                document.querySelector('input[name="email_address"]').readOnly = false;
            }
        }

        function togglePhoneFields() {
            const selectedPhone = preferredPhone.value;

            // Reset all to enabled
            phoneInput.disabled = false;
            workNumberInput.disabled = false;
            homeNumberInput.disabled = false;

            if (selectedPhone === 'mobile' || selectedPhone === 'personal') {
                workNumberInput.disabled = true;
            } else if (selectedPhone === 'work') {
                phoneInput.disabled = true;
            } else if (selectedPhone === 'home') {
                phoneInput.disabled = true;
                workNumberInput.disabled = true;
            }
        }

        toggleEmailFields();
        togglePhoneFields();

        preferredEmail.addEventListener("change", toggleEmailFields);
        preferredPhone.addEventListener("change", togglePhoneFields);
    });
</script>



@endsection