<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lions International District 3241 E</title>

  <!-- Poppins font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
    rel="stylesheet" />
  <!-- Add Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


  <link rel="stylesheet" href="style.css" />
  <style>
    /* reset & base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      color: #333;
    }

    /* containers */
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* header */
    .site-header {
      padding: 20px 0;
    }

    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo svg {
      display: block;
    }

    /* nav */
    .main-nav ul {
      display: flex;
      list-style: none;
    }

    .main-nav ul li+li {
      margin-left: 30px;
    }

    .main-nav a {
      text-decoration: none;
      color: #555;
      font-weight: 500;
      transition: color 0.3s;
    }

    .main-nav a:hover {
      color: #6A0FF0;
    }

    /* buttons */
    .btn {
      display: inline-block;
      text-decoration: none;
      font-weight: 600;
      border-radius: 50px;
      transition: transform 0.2s ease, background 0.3s ease;
    }

    .btn-primary {
      padding: 12px 28px;
      background: #6A0FF0;
      color: #fff;
    }

    .btn-primary:hover {
      background: #5400c5;
      transform: translateY(-2px);
    }

    .btn-contact {
      padding: 10px 24px;
      background: #6A0FF0;
      color: #fff;
    }

    .btn-contact:hover {
      background: #5400c5;
    }

    /* hero */
    .hero {
      padding: 80px 0;
    }

    .hero-inner {
      align-items: center;
      justify-content: center;
    }

    /* left text */

    .hero-text h1 {
      font-size: 3rem;
      line-height: 1.2;
      color: #6A0FF0;
      margin-bottom: 20px;
      text-align: center;
    }

    .hero-text p {
      color: #777;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    /* slider dots */
    .slider-dots {
      margin-top: 40px;
    }

    .slider-dots .dot {
      display: inline-block;
      width: 12px;
      height: 12px;
      background: #EAE6FF;
      border-radius: 50%;
      margin-right: 10px;
      transition: background 0.3s;
    }

    .slider-dots .dot.active {
      background: #6A0FF0;
    }

    /* right image + blob */
    .hero-image {
      position: relative;
      width: 550px;
      height: 400px;
    }

    .hero-image .blob {
      position: absolute;
      top: -60px;
      right: -60px;
      width: 600px;
      height: 600px;
      background: #F0ECFF;
      border-radius: 50% 50% 20% 20%;
      z-index: 1;
    }

    .hero-image img {
      position: relative;
      z-index: 2;
      width: 100%;
      height: auto;
      animation: float 6s ease-in-out infinite;
    }

    /* keyframe for gentle float */
    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-20px);
      }
    }


    .zoom-image,
    .zoom-image1 {
      transition: transform 1.3s ease;
      cursor: pointer;
    }

    .zoom-image:hover,
    .zoom-image1:hover {
      transform: translateX(10px) translateY(20px) scale(1.6);
      /* Reduced scale for 60px base */
      z-index: 10000;
      position: relative;
    }

    .zoom-left:hover {
      transform: translateX(-20px) translateY(20px) scale(1.6);
      /* Matches visual intensity */
    }

    /* Styling for login modal box */
    .login-box {
      background: #003b6f;
      padding: 30px;
      border-radius: 15px;
      border: 5px solid #ffcc00;
      /* Yellow Border */
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
    }

    /* Logo inside the modal */
    .logo-img {
      width: 80px;
      margin-bottom: 10px;
    }

    /* Input fields */
    .input-field {
      border-radius: 10px;
      padding: 12px 15px;
      font-size: 16px;
      border: none;
      outline: none;
    }

    /* Login button with blue gradient */
    .login-btn {
      background: linear-gradient(to right, #2e98ff, #7cbfff);
      color: white;
      font-weight: bold;
      border-radius: 25px;
      padding: 10px;
      border: none;
      margin-left: 100px;
    }

    .login-btn:hover {
      border: 2px solid #ffcc00;
      color: white;
    }

    /* Password toggle eye icon */
    .toggle-password {
      position: absolute;
      top: 38px;
      right: 10px;
      background-color: #ffcc00;
      padding: 5px 8px;
      border-radius: 5px;
      cursor: pointer;
    }

    .toggle-password i {
      color: #000;
    }

    .login-btn1 {
      background: linear-gradient(to right, #2e98ff, #7cbfff);
      color: white;
      font-weight: bold;
      border-radius: 25px;
      padding: 10px;
      border: none;
      margin-left: 0px !important;
      margin-top: 50px;
    }


    .login-btn1:hover {
      border: 2px solid #ffcc00;
      color: white;
    }

    @media (max-width: 767.98px) {
      .header-row {
        flex-direction: row !important;
        justify-content: space-between !important;
        padding: 0 10px;
      }

      .header-logo img {
        height: 45px !important;
      }

      .header-title h5 {
        width: auto !important;
        font-size: 18px !important;
        margin: 0 10px;
      }

      .header-title span {
        font-size: 18px !important;
      }

      .hero-text h1 {
        font-size: 3rem;
        line-height: 1.2;
        color: #6A0FF0;
        margin-bottom: 20px;
        text-align: center;
      }

      .login-btn {
        background: linear-gradient(to right, #2e98ff, #7cbfff);
        color: white;
        font-weight: bold;
        border-radius: 25px;
        padding: 10px;
        border: none;
        margin-left: 80px !important;
      }

      .login-btn1 {
        background: linear-gradient(to right, #2e98ff, #7cbfff);
        color: white;
        font-weight: bold;
        border-radius: 25px;
        padding: 10px;
        border: none;
        margin-left: 0px !important;
        margin-top: 50px;
      }


      .login-btn:hover {
        border: 2px solid #ffcc00;
        color: white;
      }


      .login-btn1:hover {
        border: 2px solid #ffcc00;
        color: white;
      }

    }
  </style>
</head>

<body>

  <div class="w-100 text-white" style="background-color: #003366; height: 117px; z-index: 1000;">
    <div class="container-fluid h-100">
      <div class="d-flex align-items-center justify-content-center h-100 header-row">

        <!-- Left Logo -->
        <div class="header-logo">
          <img src="{{ asset('assets/images/logo.png') }}" alt="Left Logo" class="zoom-image" style="height: 60px; width: auto;">
        </div>

        <!-- Center Text -->
        <div class="text-center header-title">
          <h5 class="m-0 text-white" style="width:600px;">
            <span style="font-weight: 600; font-size:35px">Lions International District 3241 E</span><br>
          </h5>
        </div>

        <!-- Right Logo -->
        <div class="header-logo">
          <img src="{{ asset('assets/images/lo4.png') }}" alt="Right Logo" class="zoom-image zoom-left" style="height: 60px; width: auto;">
        </div>

      </div>
    </div>
  </div>

  <section class="hero" style="background: url('http://localhost/assets/images/Member Login.png') no-repeat center center; background-size: cover; min-height: 100vh;">
    <div class="container hero-inner">
      <!-- left side text -->
      <div class="hero-text w-100 ">
        <h1 class="text-warning">Site Is Under Construction</h1>

        <!-- Right-aligned button -->

        <br>
        <div class="text-center">
          <a href="#" class="btn login-btn1" data-bs-toggle="modal" data-bs-target="#loginModal" style="width: 150px; margin-left:-50px;">Log in</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: #003b6f;">

        <!-- Modal Header -->
        <div class="modal-header" style="background-color: #003b6f;">
          <h4 class="fw-bold text-white text-center col-9" style="margin-left: 50px;">Website Login</h4>
          <button type="button" class="btn-close col-3" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
        </div>

        <!-- Modal Body with Form -->
        <div class="login-box modal-body">
          <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="text-center mb-3">
              <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo-img">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label text-white">Email</label>
              <input type="email" class="form-control input-field" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3 position-relative">
              <label for="password" class="form-label text-white">Password</label>
              <input type="password" class="form-control input-field pr-5" id="password" name="password" placeholder="Enter your password" required>
              <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye"></i>
              </span>
            </div>

            <button type="submit" class="btn login-btn w-50 align-center">Login</button>
          </form>
        </div>


        {{-- SweetAlert2 Error Message --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('error'))
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{{ session("error") }}',
            confirmButtonColor: '#3085d6'
          });
        </script>
        @endif
      </div>

    </div>
  </div>



  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.querySelector(".toggle-password i");
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
</body>

</html>