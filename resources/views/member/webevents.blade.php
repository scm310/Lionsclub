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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthLinks = document.querySelectorAll(".month-link");
        const eventRows = document.querySelectorAll(".event-row");
        const eventsContainer = document.getElementById("completedEventsList");

        function filterCompletedEvents(selectedMonth) {
            let hasEvents = false;

            eventRows.forEach(row => {
                if (row.getAttribute("data-month") === selectedMonth) {
                    row.style.display = "block";
                    hasEvents = true;
                } else {
                    row.style.display = "none";
                }
            });


            document.getElementById("noCompletedEvents")?.remove();


            if (!hasEvents) {
                const noDataMessage = document.createElement("p");
                noDataMessage.id = "noCompletedEvents";
                noDataMessage.className = "text-light text-start w-100 pe-4 fs-6";
                noDataMessage.textContent = "No events were conducted.";
                eventsContainer.appendChild(noDataMessage);
            }
        }

        monthLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                monthLinks.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                const selectedMonth = this.getAttribute("data-month");
                filterCompletedEvents(selectedMonth);
            });
        });

        const currentMonth = new Date().toLocaleString('default', { month: 'long' });
        const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

        if (currentMonthButton) {
            currentMonthButton.classList.add("active");
            filterCompletedEvents(currentMonth);
        }
    });
</script>










@endsection
