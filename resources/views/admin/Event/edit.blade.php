@extends('MasterAdmin.layout')

@section('content')

<style>
    .container1 {
        background-color:#87cefa;
                padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
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
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container1">
    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" name="event_name" value="{{ $event->event_name }}" required>
        </div>

        @php
        $minDate = \Carbon\Carbon::tomorrow()->format('Y-m-d');
    @endphp

    <div class="mb-3">
        <label for="event_date" class="form-label">Event Date</label>
        <input type="date" class="form-control" name="event_date" value="{{ $event->event_date }}" min="{{ $minDate }}" required>
    </div>
        <div class="mb-3">
            <label for="event_invitation" class="form-label">Change Invitation (optional)</label>
            <input type="file" class="form-control" name="event_invitation">

            @php
                $invitationImage = $event->event_invitation
                    ? asset('storage/app/public/event_invitations/' . $event->event_invitation)
                    : asset('storage/app/public/event_invitations/default-invitation.png'); // default image path
            @endphp

            <p style="color: black; margin-top: 20px;">
                Current: <img src="{{ $invitationImage }}" width="100">
            </p>
        </div>


        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn custom-btn w-40 upload">Update Event</button>
        </div>
    </form>
</div>
</div>
</div>


@endsection
