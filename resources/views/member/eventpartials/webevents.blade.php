@extends('layouts.navbar')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
<style>
@media (min-width: 768px) {
    .completed-event-card {
        width: 225px !important;
    }
}

@media (max-width: 767.98px) {
    .completed-event-card {
        width: 155px !important;
    }
}

.sticky-tabs {
    position: sticky;
    background: #fff;
    top: 0;
    border-radius: 5px;
    width: -webkit-fill-available;
    transform: translateX(0px);
}
</style>

<div class="container " style="max-width: 1400px !important;">
    <!-- Full-Width Heading -->
    <div class="container"  style="max-width: 1400px !important; padding:0px;">
        <div class="d-flex justify-content-start sticky-tabs">
            <ul class="nav nav-pills flex-row ms-3" id="customTabs">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2-tab" data-bs-toggle="pill" href="#tab2">Upcoming Events</a>
                </li>
                &nbsp;
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1-tab" data-bs-toggle="pill" href="#tab1">Completed Events</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
    @include('member.eventpartials.completed-events')
    @include('member.eventpartials.upcoming-events')

    </div>

    <div class="py-5">

    </div>

</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
            tab.addEventListener("click", function() {
                let eventDetailsContainer = document.getElementById("eventDetailsContainer");
                if (eventDetailsContainer && !eventDetailsContainer.classList.contains("d-none")) {
                    eventDetailsContainer.classList.add("d-none");
                }
            });
        });
    });
</script>




@endsection
