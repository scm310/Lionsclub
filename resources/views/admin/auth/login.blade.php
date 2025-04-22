<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {

            margin: 0;
            padding: 0;

        }

        h1.tittle {
            font-size: 15px;
        }

        .stickyhead {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 997;
            padding: 10px;
            text-align: center;
        }


        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 35px;
            border-radius: 10px;
            border: 6px solid #ffcc00;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background: #003366;
            color: #ffffff;
        }

        .login-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: bold;
        }

        .login-logo {
            width: 80px;
            height: 80px;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 0px;
            top: 73%;
            transform: translateY(-50%);
            background: #ffcc00;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toggle-password i {
            color: #003366;
        }

        .custom-btn {
            margin-top: 15px;
            background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 24px;
        }

        .custom-btn:hover {
            transition: none;
            border: 2px solid #ffcc00;
        }

        .zoom-image1 {
            transform: translateX(-265px);
        }

        .zoom-image {
            transform: translateX(265px);
        }

        #district-img {
            height: 50px;
            width: 60px;
        }
.blue-strip {
    background-color: #003366;
    width: 100vw;
    margin-left: 0;
    margin-right: 0;
}
.container-fluid {
    padding-left: 0;
    padding-right: 0;
}

       
    </style>

<style>
@media (max-width: 576px) {
    #heading-card {
        margin: 10px;
        border-radius: 12px;
        height: 60px;
    }

    #heading-card .card-body {
        padding: 12px !important;
        flex-direction: column !important;
        text-align: center !important;
        gap: 10px !important;
    }

    #heading-card h1 {
        font-size: 1rem !important;
        margin: 5px 0;
    }

    #heading-card img {
        height: 40px !important;
        width: 40px !important;
    }
  
}



</style>


</head>

<div class="container-fluid" style="background: url('{{ asset('assets/images/Member Login.png') }}') no-repeat center center; background-size: cover; min-height: 100vh;">

    <!-- Blue Strip with Text -->
    <div class="blue-strip py-3 w-100" style="margin: 0;">
    <div class="d-flex justify-content-center align-items-center gap-2">
        <!-- Left Image -->
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="strip-logo">

        <!-- Center Text -->
        <h4 class="m-0 text-light text-nowrap"> Lions International District 3241 E</h4>

        <!-- Right Image -->
        <img src="{{ asset('assets/images/lo4.png') }}" alt="Logo" class="strip-logo">
    </div>
</div>

    <div class="row min-vh-100 justify-content-center align-items-center">
        <!-- Member Cards Column -->
        <div class="col-12 col-md-6 mb-4 mb-md-0 mb-5">
            <div class="row justify-content-center">
                @foreach ($members as $member)
                <div class="col-12 col-sm-6 col-md-12 d-flex justify-content-center mb-3">
                    <div class="card text-center shadow-sm mt-1"
                        style="border: 3px solid #ffc107; border-radius: 15px; padding: 20px; width: 100%; max-width: 300px; background: #fff;">
                        <img src="{{ asset('storage/app/public/' . $member->image) }}"
                            alt="{{ $member->name }}"
                            class="mx-auto d-block mb-3"
                            style="height: 150px; width: 150px; object-fit: fill; border-radius: 10px;" />
                        <h5 class="text-primary fw-bold mb-1" style="font-size: 1.2rem;">{{ $member->name }}</h5>
                        <p class="fw-bold text-dark mb-0" style="font-size: 1rem;">{{ $member->role }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Login Card Column -->
        <div class="col-12 col-md-6 d-flex justify-content-center mb-5">
            <div class="card login-card">
                <h3 class="text-center mb-4 login-title">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="login-logo">
                    Admin Login
                </h3>

                @if (session('success'))
                <div class="alert alert-success" id="successMessage">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3 password-container">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button class="toggle-password" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn custom-btn px-4 py-2 mx-auto d-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .blue-strip {
        background-color: #003366;
    }

    .strip-logo {
        height: 60px;
        width: 60px;
        object-fit: contain;
    }

    @media (max-width: 576px) {
        .strip-logo {
            height: 30px;
            width: 30px;
        }

        .blue-strip h4 {
            font-size: 1.1rem;
        }
    }
</style>


    <!-- Password Toggle Script -->
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            let passwordField = document.getElementById("password");
            let icon = this.querySelector("i");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });

        setTimeout(function() {
            let successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.transition = "opacity 0.5s ease";
                successMessage.style.opacity = "0";
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 4000);
    </script>

    <!-- SweetAlert for Error -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Oops, you do not have admin access.',
                width: '350px',
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: true,
                didOpen: () => {
                    document.body.style.overflow = 'hidden';
                },
                willClose: () => {
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
    @endif

</body>

</html>