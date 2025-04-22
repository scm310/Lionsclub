<style>
    .scroll-container1 {
        background-image: url("{{ asset('assets/images/db.png') }}");
        object-fit: fill;
        max-height: 150px;
        overflow: hidden;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        color: white;
        position: relative;
        height: 150px;
        display: flex;
        flex-direction: column;
    }

    .scroll-content1 {
        display: flex;
        align-items: flex-start; /* Or center or stretch, based on your layout */


        flex-direction: column;
        animation: scrollUp 100s linear infinite;

    }

    /* Keyframe for scrolling effect */
    @keyframes scrollUp {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-100%);
        }
    }

    /* Stop scrolling on hover */
    .scroll-container1:hover .scroll-content1 {
        animation-play-state: paused;
    }

    /* Style the event text */
    .scroll-content1 p {
        margin: 5px 0;
        cursor: pointer;
        margin-left:20px;
        transition: color 0.3s ease;
    }

    .scroll-content1 p:hover {
        color: yellow;
    }
</style>

<div class="scroll-container1">
    <div class="scroll-content1">
        <h3>Events Calendar</h3>
        @foreach ($events as $event)
            @php
                $tab = \Carbon\Carbon::parse($event->event_date)->isFuture() ? 'tab2' : 'tab1';
            @endphp
            <p onclick="navigateToEvent('{{ route('webevents', ['tab' => $tab]) }}')">
                <span>{{ \Carbon\Carbon::parse($event->event_date)->format('M d') }}:</span>
                {{ $event->event_name }}
            </p>
        @endforeach
    </div>
</div>

<script>
    function navigateToEvent(url) {
        window.location.href = url; // Redirect with tab parameter
    }
</script>
