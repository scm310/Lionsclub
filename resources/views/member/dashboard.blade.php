@extends('memberlayout.sidebar')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .card-container {
        display: flex;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 10px;
        width: 100%;
        max-width: 1200px;
        justify-content: space-between;
    }

    .notification-icon {
        position: relative;
        display: inline-block;
        font-size: 24px;
        cursor: pointer;
    }

    .notification-icon .badge {
        position: absolute;
        top: -8px;
        right: -8px;
        padding: 4px 6px;
        border-radius: 50%;
        background: red;
        color: white;
        font-size: 12px;
    }


    .card {
        width: 100%;
        height: 280px;
        border-radius: 20px;
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

    .card:hover {
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

    .card:nth-child(1),
    .card:nth-child(2),
    .card:nth-child(3),
    .card:nth-child(4) {
        background-image: linear-gradient(135deg, #0c52ba, #eacb18, #0c52ba);
    }

    .card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .card:nth-child(2) {
        animation-delay: 0.3s;
    }

    .card:nth-child(3) {
        animation-delay: 0.5s;
    }

    .card:nth-child(4) {
        animation-delay: 0.7s;
    }

    .card .card-header {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card .chip {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 21, 158, 0.1);
    }

    .card .chip img {
        width: 60px;
        height: 60px;
        object-fit: fill;
    }

    .card .card-footer {
        border: 1px solid yellow;
        width: 100%;
        background: rgba(21, 40, 250, 0.2);
        backdrop-filter: blur(12px);
        border-radius: 10px;
        font-size: 12px;
        margin-top: 50px;
    }

    .balance {
        font-size: 22px;
        font-weight: bold;
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

    @media screen and (max-width: 768px) {
        .card {
            margin: 0 auto;
        }
    }

    @media screen and (max-width: 575px) {
        .col-sm-6 {
            width: 50% !important;
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
    }

    /* Ensure all cards are same height */
    .card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 280px;
        text-align: center;
    }

    /* Make text responsive */
    .card-footer h6,
    .card-footer .balance {
        margin: 0;
    }

    /* Responsive font size for card footer */
    @media screen and (max-width: 768px) {
        .card-footer h6 {
            font-size: 14px;
        }

        .card-footer .balance {
            font-size: 16px;
        }

        .card i {
            font-size: 36px !important;
        }
    }

    @media screen and (max-width: 480px) {
        .card-footer h6 {
            font-size: 12px;
        }

        .card {
            height: 207px;
        }

        .card-footer .balance {
            font-size: 14px;
        }

        .card i {
            font-size: 30px !important;
        }
    }
</style>

<style>
    /* Position wrapper in top-right */
    .notification-icon {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
    }

    /* Bell icon */
    #notificationIcon {
        font-size: 24px;
        color: #555;
        cursor: pointer;
    }

    /* Red badge */
    .notification-count {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: #fff;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 12px;
    }

    /* Dropdown panel */
    .notification-dropdown {
        position: absolute;
        top: 34px;
        right: 0;
        /* dropdown aligned to right */
        width: 220px;
        max-height: 260px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        padding: 6px 0;
        z-index: 9999;
    }

    /* Items & styles same as before */
    .notification-item {
        display: block;
        margin: 4px 8px;
        padding: 8px 12px;
        border-radius: 8px;
        color: #202124;
        font-size: 15px;
        text-decoration: none;
        transition: background-color .2s, padding-left .2s;
    }

    .notification-item:hover {
        background: #f1f3f4;
        padding-left: 16px;
    }

    .no-announcements {
        margin: 12px;
        text-align: center;
        color: #777;
        font-style: italic;
        font-size: 14px;
    }
</style>




<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div>
                    <i class="fas fa-users" style="font-size: 44px; color: white;"></i>
                </div>
                <div class="card-footer">
                    <h6>Total Members</h6>
                    <p class="balance">{{ DB::table('add_members')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div>
                    <i class="fas fa-building" style="font-size: 44px; color: white;"></i>
                </div>
                <div class="card-footer">
                    <h6>Total Clubs</h6>
                    <p class="balance">{{ DB::table('chapters')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div>
                    <i class="fas fa-map-marked-alt" style="font-size: 44px; color: white;"></i>
                </div>
                <div class="card-footer">
                    <h6>District</h6>
                    <p class="balance">{{ DB::table('district')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div>
                    <i class="fas fa-eye" style="font-size: 44px; color: white;"></i>
                </div>
                <div class="card-footer">
                    <h6>Visitors Count</h6>
                    <p class="balance">
                        {{ DB::table('visitors')->distinct('ip_address')->count('ip_address') }}
                    </p>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Add the following JavaScript at the bottom of your page or in a script section -->
<script>
    // Get the bell icon and the dropdown
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationDropdown = document.getElementById('notificationDropdown');

    // Toggle dropdown visibility on bell icon click
    notificationIcon.addEventListener('click', function() {
        // Toggle the display of the dropdown (show or hide)
        if (notificationDropdown.style.display === 'none') {
            notificationDropdown.style.display = 'block';
        } else {
            notificationDropdown.style.display = 'none';
        }
    });

    // Optional: Close the dropdown if clicked outside of the bell icon
    window.addEventListener('click', function(event) {
        if (!notificationIcon.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.style.display = 'none';
        }
    });
</script>





@endsection