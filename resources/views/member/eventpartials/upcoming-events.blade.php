  <style>
      /* Custom class for 6 columns per row */
      .col-lg-6th {
          width: 16.6667%;
          flex: 0 0 auto;
      }

      @media (max-width: 991.98px) {
          .col-lg-6th {
              width: 50%;
              /* Stack 2 per row on smaller screens */
          }
      }


      #upcomingEventDetails div::-webkit-scrollbar {
          display: none;
      }

  </style>
  <!-- Upcoming Events Tab -->
  <div class="tab-pane fade {{ $activeTab === 'tab2' ? 'show active' : '' }}" id="tab2">
      <div class="sticky-header text-white py-3 px-2"
          style="position: sticky; top: 180px; z-index: 1020; background: linear-gradient(115deg, #0f0b8c, #77dcf5);">

          <h3 class="fw-bold text-white d-flex align-items-center mb-2">
              Upcoming Events -
              <span class="fw-bold text-white ms-2">{{ now()->year }}</span>
          </h3>

          <div class="mb-0 d-flex flex-wrap gap-2">
              @php
                  $currentMonth = now()->format('F');
                  $currentMonthIndex = now()->format('n') - 1;
                  $months = [
                      'January',
                      'February',
                      'March',
                      'April',
                      'May',
                      'June',
                      'July',
                      'August',
                      'September',
                      'October',
                      'November',
                      'December',
                  ];
              @endphp

              @foreach ($months as $index => $month)
                  @if ($index >= $currentMonthIndex)
                      <a href="#"
                          class="month-link btn btn-outline-light btn-sm
            {{ $month === $currentMonth ? 'active' : '' }}"
                          data-month="{{ $month }}">
                          {{ $month }}
                      </a>
                  @endif
              @endforeach
          </div>
      </div>




      <!-- Events List -->
      <div id="upcomingEventsList" class="row g-3 mt-1">
          @php $hasEventsForCurrentMonth = false; @endphp

          @forelse($upcomingEvents as $event)
              @php
                  $eventDate = \Carbon\Carbon::parse($event->start_date);
                  $eventMonth = $eventDate->format('F');
                  if ($eventMonth === $currentMonth) {
                      $hasEventsForCurrentMonth = true;
                  }

                  $imagePath = $event->event_invitation
                      ? 'storage/app/public/event_invitations/' . $event->event_invitation
                      : 'assets/images/default1.png';
              @endphp

              <div class="event-row cards_item col-6 col-lg-6th" data-month="{{ $eventMonth }}"
                  style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">

                  <div class="card upcoming-event-card p-3 rounded shadow-sm mb-2 d-flex flex-column justify-content-center align-items-center"
                      tabindex="0"
                      style="height: 140px; cursor: pointer; border: 2px solid #ffcc00; background:#fff; transition: transform 0.3s ease-in-out;"
                      data-name="{{ $event->event_name }}" data-date="{{ $eventDate->format('M d, Y') }}"
                      data-image="{{ asset($imagePath) }}" data-activity-level="{{ $event->activity_level }}"
                      data-multiple-district-id="{{ $event->parentDistrict->name }}"
                      data-district-id="{{ $event->district->name }}" data-club-id="{{ $event->club->chapter_name }}"
                      data-club-name="{{ $event->club->chapter_name }}" data-creator="{{ $event->creator }}"
                      data-activity-duration="{{ $event->activity_duration }}"
                      data-start-date="{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }}"
                      data-end-date="{{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y') }}"
                      data-activity-type="{{ $event->activity_type }}" data-cause="{{ $event->cause }}"
                      data-total-volunteers="{{ $event->total_volunteers }}"
                      data-description="{{ $event->description }}" onclick="showUpcomingEventDetails(this)">



                      <div class="card_image"
                          style="width: 100%; height: 300px; overflow: hidden; border-radius: 10px;">
                          <img src="{{ asset($imagePath) }}" alt="Event Image"
                              style="width: 100%; height: 100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                      </div>


                      <div class="card_content text-center p-2">
                          <h2 class="card_title text-dark" style="font-size:12px; font-weight: bold;">
                              {{ $event->event_name }}</h2>
                          <p class="card_text text-muted" style="font-size:10px; margin-bottom: 5px;">
                              {{ $eventDate->format('l, M d, Y') }}
                          </p>
                      </div>
                  </div>
              </div>
          @empty
              @php $hasEventsForCurrentMonth = false; @endphp
          @endforelse
      </div>
  </div>

  {{-- Right Side popup card  Upcomming Event --}}

  <div id="upcomingEventDetails" class="position-fixed top-0 end-0 shadow-lg d-none"
      style="width: 380px; z-index: 1055; border-left: 4px solid #ffc107; margin-top: 120px;
    background: linear-gradient(115deg, #0f0b8c, #77dcf5); border-top-left-radius: 20px;
    border-bottom-left-radius: 20px; max-height: 80vh; padding: 1rem;">

      <button class="btn-close position-absolute top-0 end-0 m-2" id="closeUpcomingEventDetails"></button>

      <div
          style="overflow-y: auto; max-height: calc(80vh - 50px); padding-right: 5px; scrollbar-width: none; -ms-overflow-style: none;">

          <div id="upcomingEventInvitationContainer" class="mb-3 text-center">
              <img id="upcomingEventInvitationImage" src="" alt="Event Invitation"
                  class="img-fluid rounded shadow-sm" style="width:200px; height:150px; object-fit: fill;">
          </div>




          <div class="card text-dark shadow-sm" style="background-color:#ffffff; width:97%;">
              <div class="card-body p-0">
                  <table class="table table-bordered table-sm m-0" style="border-collapse: collapse;">
                      <tbody>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Event Name</th>
                              <td class="px-3 py-2" id="upcomingEventName"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">Event Date</th>
                              <td class="px-3 py-2" id="upcomingEventDate"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Activity Level</th>
                              <td class="px-3 py-2" id="upcomingEventActivityLevel"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">Multiple District</th>
                              <td class="px-3 py-2" id="upcomingEventMultipleDistrictId"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">District</th>
                              <td class="px-3 py-2" id="upcomingEventDistrictId"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">Club</th>
                              <td class="px-3 py-2" id="upcomingEventClubId"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Creator</th>
                              <td class="px-3 py-2" id="upcomingEventCreator"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">Activity Duration</th>
                              <td class="px-3 py-2" id="upcomingEventActivityDuration"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Start Date</th>
                              <td class="px-3 py-2" id="upcomingEventStartDate"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">End Date</th>
                              <td class="px-3 py-2" id="upcomingEventEndDate"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Activity Type</th>
                              <td class="px-3 py-2" id="upcomingEventActivityType"></td>
                          </tr>
                          <tr>
                              <th class="px-3 py-2">Cause</th>
                              <td class="px-3 py-2" id="upcomingEventCause"></td>
                          </tr>
                          <tr style="background-color: #f9f9f9;">
                              <th class="px-3 py-2">Total Volunteers</th>
                              <td class="px-3 py-2" id="upcomingEventTotalVolunteers"></td>
                          </tr>
                      </tbody>
                  </table>
                  <p class="text-dark mt-3 px-3 py-2"><strong>Description:</strong> <span
                          id="upcomingEventDescription"></span></p>
              </div>
          </div>
      </div>

  </div>



  {{-- script --}}


  <script>
      function showUpcomingEventDetails(eventCard) {


          // Fetching the data attributes
          let eventName = eventCard.getAttribute("data-name");
          let eventDate = eventCard.getAttribute("data-date");
          let eventImageUrl = eventCard.getAttribute("data-image");
          let activityLevel = eventCard.getAttribute("data-activity-level");
          let multipleDistrictId = eventCard.getAttribute("data-multiple-district-id");
          let districtId = eventCard.getAttribute("data-district-id");
          let clubId = eventCard.getAttribute("data-club-id");
          let creator = eventCard.getAttribute("data-creator");
          let activityDuration = eventCard.getAttribute("data-activity-duration");
          let startDate = eventCard.getAttribute("data-start-date");
          let endDate = eventCard.getAttribute("data-end-date");
          let activityType = eventCard.getAttribute("data-activity-type");
          let cause = eventCard.getAttribute("data-cause");
          let totalVolunteers = eventCard.getAttribute("data-total-volunteers");
          let description = eventCard.getAttribute("data-description");




          document.getElementById("upcomingEventName").innerText = eventName;
          document.getElementById("upcomingEventDate").innerText = eventDate;
          document.getElementById("upcomingEventActivityLevel").innerText = activityLevel;
          document.getElementById("upcomingEventMultipleDistrictId").innerText = multipleDistrictId;
          document.getElementById("upcomingEventDistrictId").innerText = districtId;
          document.getElementById("upcomingEventClubId").innerText = clubId;
          document.getElementById("upcomingEventCreator").innerText = creator;
          document.getElementById("upcomingEventActivityDuration").innerText = activityDuration;
          document.getElementById("upcomingEventStartDate").innerText = startDate;
          document.getElementById("upcomingEventEndDate").innerText = endDate;
          document.getElementById("upcomingEventActivityType").innerText = activityType;
          document.getElementById("upcomingEventCause").innerText = cause;
          document.getElementById("upcomingEventTotalVolunteers").innerText = totalVolunteers;
          document.getElementById("upcomingEventDescription").innerText = description;


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


          document.removeEventListener("click", closeDetailsOnOutsideClick);
          setTimeout(() => {
              document.addEventListener("click", closeDetailsOnOutsideClick);
          }, 100);
      }



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


                  monthLinks.forEach(btn => btn.classList.remove("active"));
                  this.classList.add("active");

                  const selectedMonth = this.getAttribute("data-month");
                  filterUpcomingEvents(selectedMonth);
              });
          });


          const currentMonth = new Date().toLocaleString('default', {
              month: 'long'
          });
          const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

          if (currentMonthButton) {
              currentMonthButton.classList.add("active");
              filterUpcomingEvents(currentMonth);
          }
      });
  </script>
