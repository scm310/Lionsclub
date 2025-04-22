   <!-- Upcoming Events Tab -->
   <div class="tab-pane fade {{ $activeTab === 'tab2' ? 'show active' : '' }}" id="tab2">
            <!-- Sticky Header for Upcoming Events -->
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
                    $months = ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'];
                    @endphp

                    @foreach($months as $index => $month)
                    @if($index >= $currentMonthIndex)
                    <a href="#" class="month-link btn btn-outline-light btn-sm
            {{ $month === $currentMonth ? 'active' : '' }}"
                        data-month="{{ $month }}">
                        {{ $month }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>


            <!-- Events List -->
            <div id="upcomingEventsList" class="row g-3">
                @php $hasEventsForCurrentMonth = false; @endphp

                @forelse($upcomingEvents as $event)
                @php
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $eventMonth = $eventDate->format('F');
                if ($eventMonth === $currentMonth) $hasEventsForCurrentMonth = true;

                $imagePath = $event->event_invitation
                ? 'storage/app/public/event_invitations/' . $event->event_invitation
                : 'assets/images/default1.png';
                @endphp

                <div class="event-row cards_item col-6 col-lg-5th" data-month="{{ $eventMonth }}" style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
                    <div class="card upcoming-event-card p-3 rounded shadow-sm mb-2 d-flex flex-column justify-content-center align-items-center"
                        tabindex="0"
                        style="height: auto; cursor: pointer; border: 2px solid #ffcc00; background:#fff; transition: transform 0.3s ease-in-out;"
                        data-name="{{ $event->event_name }}"
                        data-date="{{ $eventDate->format('M d, Y') }}"
                        data-image="{{ asset($imagePath) }}"
                        onclick="showUpcomingEventDetails(this)">

                        <div class="card_image">
                            <img src="{{ asset($imagePath) }}"
                                alt="Event Image"
                                style="width:100%; height:100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        </div>

                        <div class="card_content text-center p-2">
                            <h2 class="card_title text-dark" style="font-size:12px; font-weight: bold;">{{ $event->event_name }}</h2>
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

    <!-- Upcoming Event Details Modal -->
<div id="upcomingEventDetails" class="position-fixed top-0 end-0 shadow-lg p-4 d-none"
    style="width: 380px; z-index: 1055; overflow-y: auto; 
        border-left: 4px solid #ffc107; margin-top: 120px; /* Move up slightly */
        background: linear-gradient(115deg, #0f0b8c, #77dcf5); 
        border-top-left-radius: 20px; border-bottom-left-radius: 20px;
        max-height: 80vh;"> <!-- Added max-height to allow scrolling when content is large -->

    <!-- Close Button -->
    <button class="btn-close position-absolute top-0 end-0 m-2" id="closeUpcomingEventDetails"></button>

    <!-- Event Invitation Image -->
    <div id="upcomingEventInvitationContainer" class="mb-3 text-center">
        <img id="upcomingEventInvitationImage" src="" alt="Event Invitation"
            class="img-fluid rounded shadow-sm"
            style="width:170px; height:200px; object-fit: fill;">
    </div>

    <!-- Event Details Card -->
    <div class="card text-dark shadow-sm" style="background-color:linear-gradient(115deg, #ffffff, #eeeeee, #ffffff);">
        <div class="card-body">
            <p class="text-dark"><strong>Event Name:</strong> <span id="upcomingEventName"></span></p>
            <p class="text-dark"><strong>Event Date:</strong> <span id="upcomingEventDate"></span></p>
        </div>
    </div>
</div>
