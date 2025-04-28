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

        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        @media (max-width: 576px) {
            .custom-card {
                width: 95%;
            }

            .ns {
                font-size: 10px;
            }
        }
    </style>



    <div class="container displayscreen">
        @include('member.tab')

        <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded"
            style="background: linear-gradient(115deg, #0f0b8cb8, #77dcf5c1);">

            <div class="shadow mb-3 bg-body-tertiary rounded"
                style="background: linear-gradient(115deg, #1a1683, #77dcf5); color:white;">
                <h4 class="text-center">Region Members</h4>
            </div>



            <div class="tab-container">
                <div class="overflow-auto hide-scrollbar">
                    <ul class="nav nav-tabs flex-nowrap gap-2" id="regionTabList" style="border: none;">
                        @foreach ($regions as $regionName => $members)
                            <li class="nav-item">
                                <a class="nav-link ns {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                    href="#{{ Str::slug($regionName) }}">
                                    {{ $regionName }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="tab-content mt-3 mb-3">
                @foreach ($regions as $regionName => $members)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($regionName) }}">
                        <div class="row mb-5 leader-section">
                            <!-- Left Column: Member Cards -->
                            <div class="col-lg-9">
                                <div class="row justify-content-center">
                                    @forelse($members as $regionMember)
                                        @php
                                            $member = $regionMember->member;
                                            $fullName = $member->first_name . ' ' . $member->last_name;
                                            $displayName =
                                                strlen($fullName) > 15 ? substr($fullName, 0, 15) . '...' : $fullName;
                                            $displayPosition =
                                                strlen($regionMember->position) > 15
                                                    ? substr($regionMember->position, 0, 15) . '...'
                                                    : $regionMember->position;
                                        @endphp

                                        <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center">
                                            <div class="card text-center shadow-sm custom-card profile-card"
                                                data-bs-toggle="modal" data-bs-target="#profileModal"
                                                data-name="{{ $fullName }}" data-member-id="{{ $member->member_id }}">
                                                <div class="d-flex justify-content-center">
                                                    <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                                        alt="{{ $fullName }}" class="border border-white shadow"
                                                        style="width:80px; height:80px; object-fit:cover; border-radius:10px;">
                                                </div>
                                                <div class="text-white">
                                                    <span style="font-size: 12px; font-weight: bold;"
                                                        title="{{ $fullName }}">
                                                        {{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}
                                                    </span><br>
                                                    <span class="small"
                                                        title="{{ $regionMember->position }}">{{ $displayPosition }}</span><br>
                                                    <span
                                                        style="font-size: 11px; font-weight: bold;">{{ $member->member_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <h4 class="text-center text-white">No members found for this region.</h4>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Right Column: Featured Member -->
                            <div class="col-lg-3">
                                <div class="card shadow-lg text-white bg-dark p-3"  style="background: linear-gradient(23deg, #1a1683, #77dcf5); color:white; border-radius: 15px; ">
                                    @php

                                        $featured = $members->where('position', 'Region Chairperson')->first();
                                    @endphp

                                    @if ($featured)
                                        <h5 class="mb-3 text-center">{{ $featured->region }}</h5>
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $featured->member->profile_photo ? asset('storage/app/public/' . $featured->member->profile_photo) : asset('assets/images/default.png') }}"
                                                alt="{{ $featured->member->first_name }}"
                                                style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;"
                                                class="me-3">
                                            <div>
                                                <strong>{{ $featured->member->first_name }}
                                                    {{ $featured->member->last_name }}</strong><br>
                                                <small>{{ $featured->position }}</small><br>
                                                <small>ID: {{ $featured->member->member_id }}</small>
                                            </div>
                                        </div>


                                        <p class="small mb-0">
                                            <strong>Clubs</strong><br>

                                            @php
                                                $allChapterIds = [];
                                            @endphp

                                            @foreach ($members as $fes)
                                                @if (isset($fes->chapter_id))
                                                    <!-- Ensure $fes is an object and chapter_id exists -->
                                                    @php
                                                        $ids = is_array($fes->chapter_id)
                                                            ? $fes->chapter_id
                                                            : json_decode($fes->chapter_id, true);
                                                        if (is_array($ids)) {
                                                            $allChapterIds = array_merge($allChapterIds, $ids);
                                                        }
                                                    @endphp
                                                @endif
                                            @endforeach

                                            {{-- Optional: Remove duplicate IDs --}}
                                            @php
                                                $allChapterIds = array_unique($allChapterIds);
                                                $clubs = !empty($allChapterIds)
                                                    ? \App\Models\Chapter::whereIn('id', $allChapterIds)->get()
                                                    : collect();

                                            @endphp
                                            @if ($clubs->isNotEmpty())
                                                <ul>
                                                    @foreach ($clubs as $club)
                                                        <li>
                                                            <span>{{ $club->chapter_name }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span>No clubs found</span>
                                            @endif

                                        </p>
                                    @else
                                        <h5 class="mb-3 text-center">{{ $regionName }}</h5>
                                        <p>No featured member available.</p>
                                    @endif
                                </div>
                            </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Populate modal with officer's name
            document.querySelectorAll(".profile-card").forEach(card => {
                card.addEventListener("click", function() {
                    const officerName = this.getAttribute("data-name");
                    document.getElementById("officerName").innerText = officerName;
                });
            });
        });
    </script>


    {{-- //scrollbar --}}
    <script>
        const TABS_PER_PAGE = 8;
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
