@extends('layouts.navbar')

@section('content')



<style>

.nav-tabs .nav-link {
            color: #000;
            background: #f8f9fa;
            border-radius: 5px;
            transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
            border: none;
        }

        /* Active Tab Style */
        .nav-tabs .nav-link.active {
            background: #003366;
            color: #fff !important;
            font-weight: bold;
            border: none;

        }

        /* Hover Effect */
        .nav-tabs .nav-link:hover {
            background: #003366;
            color: #fff;
        }



    .custom-card {
        border-radius: 12px;
        background: #00509e;
        padding: 10px 0;
        width: 80%;
        height: 170px;
        transition: transform 0.2s ease-in-out, border 0.3s ease-in-out;
    }

    .custom-card:hover {
        transform: scale(1.05);
        border: 4px solid #ffcc00;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .modal-body p {
        font-size: 16px;
        color: #333;
    }

      .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    @media (max-width: 576px) {
        .custom-card {
            width: 95%;
        }
    }
</style>



<div class="container displayscreen">
    @include('member.tab')

    <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded"
        style="background: linear-gradient(115deg, #0f0b8cb8, #77dcf5c1);">

        <div class="shadow mb-3 bg-body-tertiary rounded"
            style="background: linear-gradient(115deg, #1a1683, #77dcf5); color:white;">
            <h4 class="text-center">District Governors</h4>
        </div>




<!-- District Tabs -->
<div id="districtTabsWrapper" class="d-none d-md-flex align-items-center justify-content-center position-relative">

    <!-- Left Scroll Button (Visible on All Screens) -->
    <button class="btn btn-light position-absolute start-0 shadow-sm d-flex align-items-center justify-content-center"
        onclick="changeTabGroup('prev')" id="tabPrevBtn"
        style="z-index: 10; border-radius: 50%; width: 40px; height: 40px;">
        <span style="transform: rotate(180deg); display: inline-block;">&#10148;</span>
    </button>

    <!-- Scrollable Tabs Container -->
    <div class="mx-5 position-relative w-100">
        <div class="hide-scrollbar" id="tabScrollContainer">
            <ul class="nav nav-tabs justify-content-center gap-2" id="districtTabList" role="tablist"
                style="border: none; white-space: nowrap;">
                @foreach ($districts as $key => $district)
                    <li class="nav-item" data-tab-index="{{ $key }}" style="margin: 0 1px;">
                        <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="district-{{ $district->id }}-tab"
                            data-bs-toggle="tab" href="#district-{{ $district->id }}" role="tab">
                            {{ $district->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Right Scroll Button (Visible on All Screens) -->
    <button class="btn btn-light position-absolute end-0 shadow-sm d-flex align-items-center justify-content-center"
        onclick="changeTabGroup('next')" id="tabNextBtn"
        style="z-index: 10; border-radius: 50%; width: 40px; height: 40px;">
        <span>&#10148;</span>
    </button>

</div>

<div class="d-flex align-items-center justify-content-center position-relative d-block d-md-none "  >
    <div class="mx-5 position-relative w-100 ">
        <div class="overflow-auto hide-scrollbar" id="tabScrollContainer">
            <ul class="nav nav-tabs flex-nowrap gap-2"  role="tablist" style="border: none; white-space: nowrap;">
                @foreach ($districts as $district)
                    <li class="nav-item" style="margin: 0 1px;">
                        <a
                            class="nav-link"
                            id="district-{{ $district->id }}-tab"
                            data-bs-toggle="tab"
                            href="#district-{{ $district->id }}"
                            role="tab"
                            aria-controls="district-{{ $district->id }}"
                            aria-selected="false"
                        >
                            {{ $district->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>



<div class="tab-content mt-3 mb-3">
    @foreach ($districts as $key => $district)
        <div class="tab-pane {{ $key == 0 ? 'show active' : '' }}" id="district-{{ $district->id }}"
            role="tabpanel">
            <div class="row mb-5 leader-section justify-content-center">
                @if (isset($groupedGovernors[$district->id]) && $groupedGovernors[$district->id]->isNotEmpty())
                    @foreach ($groupedGovernors[$district->id] as $governor)

                    @php
                    $fullName = $governor->first_name ." ". $governor->last_name ;
                    $displayName = strlen($fullName) > 20 ? substr($fullName, 0, 20) . '...' : $fullName;
                    $displayPosition = strlen($governor->position ) > 20 ? substr($governor->position , 0, 20) . '...' : $governor->position ;
                         @endphp
                        <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center">
                            <!-- ✅ Clickable Governor Card -->
                            <div class="card text-center shadow-sm custom-card profile-card" data-bs-toggle="modal"
                                data-bs-target="#profileModal"
                                data-name="{{ $governor->first_name }} {{ $governor->last_name }}"
                                data-member-id="{{ $governor->member_id }}">


                                        <div class="d-flex justify-content-center">
                                            <img src="{{ $governor->profile_photo? asset('storage/app/public/' . $governor->profile_photo) : asset('assets/images/default.png') }}"
                                                alt="{{ $governor->first_name ." ". $governor->last_name }}"
                                                class="border border-white shadow"
                                                style="width:80px; height:80px; object-fit:cover; border-radius:10px;">
                                        </div>

                        <div class="text-white">
                            <span style="font-size: 12px; font-weight: bold;" title="{{ $fullName }}">{{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}</span>
                            <br>
                            <span class="small" title="{{ $governor->position  }}">{{ $displayPosition }}</span>
                            <br>
                            <span style="font-size: 11px; font-weight: bold;">{{ $governor->member_id }}</span>
                        </div>

                            </div>
                        </div>
                    @endforeach
                @else

                <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                    <h4 id="noDataMessage" class="text-center text-white" >
                        No District Governor Found
                    </h4>
                </div>

                @endif
            </div>
        </div>
    @endforeach
</div>





    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modalmodify">
            <div class="modal-header text-white" style="background-color: #003366; margin-top: -30px;">
                <h5 class="modal-title w-100 text-center" id="profileModalLabel">Profile Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <p id="modalText">
                    You need to log in to view <strong id="officerName"></strong>'s profile.
                </p>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <a href="{{ route('member.login') }}" class="btn btn-primary px-4"
                    style="border: 1px solid #ffcc00; background: linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(97, 149, 219) 158.5%);">
                    Login
                </a>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Populate modal with officer's name
        document.querySelectorAll(".profile-card").forEach(card => {
            card.addEventListener("click", function () {
                const officerName = this.getAttribute("data-name");
                document.getElementById("officerName").innerText = officerName;
            });
        });
    });
</script>


{{-- //scrollbar --}}
<script>
    const TABS_PER_PAGE = 6;
    let currentTabStart = 0;
    const tabItems = document.querySelectorAll('#districtTabList .nav-item');

    function updateTabVisibility() {
        tabItems.forEach((item, index) => {
            item.classList.toggle('d-none', index < currentTabStart || index >= currentTabStart +
            TABS_PER_PAGE);
        });

        // Show/hide arrows
        document.getElementById('tabPrevBtn').style.display = currentTabStart > 0 ? 'inline-block' : 'none';
        document.getElementById('tabNextBtn').style.display = currentTabStart + TABS_PER_PAGE < tabItems.length ?
            'inline-block' : 'none';
    }

    function changeTabGroup(direction) {
        if (direction === 'next' && currentTabStart + TABS_PER_PAGE < tabItems.length) {
            currentTabStart += TABS_PER_PAGE;
        } else if (direction === 'prev' && currentTabStart > 0) {
            currentTabStart -= TABS_PER_PAGE;
        }
        updateTabVisibility();
    }

    // Initial setup
    document.addEventListener('DOMContentLoaded', updateTabVisibility);
</script>

@endsection
