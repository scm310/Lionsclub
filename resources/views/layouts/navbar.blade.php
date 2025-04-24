<!-- resources/views/layouts/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lions International District 3241 E</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (for Tabs) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


</head>

<style>
    .top-ad-banner {
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
    }

    .top-ad-banner-image {
        width: 100%;
        max-width: 600px;
        height: auto;
        border-radius: 10px;
    }

    .prev-btn,
    .next-btn {
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 18px;
        border-radius: 5px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }

    .prev-btn {
        left: 5px;
    }

    .next-btn {
        right: 5px;
    }

    .prev-btn:hover,
    .next-btn:hover {
        background-color: rgba(0, 0, 0, 0.7);
    }

    /* Sticky Header */
    .header {
        position: sticky;
        top: 1;
        background-color: #003366;
        z-index: 1000;
        padding: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 67px;
    }

    /* Sticky Top Ad Banner */
    .top-ad-container {
        position: sticky;
        top: 60px;
        background-color: #ffcc00;
        z-index: 999;
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Sticky Navigation Menu */
    .nav-container {
        position: sticky;
        top: 198px;
        background-color: #003366;
        z-index: 998;
        padding: 2px;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    .nav-menu li {
        margin: 0 15px;
    }

    .nav-menu li a {
        text-decoration: none;
        color: white;

        padding: 5px 15px;
        display: inline-block;
    }

    .nav-menu li a:hover {
        background-color: #00509e;
        border-radius: 5px;
    }

    .nav-menu li a.active {
        color: black;
        background-color: #ffcc00;
        border-radius: 5px;
    }

    .header img {
        max-width: 100px;
        margin-right: 0px;
        transition: transform 0.3s ease-in-out;
    }

    .mainlogo img {
        margin-left: 20px;
        width: 50px !important;
        height: 50px !important;
    }

    .zoom-image,
    .zoom-image1 {
        transition: transform 0.3s ease;
    }

    .zoom-image:hover,
    .zoom-image1:hover {
        transform: scale(3.2) translateY(30px);
    }


    .dropdown-menu {
        display: none;
        list-style: none;
        padding: 0;
        margin-top: 5px;
        background-color: #00509e;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        min-width: 100px;
    }

    .show {
        display: block !important;
    }

    .mobilescreen,
    #mobilescreen {
        display: none;
    }


    .stickyhead {
        position: sticky;
        top: 0;
        z-index: 997;


        text-align: center;

    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .animated-btn {
        border: 1px solid #ffcc00;
        background: linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(97, 149, 219) 158.5%);
        animation: pulse 1.5s infinite ease-in-out;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
        width: auto;
        text-align: center;
        margin-top: 3px;
        /* This moves the button slightly down */
    }


    .nav-menu a {
        font-weight: normal;
    }




    @media (max-width: 768px) {

        .mobile,
        #mobile {
            display: none;
        }


        .mobilescreen,
        #mobilescreen {
            display: block;
        }

        .stickyhead {
            position: sticky;
            top: 0;
            /* Adjusted to follow after the navigation bar */
            background-color: white;
            z-index: 997;
            padding: 10px;

            text-align: center;

        }


        .nav-menu-wrapper {
            width: 100%;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .nav-menu {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            width: max-content;
            overflow-x: auto;
        }

        .nav-menu li {
            display: inline-block;
        }

        .nav-menu a {
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
        }
    }

    @media (min-width: 769px) {
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    }

    @media (max-width: 768px) {
        .dropdown-menu {
            position: static;
            width: 100%;
        }

        .nav-menu li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 0px 10px;
            display: inline-block;
        }

        .nav-menu a {
            font-size: 10px;
        }

        .zoom-image,
        .zoom-image1 {
            transition: transform 0.3s ease;
        }

        .zoom-image:hover,
        .zoom-image1:hover {
            transform: scale(3.2) translateY(30px);
        }

    }

    .nav-menu li {
        margin: 0 10px;
    }



    /* On mobile: change only the top value */
    @media (max-width: 768px) {
        .nav-container {
            top: 370px;
        }

        .mb {
            display: none;
        }


    }

    @media (max-width: 768px) {
        .stickyhead {
            padding: 0px !important;
            /* padding cannot be negative */
        }

        .nav-menu a:hover {
            background-color: white;
        }
        .social{
        margin-left:155px
    }


    footer {
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 10px !important;
    }

    footer .social {
        justify-content: center !important;
        gap: 10px !important;
        margin: 8px 0;
    }

    footer p {
        font-size: 12px !important;
        margin: 2px 0 !important;
    }

    }

    .social{
        margin-left:155px
    }

    .awards{
        transform: translateY(-5px);
    }
</style>

{{-- popup banner start--}}

@include('website.partial.popupbanner')

{{-- popup banner End--}}

<div class="stickyhead">

    <!-- Header Section -->
    <div class="top-ad-container mobile">
        @include('Frontend.bannersincludes.banner')
    </div>
  

    <div class="mobilescreen">
        @include('Frontend.mobile.mobilebanner')
    </div>
</div>


<!-- Navigation Menu -->
<div class="nav-container mb">
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
                <a class="nav-link dropdown-toggle {{ request()->routeIs('award.index') ? 'active' : '' }}" href="#" id="resourcesDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Resources
                </a>
                <ul class="dropdown-menu awards" aria-labelledby="resourcesDropdown">
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
</div>
<!-- JavaScript to toggle dropdown on click -->
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("resourcesDropdown");
        dropdown.classList.toggle("show");
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".resources-link").forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent navigation

                let menu = this.nextElementSibling;

                // Close other open dropdowns
                document.querySelectorAll(".dropdown-menu").forEach(function(otherMenu) {
                    if (otherMenu !== menu) {
                        otherMenu.style.display = "none";
                    }
                });

                // Toggle visibility of the clicked dropdown
                menu.style.display = (menu.style.display === "block") ? "none" : "block";
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function(event) {
            if (!event.target.closest(".dropdown")) {
                document.querySelectorAll(".dropdown-menu").forEach(function(menu) {
                    menu.style.display = "none";
                });
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#resourcesDropdown").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default link behavior

            let menu = this.nextElementSibling; // Get the dropdown menu

            // Toggle only this dropdown
            menu.classList.toggle("show");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function(event) {
            if (!event.target.closest(".dropdown")) {
                document.querySelectorAll(".dropdown-menu").forEach(function(menu) {
                    menu.classList.remove("show");
                });
            }
        });
    });
</script>


<!-- Main Content Area -->
<div class="content">
    @yield('content')
</div>

<!-- Footer -->
<br> <br>

<footer class="site-footer"  style="bottom: 0; left: 0; width: 100%; background-color: #003366; padding: 15px 16px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; color: white; font-size: 11px; line-height: 1.4; z-index: 9999; margin-top:-45px;">

<?php

$footer = \App\Models\FooterSetting::first();

?>
   <p style="margin: 0;">&copy; {{ date('Y') }} {{ $footer->copyright_text ?? '@copyright' }}</p>

    @if($footer)
    <div style="display: flex; gap: 15px;" class="social">
        @if($footer->facebook_link)
        <a href="{{ $footer->facebook_link }}" target="_blank" style="color: white;"><i class="fab fa-facebook-f"></i></a>
        @endif
        @if($footer->twitter_link)
        <a href="{{ $footer->twitter_link }}" target="_blank" style="color: white;"><i class="fab fa-twitter"></i></a>
        @endif
        @if($footer->instagram_link)
        <a href="{{ $footer->instagram_link }}" target="_blank" style="color: white;"><i class="fab fa-instagram"></i></a>
        @endif
    </div>

    <p style="margin: 0;">Powered by Accelerated Development Machines</p>
    @else
    <div style="display: flex; gap: 30px;">
        <p style="margin: 0;">&copy; {{ date('Y') }} Lions Club. All Rights Reserved.</p>
        <p style="margin: 0;">Powered by Accelerated Development Machines</p>
    </div>
    @endif

</footer>






<script>
    document.addEventListener("DOMContentLoaded", function() {
        const activeItem = document.querySelector(".nav-menu a.active");

        if (activeItem && window.innerWidth <= 768) {
            // Scroll the parent wrapper to the active menu item
            activeItem.scrollIntoView({
                behavior: "smooth",
                inline: "center",
                block: "nearest"
            });
        }
    });
</script>



</body>

</html>