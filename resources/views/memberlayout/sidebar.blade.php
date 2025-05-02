<!doctype html>
<html lang="en">

<head>
    <title>Member Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/member/css/style.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


    <style>
        /* ✅ Sidebar Gradient Background */
        #sidebar {
            background: linear-gradient(115deg, #0f0b8c, #77dcf5);
            min-height: 100vh;
            color: white;
            width: 250px;
            /* ✅ Fixed width */
            flex-shrink: 0;
            /* ✅ Prevent it from shrinking */
        }

        /* ✅ Sidebar Text Styling */
        #sidebar h5,
        #sidebar a {
            color: white !important;
        }

        /* ✅ Sidebar Hover Effect */
        #sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        /* ✅ Light Background for Main Content */
        #content {
            background-color:#fffd8c !important;
            min-height: 100vh;
        }

        /* ✅ Reusable Profile Photo Styling */
        .profile-photo {
            height: 100px;
            width: 90px;
            object-fit: cover;
            border-radius: 3px;
            display: block;
            margin: 0 auto;
        }

        .default-photo {
            height: 80px;
            width: 80px;
            object-fit: fill;
            border-radius: 0;
            display: block;
            margin: 0 auto;
        }

        .img-small {
            width: 80px;
            /* Adjust size as needed */
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }

        .square-img {
            width: 80px;
            height: 80px;
            object-fit: fill;
            border-radius: 0;
            /* Square corners */
            display: block;
            margin: 0 auto;
            border-radius: 10%;
        }

        /* Default: Sidebar visible */
        #sidebar {
            transition: transform 0.3s ease;
        }

        .wrapper {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
        }



        @media (max-width: 991.98px) {
            #sidebar {
                width: 250px;
                /* ✅ Same as desktop */
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1050;
            }



            #sidebar.active {
                transform: translateX(0);
            }

            /* Overlay effect */
            #overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1040;
            }

            #overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>

    <div id="overlay"></div>

    <div class="wrapper d-flex align-items-stretch">
        <!-- ✅ Sidebar -->
        @php
        $member = Auth::guard('member')->user();
        @endphp

        <nav id="sidebar">
            <div class="p-4 text-center">

                <!-- ✅ Profile Image -->
                <div class="profile-img mb-3">
                    @if($member && $member->profile_photo)
                    <img src="{{ asset('storage/app/public/' . $member->profile_photo) }}"
                        alt="Profile Picture" class="shadow img-small square-img">
                    @else
                    <img src="{{ asset('assets/images/default.png') }}"
                        alt="Default Profile" class="shadow img-small square-img">
                    @endif
                </div>

                <!-- ✅ Welcome Message -->
                @if($member)
                <p class="mt-2 mb-0" style="font-size: 15px; font-weight: 600;">Welcome,</p>
                <p style="font-size: 14px;">{{ $member->first_name }} {{ $member->last_name }}!</p>
                @else
                <p class="mt-2" style="font-size: 15px;">Welcome, Guest!</p>
                @endif



                <!-- ✅ Sidebar Menu with Icons -->
                <ul class="list-unstyled components mb-5 text-left">
                    <li class="mb-3">
                        <a href="{{ route('member.dashboard') }}" class="d-flex align-items-center">
                            <i class="fa fa-home" style="min-width: 20px; margin-right: 10px;"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('member.edit') }}" class="d-flex align-items-center">
                            <i class="fa fa-user" style="min-width: 20px; margin-right: 10px;"></i>
                            <span>Member Profile</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('member.lounge') }}" class="d-flex align-items-center">
                            <i class="fa fa-users" style="min-width: 20px; margin-right: 10px;"></i>
                            <span>Member Lounge</span>
                        </a>
                    </li>
                    <li class="mb-3">
    <a href="{{ route('member.announcements') }}" class="d-flex align-items-center">
        <i class="menu-icon tf-icons bx bx-microphone" style="min-width: 20px; margin-right: 10px;"></i>
        <span>Announcements</span>
    </a>
</li>


                    <li class="mb-3">
                        <a href="{{ route('member.updatePassword') }}" class="d-flex align-items-center">
                            <i class="fa fa-lock" style="min-width: 20px; margin-right: 10px;"></i>
                            <span>Update Password</span>
                        </a>
                    </li>
                    <li class="mb-3">
    <a href="{{ route('member.insights') }}" class="d-flex align-items-center">
        <i class="fa fa-bar-chart" style="min-width: 20px; margin-right: 10px;"></i> 
        <span>Insights</span>
    </a>
</li>
                    <li>
                        <a href="{{ route('member.logout') }}" class="d-flex align-items-center">
                            <i class="fa fa-sign-out" style="min-width: 20px; margin-right: 10px;"></i>
                            <span>Log Out</span>
                        </a>
                    </li>
                </ul>


            </div>
        </nav>


        <!-- ✅ Page Content -->
        <div id="content" class="p-3">
            <!-- ✅ Mobile Toggle Button -->
            <button class="btn btn-dark d-lg-none mb-3" id="sidebarToggle">
                <i class="fa fa-bars"></i>
            </button>


            @yield('content')
        </div>

    </div>




    <!-- ✅ Scripts -->
    <script src="{{ asset('assets/member/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/member/js/popper.js')}}"></script>
    <script src="{{ asset('assets/member/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/member/js/main.js')}}"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('show');
        });
    </script>

</body>

</html>