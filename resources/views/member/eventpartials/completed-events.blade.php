 <!-- Completed Events Tab -->
 <div class="tab-pane fade {{ $activeTab === 'tab1' ? 'show active' : '' }}" id="tab1">
     <!-- Sticky Header for Completed Events -->
     <div class="sticky-header text-white py-3 px-2"
         style="position: sticky; top: 180px; z-index: 1020; background: linear-gradient(115deg, #0f0b8c, #77dcf5);">

         <h3 class="fw-bold text-white d-flex align-items-center mb-2">
             Completed Events
             @if($completedEvents->isNotEmpty())
             <span class="fw-bold text-white ms-3">{{ now()->year }}</span>
             @endif
         </h3>

         <div class="mb-0 d-flex flex-wrap gap-2">
             @php
             $currentMonthIndex = now()->format('n'); // Current month number (1–12)
             $currentMonth = now()->format('F');
             $months = [
             'January', 'February', 'March', 'April', 'May', 'June',
             'July', 'August', 'September', 'October', 'November', 'December'
             ];
             @endphp

             @foreach($months as $index => $month)
             @if($index < $currentMonthIndex)
                 <a href="#" class="month-link btn btn-outline-light btn-sm
            {{ $month === $currentMonth ? 'active' : '' }}"
                 data-month="{{ $month }}">
                 {{ $month }}
                 </a>
                 @endif
                 @endforeach
         </div>
     </div>


     <!-- Completed Events List -->
     <div id="completedEventsList" class="row gx-3 gy-3">
         @forelse($completedEvents as $event)
         @php
         $eventMonth = \Carbon\Carbon::parse($event->event_date)->format('F');
         @endphp

         <div class="event-row cards_item col-6 col-lg-auto" data-month="{{ $eventMonth }}" style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
             <div class="card1 completed-event-card rounded shadow-sm d-flex flex-column justify-content-center align-items-center"
                 tabindex="0"
                 style="width:225px; height:195px; cursor: pointer; border: 2px solid #ffcc00; background:#fff; transition: transform 0.3s ease-in-out;"
                 data-event-id="{{ $event->id }}"
                 data-event-name="{{ $event->event_name }}"
                 data-event-date="{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}"
                 data-event-venue="{{ $event->venue }}"
                 data-event-details="{{ $event->details }}"
                 data-event-images="{{ json_encode($event->images) }}"
                 onclick="showCompletedEventDetails(this)">

                 @php
                 $images = is_array($event->images) ? $event->images : json_decode($event->images, true);
                 $images = is_array($images) ? $images : [];
                 $firstImage = isset($images[0]) && !empty($images[0])
                 ? asset('storage/app/public/' . $images[0])
                 : asset('assets/images/default2.png');
                 @endphp

                 @if($firstImage)
                 <div class="card_image1">
                     <img src="{{ $firstImage }}" alt="Event Image" style="width:100%; height:100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                 </div>
                 @endif


                 <div class="card_content text-center p-2">
                    <h2 class="card_title text-dark" style="font-size:12px; font-weight: bold;">
                        {{ $event->event_name }}</h2>
                    <p class="card_text text-muted" style="font-size:10px; margin-bottom: 5px;">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('l, M d, Y') }}
                    </p>
                </div>
             </div>
         </div>
         @empty
         <h3></h3>
         @endforelse
     </div>



 </div>


{{-- right side popupcard completed Event --}}



 <div id="eventDetailsContainer" class="position-fixed top-0 end-0 shadow-lg p-4 d-none"
     style="width: 400px; height:60vh; z-index: 1055; overflow-y: auto;
            margin-top:240px;
             border-top-left-radius: 20px; border-bottom-left-radius: 20px;">

     <button class="btn-close position-absolute top-0 end-0 m-1" id="closeEventDetails" onclick="closeEventDetails()"></button>
     <div id="eventImagesContainer" class="d-flex justify-content-center gap-2 mb-3"></div>

     <div class="event-card p-3 rounded shadow-sm bg-white" style="background: linear-gradient(120deg, #ffd700, #ffe680, #aeeffb);">
         <h5 class="fw-bold text-center">Event Details</h5>
         <p><strong style="font-size:12px;">Name:</strong> <span id="detailEventName" style="font-size:12px;"></span></p>
         <p><strong style="font-size:12px;">Date:</strong> <span id="detailEventDate" style="font-size:12px;"></span></p>
         <p><strong style="font-size:12px;">Venue:</strong> <span id="detailEventVenue" style="font-size:12px;"></span></p>
         <p><strong style="font-size:12px;">Details:</strong> <span id="detailEventDetails" style="font-size:12px;"></span></p>
     </div>
 </div>


 {{-- script --}}


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


<!-- No date script-->

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
