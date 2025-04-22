@extends('layouts.navbar')

@section('content')



<style>
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
            <h4 class="text-center">DG Team</h4>
        </div>



        <ul class="nav nav-pills d-flex justify-content-center " id="yearTabs" role="tablist">
            <li class="nav-item text-white" role="presentation">
              <button class="nav-link active text-white" id="current-year-tab" data-bs-toggle="tab" data-bs-target="#current-year" type="button" role="tab" aria-controls="current-year" aria-selected="true">
                Current Year
              </button>
            </li>
            <li class="nav-item " role="presentation">
              <button class="nav-link text-white"id="upcoming-year-tab" data-bs-toggle="tab" data-bs-target="#upcoming-year" type="button" role="tab" aria-controls="upcoming-year" aria-selected="false">
                Upcoming Year
              </button>
            </li>
          </ul>

          <div class="tab-content mt-3" id="yearTabsContent">
            <div class="tab-pane fade show active" id="current-year" role="tabpanel" aria-labelledby="current-year-tab">
              <!-- Content for Current Year -->
              <div class="row mb-5 leader-section justify-content-center">
                @if($dgTeamMembers_current->isEmpty())

                    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <h4 id="noDataMessage" class="text-center text-white" >
                            No DG Team Found
                        </h4>
                    </div>
                @else
                    @foreach($dgTeamMembers_current as $officer)
                        @php
                            $fullName = $officer->first_name . ' ' . $officer->last_name;
                            $displayName = strlen($fullName) > 20 ? substr($fullName, 0, 20) . '...' : $fullName;
                            $displayPosition = strlen($officer->position) > 20 ? substr($officer->position, 0, 20) . '...' : $officer->position;
                        @endphp

                        <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center">
                            <div class="card text-center shadow-sm custom-card profile-card"
                                data-bs-toggle="modal"
                                data-bs-target="#profileModal"
                                data-name="{{ $fullName }}"
                                data-member-id="{{ $officer->member_id }}"
                                style="cursor: pointer;">

                                <div class="d-flex justify-content-center">
                                    <img src="{{ $officer->profile_photo ? asset('storage/app/public/' . $officer->profile_photo) : asset('assets/images/default.png') }}"
                                        alt="{{ $officer->first_name }}"
                                        class="border border-white shadow"
                                        style="width:80px; height:80px; object-fit:cover; border-radius:10px;"
                                        loading="lazy">
                                </div>

                                <div class="text-white">
                                    <span style="font-size: 12px; font-weight: bold;" title="{{ $fullName }}">{{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}</span>
                                    <br>
                                    <span class="small" title="{{ $officer->position }}">{{ $displayPosition }}</span>
                                    <br>
                                    <span style="font-size: 11px; font-weight: bold;">{{ $officer->member_id }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            </div>
            <div class="tab-pane fade" id="upcoming-year" role="tabpanel" aria-labelledby="upcoming-year-tab">

                <div class="row mb-5 leader-section justify-content-center">
                    @if($dgTeamMembers_upcoming->isEmpty())

                        <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                            <h4 id="noDataMessage" class="text-center text-white" >
                                No DG Team Found
                            </h4>
                        </div>
                    @else
                        @foreach($dgTeamMembers_upcoming as $officer)
                            @php
                                $fullName = $officer->first_name . ' ' . $officer->last_name;
                                $displayName = strlen($fullName) > 20 ? substr($fullName, 0, 20) . '...' : $fullName;
                                $displayPosition = strlen($officer->position) > 20 ? substr($officer->position, 0, 20) . '...' : $officer->position;
                            @endphp

                            <div class="col-xl-2 col-lg-4 col-md-4 mb-4 g-1 d-flex justify-content-center">
                                <div class="card text-center shadow-sm custom-card profile-card"
                                    data-bs-toggle="modal"
                                    data-bs-target="#profileModal"
                                    data-name="{{ $fullName }}"
                                    data-member-id="{{ $officer->member_id }}"
                                    style="cursor: pointer;">

                                    <div class="d-flex justify-content-center">
                                        <img src="{{ $officer->profile_photo ? asset('storage/app/public/' . $officer->profile_photo) : asset('assets/images/default.png') }}"
                                            alt="{{ $officer->first_name }}"
                                            class="border border-white shadow"
                                            style="width:80px; height:80px; object-fit:cover; border-radius:10px;" loading="lazy">
                                    </div>

                                    <div class="text-white">
                                        <span style="font-size: 12px; font-weight: bold;" title="{{ $fullName }}">{{ ucwords(strtolower(preg_replace('/[^a-zA-Z\s]/', '', $displayName))) }}</span>
                                        <br>
                                        <span class="small" title="{{ $officer->position }}">{{ $displayPosition }}</span>
                                        <br>
                                        <span style="font-size: 11px; font-weight: bold;">{{ $officer->member_id }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
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

@endsection
