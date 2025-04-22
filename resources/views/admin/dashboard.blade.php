@extends('MasterAdmin.layout')

<style>
    .card-container {
        display: flex;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 10px;
        width: 100%;
        max-width: 1200px;
        justify-content: space-between;
    }

     .custom-card {
        width: 200px;
        height: 240px !important;
        border-radius: 20px !important;
        position: relative;
        overflow: hidden;
        padding: 20px;
        color: white;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-size: 400% 400%;
        animation: fadeInUp 0.8s ease forwards, gradientShift 6s ease infinite;
        opacity: 0;
    }

    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 100%;
        }

        50% {
            background-position: 100% 100%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .custom-card:nth-child(1),
    .custom-card:nth-child(2),
    .custom-card:nth-child(3),
    .custom-card:nth-child(4) {
        background-image: linear-gradient(135deg, #0c52ba, #eacb18, #0c52ba);
    }




    .custom-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .custom-card:nth-child(2) {
        animation-delay: 0.3s;
    }

    .custom-card:nth-child(3) {
        animation-delay: 0.5s;
    }

    .custom-card:nth-child(4) {
        animation-delay: 0.7s;
    }

    .custom-card-footer {
        border: 1px solid yellow;
        width: 100%;
        background: rgba(21, 40, 250, 0.2);
        backdrop-filter: blur(12px);
        border-radius: 10px !important;
        font-size: 12px;
        margin-top: 80px;
        height: 80px !important;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h5 {
        font-size: 15px !important;
        color: white !important
    }

    p {
        color: white !important;
        font-size: 16px !important;
        font-weight: 700;
    }



    @media screen and (max-width: 768px) {
        .custom-card {
            width:170px;
        }
        .container{
            margin-top:20px;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 935px !important;
        }
    }

    .icon-box {
    font-size: 36px;
    margin-bottom: 20px;
    color: #fff;
}

</style>

@section('content')

<h2 class="text-center fw-bold" style="color:rgb(233, 232, 227); margin-top: 20px;">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lions Club Logo" width="70" height="70" class="mb-1">
    Welcome to Lions Club Admin!
</h2>

<!-- Cards Section -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="custom-card text-center">
                <div class="icon-box">
                    <i class="fas fa-users"></i>
                </div>
                <div class="custom-card-footer">
                    <p class="label">Total Members</p>
                    <h5 class="value">{{ $memberCount }}</h5>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="custom-card text-center">
                <div class="icon-box">
                    <i class="fas fa-building"></i>
                </div>
                <div class="custom-card-footer">
                    <p class="label">Total Clubs</p>
                    <h5 class="value">{{ $chapterCount }}</h5>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="custom-card text-center">
        <div class="icon-box">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <div class="custom-card-footer">
            <p class="label">District</p>
            <h5 class="value">{{ $districtCount }}</h5>
        </div>
    </div>
</div>

<div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="custom-card text-center">
        <div class="icon-box">
            <i class="fas fa-eye"></i>
        </div>
        <div class="custom-card-footer">
            <p class="label">Visitors Count</p>
            <h5 class="value">{{ $visitorCount }}</h5>
        </div>
    </div>
</div>

    </div>
</div>


@endsection