@extends('MasterAdmin.layout')

@section('content')

<style>
    .container1 {
        background-color:#87cefa;
                padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 40px auto;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
            margin: 20px;
            width: 342px;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 1rem;
            margin: 10px;
            width: 342px;
        }

        .custom-btn {
                    font-size: 14px;
            padding: 8px 16px;
            width: 66%;
            border-radius: 5%;
            margin-left: -7px;
        }
    }


    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        color: white;
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
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

</style>


    <div class="container mt-4 ">
        <div class="white-container">
            <h3 class="mb-3 custom-heading"> Edit Event</h3>

            <a href="{{ route('event_index') }}" class="text-decoration-none back-arrow mb-3 d-inline-block">← Back</a>

            @if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

    <div class="container1">
    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- important for PUT update -->

    <div class="row">
        <!-- Row 1 -->
        <div class="col-md-3 mb-3">
            <label class="form-label">Event Name</label>
            <input type="text" class="form-control" name="event_name" value="{{ $event->event_name }}" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activity Level</label>
            <input type="text" class="form-control" name="activity_level" value="{{ $event->activity_level }}" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Multiple District</label>
            <select name="multiple_district_id" class="form-control" required>
                <option value="">Select Multiple District</option>
                @foreach($multipleDistricts as $district)
                    <option value="{{ $district->id }}" {{ $event->multiple_district_id == $district->id ? 'selected' : '' }}>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">District</label>
            <select name="district_id" class="form-control" required>
                <option value="">Select District</option>
                @foreach($districts as $dist)
                    <option value="{{ $dist->id }}" {{ $event->district_id == $dist->id ? 'selected' : '' }}>
                        {{ $dist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Club</label>
            <select name="club_id" class="form-control" required>
                <option value="">Select Club</option>
                @foreach($clubs as $club)
                    <option value="{{ $club->id }}" {{ $event->club_id == $club->id ? 'selected' : '' }}>
                        {{ $club->chapter_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Row 2 -->
        <div class="col-md-3 mb-3">
            <label class="form-label">Creator</label>
            <input type="text" class="form-control" name="creator" value="{{ $event->creator }}" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activity Duration</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" name="activity_duration" value="Single Day" class="form-check-input"
                    {{ $event->activity_duration == 'Single Day' ? 'checked' : '' }} required>
                <label class="form-check-label">Single Day</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="activity_duration" value="Multiple Day" class="form-check-input"
                    {{ $event->activity_duration == 'Multiple Day' ? 'checked' : '' }}>
                <label class="form-check-label">Multiple Day</label>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" value="{{ $event->start_date }}" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" value="{{ $event->end_date }}" required>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activity Type</label>
            <select name="activity_type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Service Activity" {{ $event->activity_type == 'Service Activity' ? 'selected' : '' }}>Service Activity</option>
                <option value="Fundraiser" {{ $event->activity_type == 'Fundraiser' ? 'selected' : '' }}>Fundraiser</option>
                <option value="Meeting" {{ $event->activity_type == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                <option value="Donation" {{ $event->activity_type == 'Donation' ? 'selected' : '' }}>Donation</option>
            </select>
        </div>

        <!-- Row 3 -->
        <div class="col-md-3 mb-3">
            <label class="form-label">Cause</label>
            <select name="cause" class="form-control" required>
                <option value="">Select Cause</option>
                <option value="Honor" {{ $event->cause == 'Honor' ? 'selected' : '' }}>Honor</option>
                <option value="Environment" {{ $event->cause == 'Environment' ? 'selected' : '' }}>Environment</option>
                <option value="Childhood Cancer" {{ $event->cause == 'Childhood Cancer' ? 'selected' : '' }}>Childhood Cancer</option>
                <option value="Diabetics" {{ $event->cause == 'Diabetics' ? 'selected' : '' }}>Diabetics</option>
                <option value="Vision" {{ $event->cause == 'Vision' ? 'selected' : '' }}>Vision</option>
                <option value="Other" {{ $event->cause == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Total Volunteers</label>
            <input type="number" class="form-control" name="total_volunteers" value="{{ $event->total_volunteers }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ $event->description }}</textarea>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Change Invitation (optional)</label>
            <input type="file" class="form-control" name="event_invitation">
            @php
                $invitationImage = $event->event_invitation
                    ? asset('storage/app/public/event_invitations/' . $event->event_invitation)
                    : asset('storage/event_invitations/default-invitation.png');
            @endphp
            <p style="color: black; margin-top: 10px;">
                Current: <img src="{{ $invitationImage }}" width="100">
            </p>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-primary">Update Event</button>
    </div>
</form>

</div>
</div>
</div>


@endsection
