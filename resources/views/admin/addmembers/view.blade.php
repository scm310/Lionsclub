@extends('MasterAdmin.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Member Details</h2>
    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-bordered table-sm">
            <tbody>
                <tr><th>Member ID</th><td>{{ $member->member_id }}</td></tr>
                <tr><th>Salutation</th><td>{{ $member->salutation }}</td></tr>
                <tr><th>First Name</th><td>{{ $member->first_name }}</td></tr>
                <tr><th>Last Name</th><td>{{ $member->last_name }}</td></tr>
                <tr><th>Suffix</th><td>{{ $member->suffix }}</td></tr>
                <tr><th>Spouse Name</th><td>{{ $member->spouse_name }}</td></tr>
                <tr><th>Date of Birth</th><td>{{ $member->dob }}</td></tr>
                <tr><th>Anniversary Date</th><td>{{ $member->anniversary_date }}</td></tr>
                <tr><th>Mailing Address</th><td>{{ $member->mailing_address_line_1 }}, {{ $member->mailing_address_line_2 }}, {{ $member->mailing_address_line_3 }}</td></tr>
                <tr><th>City</th><td>{{ $member->mailing_city }}</td></tr>
                <tr><th>State</th><td>{{ $member->mailing_state }}</td></tr>
                <tr><th>Country</th><td>{{ $member->mailing_country }}</td></tr>
                <tr><th>Zip Code</th><td>{{ $member->mailing_zip }}</td></tr>
                <tr><th>Preferred Email</th><td>{{ $member->preferred_email }}</td></tr>
                <tr><th>Email</th><td>{{ $member->email_address }}</td></tr>
                <tr><th>Work Email</th><td>{{ $member->work_email }}</td></tr>
                <tr><th>Alternate Email</th><td>{{ $member->alternate_email }}</td></tr>
                <tr><th>Preferred Phone</th><td>{{ $member->preferred_phone }}</td></tr>
                <tr><th>Mobile Number</th><td>{{ $member->phone_number }}</td></tr>
                <tr><th>Work Number</th><td>{{ $member->work_number }}</td></tr>
                <tr><th>Home Number</th><td>{{ $member->home_number }}</td></tr>
                <tr><th>Fax</th><td>{{ $member->fax }}</td></tr>
                <tr><th>Membership Type</th><td>{{ $member->membership_full_type }}</td></tr>
                <tr><th>Profile Photo</th>
                    <td>
                        @if($member->profile_photo)
                            <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}" alt="Profile Photo" class="img-thumbnail" width="80">
                        @else
                            No Photo Available
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
