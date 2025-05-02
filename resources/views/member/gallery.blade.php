@extends('layouts.navbar')

@section('content')


<style>
    .selected-card {
        border: 3px solid #007bff !important;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        transition: all 0.3s ease-in-out;
    }


    /* Ensure month navigation stays sticky below the tabs */
    .month-link {
        position: sticky;
        top: 60px;
        /* Adjust based on the tab height */
        z-index: 99;
        background-color: transparent !important;
        color: white;
        padding: 5px 17px;
        border: 2px solid transparent;
        border-radius: 8px;
        font-weight: bold;
        background-image:
            linear-gradient(to right, #000000, #000000),
            /* Button background */
            linear-gradient(45deg, #00f, #ff0);
        /* Border gradient */
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .month-link:hover {
        color: yellow;
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    }

    .btn.active {
        color: yellow !important;
        border: 2px solid transparent !important;
        background-image:
            linear-gradient(to right, #000000, #000000),
            linear-gradient(45deg, #fff, #ff0) !important;
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 6px 16px rgba(255, 255, 0, 0.4) !important;
    }
</style>
<div class="container mt-5">
    <!-- Sticky Header for Gallery -->
    <div class="sticky-header text-white py-3 px-2"
        style="position: sticky; top: 180px; z-index: 1020; background:white; border-radius:10px;">

        <h3 class="fw-bold text-dark d-flex align-items-center mb-2">

            @if($completedEvents->isNotEmpty())
            <span class="fw-bold text-dark ms-3">{{ now()->year }}</span>
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


    @php
    $highlightedImage = request()->query('highlight') ? basename(request()->query('highlight')) : null;
    @endphp

    <br>

    <div class="row g-3" id="galleryContainer">
        @php
        $hasImages = false;
        // Ensure sorting is done based on the actual event date
        $sortedEvents = $completedEvents->sortBy(function ($event) {
        return \Carbon\Carbon::parse($event->event_date);
        });
        @endphp

        @forelse($sortedEvents as $event)
        @php
        $eventMonth = \Carbon\Carbon::parse($event->event_date)->format('F');
        $eventDate = \Carbon\Carbon::parse($event->event_date)->format('d-m-Y'); // Display actual event date
        $images = $event->images ?? [];
        $mainImage = !empty($images) ? asset('storage/app/public/' . $images[0]) : null;
        $mainImageName = !empty($images) ? basename($images[0]) : null;
        $eventName = $event->event ? $event->event->event_name : 'Unknown Event';
        @endphp

        @if($mainImage)
        @php $hasImages = true; @endphp
        <div class="col-md-3 col-sm-6 event-card" data-month="{{ $eventMonth }}"
            style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
            <a href="{{ route('gallery.show', ['id' => $event->id]) }}"
                class="text-decoration-none text-dark"
                title="Click to see the event details">
                <div class="card shadow-sm border border-secondary {{ $highlightedImage == $mainImageName ? 'selected-card' : '' }}">
                    <img src="{{ $mainImage }}"
                        class="card-img-top rounded-top"
                        style="height: 150px; object-fit: fill;">
                    <div class="card-body p-2 text-center">


                        <div class="card-body p-2 text-center">

                            @php
                            $shortName = Str::limit($eventName, 25, '...');
                            @endphp

                            <h6 class="fw-bold text-primary mb-2" title="{{ $eventName }}">
                                {{ $shortName }}
                            </h6>

                            <small class="text-muted d-block mb-2">{{ $eventDate }}</small>

                            <div class="d-flex flex-wrap justify-content-center">
                                @foreach(array_slice($images, 1) as $image)
                                @php $imageName = basename($image); @endphp
                                <img src="{{ asset('storage/app/public/' . $image) }}"
                                    class="img-thumbnail m-1 {{ $highlightedImage == $imageName ? 'border border-3 border-primary' : '' }}"
                                    style="width: 60px; height: 50px; object-fit: cover;">
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </a>
        </div>
        @endif


        @empty
        <p class="text-muted text-center w-100">No completed event images available.</p>
        @endforelse

        @if(!$hasImages)
        <p class="text-muted text-center w-100" data-month="{{ $currentMonth }}">No images available for this month.</p>
        @endif
    </div>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <h4 id="noDataMessage" class="text-center" style="display: none;">
            No Events Were Conducted
        </h4>
    </div>





</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthLinks = document.querySelectorAll('.month-link');
        const eventCards = document.querySelectorAll('.event-card');
        const noDataMessage = document.getElementById('noDataMessage');

        function filterByMonth(month) {
            let found = false;

            eventCards.forEach(card => {
                if (card.getAttribute('data-month') === month) {
                    card.style.display = 'block';
                    found = true;
                } else {
                    card.style.display = 'none';
                }
            });

            noDataMessage.style.display = found ? 'none' : 'block';
        }

        // Set up click event listeners
        monthLinks.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedMonth = this.getAttribute('data-month');

                filterByMonth(selectedMonth);

                // Update active button state
                monthLinks.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Auto trigger the active button on page load
        const activeButton = document.querySelector('.month-link.active');
        if (activeButton) {
            activeButton.click(); // Trigger click to filter & set state
        }
    });
</script>

<script>
    let eventDate = @json($eventDate);
    console.log("Event Date:", eventDate);
</script>

@endsection