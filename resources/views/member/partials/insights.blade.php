@extends('memberlayout.sidebar')

@section('content')

<!-- Include Custom Style -->
<style>
    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        width: 100%;
    }

    .advertisers-service-sec .col {
        padding: 1em;
        text-align: center;
    }

    .service-card {
        width: 100%;
        height: 100%;
        padding: 2em 1.5em;
        border-radius: 5px;
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        transition: 0.5s;
        position: relative;
        z-index: 2;
        overflow: hidden;
        background: #fff;
    }

    .service-card::after {
        content: "";
        width: 100%;
        height: 100%;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        position: absolute;
        left: 0;
        top: -98%;
        z-index: -1;
        transition: all 0.4s cubic-bezier(0.77, -0.04, 0, 0.99);
    }

    .service-card:hover:after {
        top: 0;
    }

    .service-card:hover h5,
    .service-card:hover p,
    .service-card:hover small {
        color: #fff;
    }

    .service-card h5 {
        font-size: 20px;
        font-weight: 600;
        color: #1f194c;
        margin-bottom: 10px;
    }

    .service-card p,
    .service-card small {
        color: #575a7b;
        font-size: 15px;
        line-height: 1.5;
    }
</style>

<div class="container mt-4 advertisers-service-sec">
    <div class="card shadow-lg p-4 bg-white rounded">
        <h3 class="mb-4 custom-heading">My Club Insights</h3>
        <div class="row">
    @forelse($events as $event)
        <div class="col-md-4 mb-4">
            <div class="service-card">
                <h5>{{ $event->event_name }}</h5>

                <p><strong>Invitation:</strong></p>
                @if($event->event_invitation)
                    <img src="{{ asset('storage/app/public/event_invitations/' .$event->event_invitation) }}" alt="Event Invitation" style="max-width: 50%; height: auto; border: 1px solid #ccc; padding: 5px;">
                @else
                    <p>No invitation image available.</p>
                @endif
                <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</p>
                <p><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</p>
                <p><strong>Activity Type:</strong> {{ $event->activity_type }}</p>
                <p><strong>Cause:</strong> {{ $event->cause }}</p>
                <p><strong>Total Volunteers:</strong> {{ $event->total_volunteers }}</p>
            
            </div>
        </div>
    @empty
        <p>No events found for your profile.</p>
    @endforelse
</div>

    </div>
</div>
@endsection
