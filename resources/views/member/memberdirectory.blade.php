@extends('layouts.navbar')

@section('content')


<style>
    /* Member Directory Heading (Full-width, centered) */
.member-heading {
    font-size: 19px !important;
    font-weight: bold !important;
    text-align: center !important;
    width: 100% !important;

    color: #333 !important; /* White Text */
    padding: 15px 0 !important;
    border-radius: 5px !important;
    margin-bottom: 15px !important;
}

/* Tabs should be in a single row and centered */
/* Tabs should be in a single row and centered */
.nav-pills {
    display: flex !important;
    flex-wrap: nowrap !important;
    justify-content: center !important;
    gap: 0px !important;
    overflow-x: auto !important;
    white-space: nowrap !important;
    padding: 10px !important;
    border-radius: 5px !important;
   
}

/* Default tab styling - transparent background */
.nav-pills .nav-link {
    color: #000 !important; /* Default text color */
    background-color: transparent !important; /* Fully transparent background */
    border: none !important; /* No border */
    font-weight: 600;
    padding: 10px 15px;
}

/* Active tab styling */
.nav-pills .nav-link.active {
    background-color: #003366 !important; /* No background */
    color: #ffffff !important; /* Active tab text color */
    font-weight: bold; /* Make it stand out */
    border-bottom: 2px solid #003366 !important; /* Underline effect for active tab */
}


/* Tab Content Styling */
.tab-content {
    background: #f8f9fa !important;
    padding: 20px !important;
    border-radius: 5px !important;
    min-height: 200px !important;
    border: 1px solid #ddd !important;
}


/* Member Card Styling */
.member-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    width:200px;
}

.member-card:hover {
    transform: translateY(-5px);
}

.profile-img {
    width: 100%;
    height: 200px;
    object-fit: ;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.profile-img {
        transition: transform 0.3s ease-in-out;
    }

    .profile-img:hover {
        transform: scale(1.5); /* Enlarges the image by 20% on hover */
    }

.card-body {
    background: #fff;
    padding: 0px;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.card-text {
    font-size: 14px;
    color: #777;
}


.card {
    width: 100%; /* Adjust the card width if needed */
    max-width: 333px; /* Limit max width */
    margin: auto; /* Center the card */
}

.card-img-top {
    height: 120px; /* Reduce image height */
    object-fit: fill; /* Maintain aspect ratio */
}

.card-body {
    padding: 10px; /* Reduce padding for a compact look */
}

.card-title {
    font-size: 16px; /* Reduce title size */
}

.card-text {
    font-size: 14px; /* Reduce text size */
}


</style>


<div class="container mt-4"  style="max-width: 1400px !important;">
    <!-- Full-Width Heading (Takes full row) -->
    <div class="row">
        <div class="col-12">
            <h5 class="member-heading">Member Directory</h5>
        </div>
    </div>

    <!-- Tabs Navigation (Single row below the heading) -->
 <div class="row mt-2">
    <div class="col-12">
        <ul class="nav nav-pills justify-content-center flex-row" id="memberTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#international">International Officers</a>
            </li>
            <li class="nav-item">
        <a class="nav-link " 
           href="{{ route('districtgovernor') }}">District Governor</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " 
           href="{{ route('pastdistrictgovernor') }}">Past District Governor</a>
    </li>

    <li class="nav-item">
        <a class="nav-link " 
           href="{{ route('dgteam') }}">DG Team</a>
    </li>

    <li class="nav-item">
        <a class="nav-link " 
           href="{{ route('districtchairperson') }}">District Chairperson</a>
    </li>
        </ul>
    </div>
</div>


    <!-- Tab Content (Displays below tabs) -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="tab-content">
            <div id="international" class="tab-pane fade show active">
    <h3 class="text-center mb-4">International Officers</h3>

    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-3 col-sm-6 mb-3">
    @include('member.internationalofficer')
</div>




    </div>
</div>









             



            </div>
        </div>
    </div>
</div>



@endsection
