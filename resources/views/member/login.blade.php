<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>Member Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/loginform/css/style.css') }}">
</head>
<!-- Add CSS for Blur Effect and Custom Button -->
<style>
    body {
        overflow-y: auto;
    }


    /* Animated Glowing Border */
    @keyframes glowingBorder {
        0% {
            box-shadow: 0 0 5px #0033cc, 0 0 10px #ffcc00;
        }

        50% {
            box-shadow: 0 0 20px #ffcc00, 0 0 30px #0033cc;
        }

        100% {
            box-shadow: 0 0 5px #0033cc, 0 0 10px #ffcc00;
        }
    }

    .login-card {
        position: relative;
        background: rgba(51, 51, 51, 0.85);
        /* Dark semi-transparent */
        backdrop-filter: blur(10px);
        /* Glassmorphism effect */
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
        overflow: hidden;
        width:400px;
        margin-top:50px;
        left:135px;
        animation: glowingBorder 2.5s infinite alternate ease-in-out;
    }

    /* Gradient Animated Border */
    .login-card::before {
        content: "";
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: linear-gradient(90deg, #0033cc, #ffcc00, #0033cc);
        z-index: -1;
        border-radius: 12px;
        animation: borderMove 3s linear infinite;
    }

    /* Inner Layer to Keep Content Readable */
    .login-card::after {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        background: rgba(51, 51, 51, 0.95);
        border-radius: 8px;
        z-index: 0;
    }

    /* Button Customization */
    .custom-btn {
        background-color: #0033cc;
        /* Blue */
        border: 2px solid #ffcc00;
        /* Yellow */
        width: 50%;
        color: white;
        border-radius: 13px;
        transition: all 0.3s ease-in-out;
        text-transform: capitalize;
    }

    .custom-btn:hover {
        color: black;
        border-radius: 13px;
        background-color: #ffcc00;
        /* Yellow */
        border-color: #0033cc;
    }


    /* Ensure content is above the overlay */
    .login-card .card-body {
        position: relative;
        z-index: 1;
    }



    /* Input Field Styling */
    .custom-input {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid transparent;
        color: white;
        height: 40px;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .custom-input:focus {
        border-color: #ffcc00;
        background: rgba(255, 255, 255, 0.2);
    }

    /* Password Toggle Icon */
    .field-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #ffcc00;
    }

    /* Heading Styling */
    .heading-section {
        font-weight: bold;
        font-size: 22px;
        letter-spacing: 1px;
    }

    .ftco-section {
    padding: 0em 0;
}
    /* Mobile View Adjustments */
    @media (max-width: 768px) {

        body {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            height: 100vh;
        }

        .login-card {
            width:-webkit-fill-available;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top:50px;
            left:0px;
        }

        .custom-btn {
            width:50%;
            font-size: 16px;
            padding: 10px;
        }

        .custom-input {
            height: 35px;
            font-size: 14px;
            padding: 8px;
        }

        .heading-section {
            font-size: 20px;
        }

        .field-icon {
            right: 10px;
        }

        .checkbox-wrap {
            font-size: 14px;
        }
    }
</style>


<style>
    /* Sticky Header */
    .header {
        position: sticky;
        top: 0;
        background-color: #003366;
        z-index: 1000;
        padding: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 67px;
    }

    /* Sticky Navigation Menu */
    .nav-container {
        position: sticky;
        top: 260px;
        background-color: #003366;
        z-index: 998;
        padding: 2px;
    }

    .header img {
        margin-top:-40px;
        max-width: 100px;
        margin-right: 0px;
        transition: transform 0.3s ease-in-out;
    }

    .mainlogo img {
        margin-left: 20px;
        width: 50px !important;
        height: 50px !important;
    }

    .zoom-image1{
        transform: translateX(-265px);
    }

   .tittle{
    transform: translateY(-20px);
   }
    
    .zoom-image{
        transform: translateX(265px);
    }

    .zoom-image:hover {
        transform: scale(3.2) translateY(31%) translateX(30px);
        transform-origin: center;
    }

    .zoom-image1:hover {
        transform: scale(3.2) translateY(80%) translateX(-100px);
        transform-origin: center;
    }

    .mobilescreen,
    #mobilescreen {
        display: none;
    }

    .container{
        margin-top: 50px;
    }

    .card{
        height: 285px !important;
        transform:translateY(90px);
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
        .zoom-image{
        transform: translateX(-10px);
        margin-top:-22px !important;
    }

        
        .zoom-image1{
        transform: translateX(0px);
        margin-top:-10px;
    }

        .zoom-image:hover {
            transform: scale(2.2) translateY(7%) translateX(30px);
            transform-origin: center;
        }

        .zoom-image1:hover {
            transform: scale(2.2) translateY(7%) translateX(-20px);
            transform-origin: center;
        }

        .ftco-section {
    padding:0rem 0;
}

.card{
        height: 285px !important;
        transform:translateY(0px);
    } 

.js-fullheight{
    height:107vh !important;
}
    }
</style>

<body class="img js-fullheight" style="background-image: url('{{ asset('assets/images/Member Login.png') }}');">



@php
    use Illuminate\Support\Facades\DB;
    $member = \App\Models\MemberDetail::first(); // Fetch first member from the table

    $banners_10000 = DB::table('banner_10000')->select('image_path', 'url')->get();
    $banners_5000 = DB::table('banner_5000')->select('image_path', 'url')->get();
    $banners_1000 = DB::table('banner_1000')->select('image_path', 'url')->get();

    $bannerData = [
        '10000' => $banners_10000,
        '5000' => $banners_5000,
        '1000' => $banners_1000,
    ];

@endphp

<div class="header mobile p-3 col-lg-12 d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
    <!-- Left Logo -->
    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="zoom-image" loading="lazy"
        style="height:100px; width:100px;" />

    <!-- Heading -->
    <h1 class="m-0 text-center flex-grow-1 text-light tittle" style="font-size:35px; white-space: nowrap;">
        Lions International District 3241 E
    </h1>

    <!-- Right Logo -->
    <div class="mainlogo">
        <img src="{{ asset('assets/images/lo4.png') }}" alt="Logo" class="zoom-image1" loading="lazy"
            style="height:100px; width:100px;" />
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Member Card Section -->
            <div class="col-12 col-md-6 col-lg-5 mb-3 d-flex justify-content-center">
                @if ($member)
                <div class="card text-center shadow-sm"
                    style="border: 3px solid #ffc107; border-radius: 15px; padding: 20px; width: 100%; max-width: 300px;">
                    <img src="{{ asset('storage/app/public/' . $member->image) }}"
                        alt="{{ $member->name }}"
                        class="mx-auto d-block mb-3"
                        style="height: 150px; width: 150px; object-fit: fill; border-radius: 10px;" />
                    <h5 class="text-primary fw-bold mb-1" style="font-size: 1.2rem;">{{ $member->name }}</h5>
                    <p class="fw-bold text-dark mb-0" style="font-size: 1rem;">{{ $member->role }}</p>
                </div>
                @endif
            </div>

            <!-- Login Form Section -->
            <div class="col-12 col-md-6 col-lg-5 mb-3">
                <div class="login-card">

                    <div class="card-body shadow-lg rounded">
                    @if(session('error'))
                        <div style="background-color: #f1cece; color: #0a0a0a; padding: 10px; border-radius: 5px; margin-bottom: 15px; position: relative;">
                            {{ session('error') }}
                            <button onclick="this.parentElement.style.display='none'" style="position: absolute; top: 5px; right: 10px; background: none; border: none; font-weight: bold;">&times;</button>
                        </div>
                    @endif
                        <h5 class="heading-section text-center">Member Login</h5>
                        <form action="{{ route('member.login') }}" method="POST" class="signin-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="member_id" class="form-control custom-input" placeholder="Member ID" required>
                            </div>

                            <div class="form-group position-relative">
                                <input id="password-field" type="password" name="password" class="form-control custom-input" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn custom-btn">Login</button>
                            </div>

                            <div class="form-group d-flex justify-content-center">
    <label class="checkbox-wrap checkbox-primary">Remember Me
        <input type="checkbox" name="remember">
        <span class="checkmark"></span>
    </label>
</div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional: Mobile-Specific CSS -->
<style>
@media (max-width: 767.98px) {
    .header h1 {
        font-size:13px !important;
        white-space: normal !important;
        transform: translateY(10px);
        margin-left:-17px !important;
    }
    .header {
        flex-direction: column;
        align-items: center !important;
        text-align: center;
    }


   

    .header img {
        max-width:75px;
        margin-right: 13px;
        transition: transform 0.3s ease-in-out;
    }

    .mainlogo img {
        width: 40px !important;
        height: 40px !important;
        margin-top: -2px;
    }
}
</style>



    <script src="{{ asset('assets/loginform/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/popper.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/main.js') }}"></script>
</body>

</html>