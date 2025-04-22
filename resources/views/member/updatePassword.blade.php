@extends('memberlayout.sidebar')

@section('content')

<!-- Bootstrap 5 JS (Popper + Bootstrap Bundle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        /* Ensures text is readable */
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        /* Optional rounded edges */
        display: inline-block;
        /* Adjusts width to fit content */
        width: 100%;
        /* Ensures it spans across the container */
    }

    .custom-btn {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        color: white;
    }

 
    @media (max-width: 430px) {
    .custom-heading {
        font-size: 1.1rem;
        padding: 8px;
    }

    .custom-btn {
        width: 73%;
        font-size: 12px;
        }

    .alert {
        max-width: 100% !important;
    }

    .mt-5 {
        width: 133%;
        margin-left: -39px;
    }

    .form-control {
        font-size: 0.95rem;
    }

    label {
        font-size: 0.9rem;
    }
}

</style>

<div class="container mt-4">
    <div class="card shadow-lg p-4 bg-white rounded">
        <!-- Profile Header Strip -->
        <h3 class="mb-0 custom-heading">Update Password</h3>

        <div class="card-body">

            <!-- Success Message -->
            @if(session('success'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-success alert-dismissible fade show text-center" style="max-width: 350px; width: 90%;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
            </div>
            @endif


            <!-- Error Message -->
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6"> <!-- Adjust width as needed -->


                                <form action="{{ route('member.updatePassword.submit') }}" method="POST">
                                    @csrf

                                    <!-- Container with background color -->
                                    <div class="p-3" style=" background-color:#87cefa; border-radius: 8px; margin-top: -38px;">

                                        <!-- Current Password Field with Eye Icon -->
                                        <div class="form-group mb-2 position-relative">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                                            <span toggle="#current_password" class="toggle-password fa fa-eye" style="position: absolute; right: 10px; top: 48px; cursor: pointer;"></span>
                                            @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- New Password Field with Eye Icon -->
                                        <div class="form-group mb-2 position-relative">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                                            <span toggle="#new_password" class="toggle-password fa fa-eye" style="position: absolute; right: 10px; top: 48px; cursor: pointer;"></span>
                                            @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Confirm New Password Field with Eye Icon -->
                                        <div class="form-group mb-3 position-relative">
                                            <label for="new_password_confirmation">Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                                            <span toggle="#new_password_confirmation" class="toggle-password fa fa-eye" style="position: absolute; right: 10px; top: 48px; cursor: pointer;"></span>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn custom-btn">Update Password</button>
                                        </div>

                                    </div>
                                </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Password Toggle -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            var input = document.querySelector(this.getAttribute('toggle'));
            if (input.type === 'password') {
                input.type = 'text'; // Change password input type to text
                this.classList.replace('fa-eye', 'fa-eye-slash'); // Change icon to 'eye-slash'
            } else {
                input.type = 'password'; // Change back to password
                this.classList.replace('fa-eye-slash', 'fa-eye'); // Change icon to 'eye'
            }
        });
    });
</script>

@endsection
