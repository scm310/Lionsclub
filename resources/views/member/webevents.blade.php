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
</style>

<div class="container " style="max-width: 1400px !important;">
    <!-- Full-Width Heading -->
    <div class="container">
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
    @include('member.eventpartials.completed-events', ['completedEvents' => $completedEvents])
    @include('member.eventpartials.upcoming-events', ['completedEvents' => $completedEvents])

    </div>

</div>

<script>
   document.addEventListener("DOMContentLoaded", function() {
    // Only attach click to .event-card elements NOT inside #eventDetailsContainer
    document.querySelectorAll(".event-card:not(#eventDetailsContainer .event-card)").forEach(card => {
        card.addEventListener("click", function(e) {
            e.preventDefault();
            console.log("Event card clicked!");

            let detailsContainer = document.getElementById("eventDetailsContainer");

            // Fill in event details
            document.getElementById("detailEventName").innerText = this.getAttribute("data-event-name") || "N/A";
            document.getElementById("detailEventDate").innerText = this.getAttribute("data-event-date") || "N/A";
            document.getElementById("detailEventVenue").innerText = this.getAttribute("data-event-venue") || "N/A";
            document.getElementById("detailEventDetails").innerText = this.getAttribute("data-event-details") || "N/A";

            // Populate images
            let imageContainer = document.getElementById("eventImagesContainer");
            imageContainer.innerHTML = "";

            let eventImages;
            try {
                eventImages = JSON.parse(this.getAttribute("data-event-images") || "[]");
            } catch (err) {
                eventImages = [];
                console.error("Image parse error:", err);
            }

            if (eventImages.length > 0) {
                eventImages.forEach(imgSrc => {
                    let imgElement = document.createElement("img");
                    imgElement.src = `/storage/app/public/${imgSrc}`;
                    imgElement.classList.add("event-image");
                    imgElement.style.cursor = "pointer";
                    imgElement.style.width = "80px";
                    imgElement.style.height = "80px";
                    imgElement.style.borderRadius = "5px";
                    imgElement.style.margin = "5px";
                    imgElement.style.objectFit = "cover";

                    imgElement.addEventListener("click", function(event) {
                        event.stopPropagation(); // Stop image click from triggering parent
                        let selectedImage = encodeURIComponent(imgSrc);
                        window.location.href = `/member-gallery/?highlight=${selectedImage}`;
                    });

                    imageContainer.appendChild(imgElement);
                });
            }

            // Show the detail container
            detailsContainer.classList.remove("d-none");
        });
    });

    // Close button
    document.getElementById("closeEventDetails").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("eventDetailsContainer").classList.add("d-none");
    });
});

</script>

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
        const eventsContainer = document.getElementById("completedEventsList"); // Make sure this ID is correct

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

            // Remove existing "No events" message
            document.getElementById("noCompletedEvents")?.remove();

            // If no events, show message
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

                // Remove 'active' class from all month links
                monthLinks.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                const selectedMonth = this.getAttribute("data-month");
                filterCompletedEvents(selectedMonth);
            });
        });

        // Auto-select and filter the current month on page load
        const currentMonth = new Date().toLocaleString('default', { month: 'long' });
        const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

        if (currentMonthButton) {
            currentMonthButton.classList.add("active");
            filterCompletedEvents(currentMonth);
        }
    });
</script>



<script>
    function showUpcomingEventDetails(eventCard) {
        let eventName = eventCard.getAttribute("data-name");
        let eventDate = eventCard.getAttribute("data-date");
        let eventImageUrl = eventCard.getAttribute("data-image");

        document.getElementById("upcomingEventName").innerText = eventName;
        document.getElementById("upcomingEventDate").innerText = eventDate;

        let imgElement = document.getElementById("upcomingEventInvitationImage");

        if (eventImageUrl && eventImageUrl.trim() !== "") {
            imgElement.src = eventImageUrl;
            imgElement.onerror = function() {
                imgElement.src = 'assets/images/default-placeholder.jpeg';
            };
            document.getElementById("upcomingEventInvitationContainer").classList.remove("d-none");
        } else {
            document.getElementById("upcomingEventInvitationContainer").classList.add("d-none");
        }

        let detailsContainer = document.getElementById("upcomingEventDetails");
        detailsContainer.classList.remove("d-none");

        // Prevent multiple event listeners
        document.removeEventListener("click", closeDetailsOnOutsideClick);
        setTimeout(() => {
            document.addEventListener("click", closeDetailsOnOutsideClick);
        }, 100);
    }

    // Function to close the details when clicking outside
    function closeDetailsOnOutsideClick(event) {
        let detailsContainer = document.getElementById("upcomingEventDetails");
        let eventCards = document.querySelectorAll(".upcoming-event-card");

        let isClickInsideDetails = detailsContainer.contains(event.target);
        let isClickOnCard = Array.from(eventCards).some(card => card.contains(event.target));

        if (!isClickInsideDetails && !isClickOnCard) {
            detailsContainer.classList.add("d-none");
            document.removeEventListener("click", closeDetailsOnOutsideClick);
        }
    }

    // Close button functionality
    document.getElementById("closeUpcomingEventDetails").addEventListener("click", function() {
        document.getElementById("upcomingEventDetails").classList.add("d-none");
        document.removeEventListener("click", closeDetailsOnOutsideClick);
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthLinks = document.querySelectorAll(".month-link");
        const eventRows = document.querySelectorAll(".event-row");
        const eventsContainer = document.getElementById("upcomingEventsList");

        function filterUpcomingEvents(selectedMonth) {
            let hasEvents = false;

            eventRows.forEach(row => {
                if (row.getAttribute("data-month") === selectedMonth) {
                    row.style.display = "block";
                    hasEvents = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Remove existing "No events" message if present
            document.getElementById("noUpcomingEvents")?.remove();

            if (!hasEvents) {
                const noDataMessage = document.createElement("p");
                noDataMessage.id = "noUpcomingEvents";
                noDataMessage.className = "text-muted";
                noDataMessage.innerText = "No upcoming events available.";
                eventsContainer.appendChild(noDataMessage);
            }
        }

        monthLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove 'active' class from all month links
                monthLinks.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                // Get selected month and filter events
                const selectedMonth = this.getAttribute("data-month");
                filterUpcomingEvents(selectedMonth);
            });
        });

        // Auto-select and filter the current month on page load
        const currentMonth = new Date().toLocaleString('default', {
            month: 'long'
        });
        const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

        if (currentMonthButton) {
            currentMonthButton.classList.add("active"); // Ensure it's marked active
            filterUpcomingEvents(currentMonth); // Show only current month events
        }
    });
</script>

<script>
    function showCompletedEventDetails(card) {
        // Get event details from the clicked card
        const eventId = card.getAttribute('data-event-id');
        const eventName = card.getAttribute('data-event-name');
        const eventDate = card.getAttribute('data-event-date');
        const eventVenue = card.getAttribute('data-event-venue');
        const eventDetails = card.getAttribute('data-event-details');
        const eventImages = JSON.parse(card.getAttribute('data-event-images'));

        // Populate the modal with event details
        document.getElementById('detailEventName').textContent = eventName;
        document.getElementById('detailEventDate').textContent = eventDate;
        document.getElementById('detailEventVenue').textContent = eventVenue;
        document.getElementById('detailEventDetails').textContent = eventDetails;

        // Show images in the modal if any
        const imagesContainer = document.getElementById('eventImagesContainer');
        imagesContainer.innerHTML = ''; // Clear existing images
        eventImages.forEach(image => {
            const imgElement = document.createElement('img');
            imgElement.src = `{{ asset('storage/app/public/') }}/${image}`;
            imgElement.alt = 'Event Image';
            imgElement.style = 'width: 100px; height: 100px; object-fit: cover; margin: 5px;';
            imagesContainer.appendChild(imgElement);
        });

        // Show the modal
        document.getElementById('eventDetailsContainer').classList.remove('d-none');
    }

    function closeEventDetails() {
        // Hide the modal
        document.getElementById('eventDetailsContainer').classList.add('d-none');
    }
</script>

@endsection
