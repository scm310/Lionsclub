<style>
    .card img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .card {
        max-width: 100%
     !important;
    }
</style>

<style>
    .animated-bg {
        background: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
        background-size: 800% 800%;
        animation: moveBackground 10s ease infinite;
    }

    @keyframes moveBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .move-horizontal {
        animation: moveContent 10s linear infinite;
        display: inline-block;
    }

    @keyframes moveContent {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
</style>
@php
    $banners_1000m = DB::table('banner_1000')->get();

    $member = \App\Models\Member::with('team')
    ->whereHas('team', function ($query) {
        $query->where('position', 'District Governor')
              ->where('year', 'CurrentYear');
    })
    ->first();

    $pinImages = DB::table('pin_images')->select('image_path')->get(); // Fetch all pin images

    $banners_10000 = DB::table('banner_10000')->select('image_path', 'url')->get();
    $banners_5000 = DB::table('banner_5000')->select('image_path', 'url')->get()->chunk(2);

    $banners = $banners_10000->merge($banners_5000->flatten());

@endphp




<div class="p-2 ">
    <div class="card shadow-2xl rounded-xl p-1" style="background-color: #003366;">
        <div class="d-flex align-items-center">
            <!-- Member Image -->
            <div class="me-2 shadow-lg">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="zoom-image" loading="lazy"
                    style="width: 50px; height: 50px; z-index: 999;" />
            </div>

            <!-- Member Name -->
            <div class="me-6 text-center">
                <h2 class="fs-6 text-white mb-0">Lions International District 3241 E</h2>
            </div>

            <!-- Member Role Image -->
            <div class="me-2 shadow-lg p-2">
                @foreach ($pinImages as $image)
                <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Logo" class="zoom-image1" loading="lazy"
                style="width: 40px; height: 40px; z-index: 999;" />
            @endforeach

            </div>

            <!-- Member Login Button -->
            <div class="ms-auto">
                <button class="btn" onclick="window.location.href='{{ route('member.login') }}';">
                    <img src="{{ asset('assets/images/mem.png') }}" alt="memberlogin" class="bounce-animation" style="width: 35px;height: 35px;">
                </button>

                <!-- Bootstrap 5.3 Custom Animation -->
                <style>
                @keyframes bounce {
                    0%, 10% { transform: translateY(0); }
                    50% { transform: translateY(-5px); }
                }

                .bounce-animation {
                    animation: bounce 1s infinite;
                }
                </style>
            </div>
        </div>

    </div>
</div>


<div class="container ">
    <div class="row row-cols-4 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="banners-container">
        @foreach ($banners_1000m as $index => $banner)
            <div class="col banner-card" data-index="{{ $index }}">
                <div class="card shadow-sm">
                    <a href="{{ $banner->url }}">
                        <img src="{{ $banner->image_path ? asset('storage/app/public/' . $banner->image_path) : asset('images/default-image.jpg') }}"
                            alt="Card Image">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="p-1">
    <div class="card shadow rounded-xl  " style="background-color: rgba(255, 255, 255, 0);!important">

        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">
                @foreach ($banners as $index => $banner)
                    <div class="carousel-item @if ($index === 0) active @endif">
                        <a href="{{ $banner->url }}" target="_blank">
                            <!-- Using img-fluid for responsive images -->
                            <img src="{{ asset('storage/app/public/' . $banner->image_path) }}"
                                class="d-block w-100 img-fluid" alt="Banner" style="height: 150px; object-fit: fill;">
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Optional: Carousel indicators (dots) -->
            <div class="carousel-indicators">
                @foreach ($banners as $index => $banner)
                    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $index }}"
                        class="@if ($index === 0) active @endif" aria-current="true"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>



</div>



<div class="card shadow-2xl animated-bg p-1 rounded-xl d-flex  mb-1 justify-content-center align-items-center overflow-hidden" style="width: 100%;">

    @if ($member)
        <div class="d-flex align-items-center move-horizontal">
            <!-- Member Image (Full Display) -->
            <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}" alt="{{ $member->first_name.' '.$member->last_name}}"
                 class="me-3 "
                 style="
                  width: 50px; height: 50px;border-radius: 20px; object-fit: contain;" />

            <!-- Member Name and Role -->
            <div class="d-flex">
                <div class="fw-bold me-2" style="font-size: 12px;">{{ $member->first_name.' '.$member->last_name}} </div>
                <div style="font-size: 12px;">{{ $member->team->position }}</div>
            </div>
        </div>
    @endif
</div>

<div class="nav-container">
            <div class="nav-menu-wrapper">
                <ul class="nav-menu">
                    <li><a href="{{ route('index') }}"
                            class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('international_officers') }}"
                            class="{{ request()->routeIs('international_officers', 'dgteam', 'pastdistrictgovernor', 'districtchairperson', 'districtgovernor', 'regionmember', 'chapter') ? 'active' : '' }}">
                            Member Directory
                        </a>
                    </li>

                    <!-- Resources Menu with Clickable Submenu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button">
                            Resources
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('award.index') }}">Awards</a></li>
                        </ul>
                    </li>



                    <li><a href="{{ route('webevents') }}"
                            class="{{ request()->routeIs('webevents') ? 'active' : '' }}">Events</a></li>

                    <li><a href="{{ route('member.gallery') }}"
                            class="{{ request()->routeIs('member.gallery') ? 'active' : '' }}">Gallery</a></li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="{{ request()->is('contact') || request()->is('membership-enquiry') || request()->is('donation') ? 'active' : '' }}">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('careerenquiry.form') }}"
                            class="{{ request()->routeIs('careerenquiry.form') ? 'active' : '' }}">
                            Career Enquiry
                        </a>
                    </li>
                    <li class="nav-item ">

                        <a href="{{ route('membership.form') }}" class=" animated-btn">Join Us</a>

                    </li>
                    <li class="nav-item ">

                        <a href="{{ route('member.login') }}" class=" animated-btn">Member Login</a>

                    </li>

                </ul>
            </div>
        </div>







{{-- 1000 banner in mobile screen --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allCards = document.querySelectorAll('.banner-card');
        let currentIndex = 0;
        const totalCards = allCards.length;
        const cardsToShow = 4;

        // Function to show only 4 cards at a time
        function showNextCards() {
            // Hide all cards
            allCards.forEach(card => card.style.display = 'none');

            // Show the next set of 4 cards
            for (let i = currentIndex; i < currentIndex + cardsToShow; i++) {
                if (i < totalCards) {
                    allCards[i].style.display = 'block'; // Show card
                }
            }

            // Update the index to the next set of 4 cards
            currentIndex += cardsToShow;

            // Reset the index if we reach the end of the list
            if (currentIndex >= totalCards) {
                currentIndex = 0;
            }
        }

        // Initially show the first 4 cards
        showNextCards();

        // Set an interval to change the cards every 2 seconds
        setInterval(showNextCards, 2000); // 2000 milliseconds = 2 seconds
    });
</script>
