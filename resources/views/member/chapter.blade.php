@extends('layouts.navbar')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .custom-card {
            border-radius: 12px;
            background: #00509e;
            padding: 10px 0;
            width: 80%;
            height: 170px;
            transition: transform 0.2s ease-in-out, border 0.3s ease-in-out;
            cursor: pointer;
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

        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        @media (max-width: 576px) {
            .custom-card {
                width: 95%;
            }
        }

        .bg-primary {
            background: #00509E;
        }

        .search {
            margin-left: -15px;
        }

        .heading {
            text-transform: capitalize !important;
        }
    </style>

    <div class="container displayscreen" >
        @include('member.tab')

        <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded"
            style="background: linear-gradient(115deg,  #0f0b8cb8, #77dcf5c1); ">

            <div class="shadow mb-3 bg-body-tertiary rounded"
                style="background: linear-gradient(115deg,  #0f0b8c, #77dcf5); color:white;">
                <h4 class="text-center">Clubs</h4>
            </div>
            <div class="row align-items-center mb-2 text-center text-md-start">
                <div class="col-12 col-md-3 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
                    <select class="form-select w-100 w-md-75" id="chapterDropdown">
                        <option value="all" selected>Show All Clubs</option>
                        @foreach ($chapters as $chapter)
                            <option value="#chapter-{{ Str::slug($chapter->chapter_name) }}">

                                {{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $chapter->chapter_name))) }}

                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
                    <div class="input-group w-100 w-md-75">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                        <span class="input-group-text" id="searchIcon" style="cursor: pointer;">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end"></div>
            </div>


            <div class="tab-content  mb-3">
                @foreach ($chapters as $chapter)
                    <div class="tab-pane fade show active chapter-tab" id="chapter-{{ Str::slug($chapter->chapter_name) }}">
                        <div class="leadership-container">
                            <div class="shadow mb-3 bg-body-tertiary rounded"
                                style="background: linear-gradient(115deg,  #0f0b8c, #77dcf5); color:white; text-transform: capitalize;">

                                <h5 class="shadow leadership-title text-center text-white">
                                    {{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $chapter->chapter_name))) }} - Leadership
                                </h5>

                            </div>
                            <div class="row leader-section justify-content-center">
                                @foreach ($members->where('account_name', $chapter->id)->whereIn('position', ['President', 'Secretary', 'Treasurer']) as $leader)
                                    @php
                                        $fullName = $leader->first_name . ' ' . $leader->last_name;
                                        $displayName =strlen($fullName) > 20 ? substr($fullName, 0, 20) . '...' : $fullName;
                                        $displayPosition =
                                            strlen($leader->position) > 20
                                                ? substr($leader->position, 0, 20) . '...'
                                                : $leader->position;
                                    @endphp
                                    <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center"
                                        id="data1">
                                        <div class="custom-card profile-card1 data1" data-bs-toggle="modal"
                                            data-bs-target="#profileModal"
                                            data-name1="{{ $leader->first_name }} {{ $leader->last_name }}"
                                            data-member-id1="{{ $leader->member_id }}"
                                            data-memberposition="{{ $leader->position }}"
                                            data-chapter="{{ $chapter->chapter_name }}">


                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $leader->profile_photo ? asset('storage/app/public/' . $leader->profile_photo) : asset('assets/images/default.png') }}"
                                                    alt="{{ $leader->first_name . ' ' . $leader->last_name }}"
                                                    class="border border-white shadow"
                                                    style="width:80px; height:80px; object-fit:cover; border-radius:10px;">
                                            </div>



                                            <div class="text-white text-center">
                                                <span style="font-size: 12px; font-weight: bold;"
                                                    title="{{ $fullName }}">{{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}</span>
                                                <br>
                                                <span class="small"
                                                    title="{{ $leader->position }}">{{ $displayPosition }}</span>
                                                <br>
                                                <span
                                                    style="font-size: 11px; font-weight: bold;">{{ $leader->member_id }}</span>
                                            </div>



                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="members-container">
                            <h5 class="mt-1 members-title text-center mx-auto w-50  rounded" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white;">
                                {{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $chapter->chapter_name))) }} - <span class="">{{ $members->where('account_name', $chapter->id)->count() }}</span> Members
                            </h5>
                            <div class="row member-section justify-content-center">
                                @foreach ($members->where('account_name', $chapter->id) as $member)
                                    @php
                                        $fullName = $member->first_name . ' ' . $member->last_name;
                                        $displayName =
                                            strlen($fullName) > 20 ? substr($fullName, 0, 20) . '...' : $fullName;

                                    @endphp
                                    <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center"
                                        id="data">
                                        <div class="custom-card profile-card data" style="height: 150px;" data-bs-toggle="modal"
                                            data-bs-target="#profileModal"
                                            data-name="{{ $member->first_name }} {{ $member->last_name }}"
                                            data-member-id="{{ $member->member_id }}">


                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                                    alt="{{ $member->first_name . ' ' . $member->last_name }}"
                                                    class="border border-white shadow"
                                                    style="width:80px; height:80px; object-fit:cover; border-radius:10px;">
                                            </div>


                                            <div class="text-white text-center">
                                                <span style="font-size: 12px; font-weight: bold;"
                                                    title="{{ $fullName }}">{{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}</span>
                                                <br>
                                                <span
                                                    style="font-size: 11px; font-weight: bold;">{{ $member->member_id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-3 no-results d-none">
                            <h4 class="text-white">No search results found.</h4>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modalmodify">
                <div class="modal-header text-white" style="background-color: #003366; margin-top: -30px;">
                    <h5 class="modal-title" id="profileModalLabel">Profile Access</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="modalText">You need to log in to view <strong id="officerName"></strong>'s profile.</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <a href="{{ route('member.login') }}" class="btn btn-primary px-4"
                        style="background-color: #003366;">Login</a>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropdown = document.getElementById('chapterDropdown');
            const searchInput = document.getElementById('searchInput');
            const searchIcon = document.getElementById('searchIcon');

            function updateView() {
                const selectedValue = dropdown.value;
                const keyword = searchInput.value.trim().toLowerCase();
                let anyMatchFound = false;

                document.querySelectorAll('.chapter-tab').forEach(tab => {
                    const isChapterMatch = selectedValue === 'all' || tab.id === selectedValue.replace('#', '');
                    let showTab = false;
                    let leaderVisible = false;
                    let memberVisible = false;

                    if (isChapterMatch) {
                        const leaders = tab.querySelectorAll('.profile-card1');
                        const members = tab.querySelectorAll('.profile-card');

                        leaders.forEach(card => {
                            const name = (card.dataset.name1 || '').toLowerCase();
                            const id = (card.dataset.memberId1 || '').toLowerCase();
                            const position = (card.dataset.memberposition || '').toLowerCase();
                            const match = keyword === '' || name.includes(keyword) || id.includes(keyword) || position.includes(keyword);
                            const wrapper = card.closest('.data1');
                            if (wrapper) wrapper.style.display = match ? 'block' : 'none';
                            if (match) {
                                showTab = true;
                                leaderVisible = true;
                                anyMatchFound = true;
                            }
                        });

                        members.forEach(card => {
                            const name = (card.dataset.name || '').toLowerCase();
                            const id = (card.dataset.memberId || '').toLowerCase();
                            const match = keyword === '' || name.includes(keyword) || id.includes(keyword);
                            const wrapper = card.closest('.data');
                            if (wrapper) wrapper.style.display = match ? 'block' : 'none';
                            if (match) {
                                showTab = true;
                                memberVisible = true;
                                anyMatchFound = true;
                            }
                        });

                        // Toggle Leadership and Member containers
                        const leadershipContainer = tab.querySelector('.leadership-container');
                        const membersContainer = tab.querySelector('.members-container');
                        if (leadershipContainer) leadershipContainer.style.display = leaderVisible ? 'block' : 'none';
                        if (membersContainer) membersContainer.style.display = memberVisible ? 'block' : 'none';

                        // Toggle "no results" message
                        const noResults = tab.querySelector('.no-results');
                        if (noResults) noResults.classList.toggle('d-none', showTab);

                        tab.classList.toggle('show', showTab);
                        tab.classList.toggle('active', showTab);

                    } else {
                        tab.classList.remove('show', 'active');
                        tab.querySelectorAll('.profile-card1, .profile-card').forEach(card => {
                            const wrapper = card.closest('.data1') || card.closest('.data');
                            if (wrapper) wrapper.style.display = 'none';
                        });

                        const leadershipContainer = tab.querySelector('.leadership-container');
                        const membersContainer = tab.querySelector('.members-container');
                        if (leadershipContainer) leadershipContainer.style.display = 'none';
                        if (membersContainer) membersContainer.style.display = 'none';

                        const noResults = tab.querySelector('.no-results');
                        if (noResults) noResults.classList.add('d-none');
                    }
                });

                // Show global "no result" message if nothing matched
                if (!anyMatchFound) {
                    const activeTab = document.querySelector('.chapter-tab');
                    if (activeTab) {
                        activeTab.classList.add('show', 'active');
                        const noResults = activeTab.querySelector('.no-results');
                        if (noResults) noResults.classList.remove('d-none');
                    }
                }
            }

            dropdown.addEventListener('change', updateView);
            searchInput.addEventListener('input', updateView);
            searchIcon.addEventListener('click', updateView);

            updateView();
        });
        </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Attach click listener to elements with class .profile-card or .profile-card1
            document.querySelectorAll(".profile-card, .profile-card1").forEach(card => {
                card.addEventListener("click", function() {
                    // Try to get data-name, then fallback to data-name1
                    const officerName = this.dataset.name || this.dataset.name1;

                    // Update modal content
                    if (officerName) {
                        document.getElementById("officerName").innerText = officerName;
                    }
                });
            });
        });
    </script>
@endsection
