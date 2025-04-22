@extends('layouts.navbar')

@section('content')



<section  lass="lazy-bg" style="background-image:url(assets/images/sample1.png); background-repeat:no-repeat; background-size:cover; object-fit:fill; ">
    <div class="d-flex align-items-center justify-content-center">

    <div class="container d-flex flex-column " >
        <!-- Top Buttons -->
        <div class="top-buttons button text-center text-md-end">
            <a href="{{ route('membership.form') }}" class="button1 m-2">Join a club</a>
            <a href="{{ route('donation.form') }}" class="button1 m-2">Donation Enquiry</a>
        </div>

        <!-- Form Container -->
        <div class="row justify-content-center flex-grow-1">
            <div class="col-md-6 col-12">
                <div class="card p-4 custom-card mb-5">
                    <h4 class="text-center text-white">Membership Enquiry Form</h4>

                    <form action="{{ route('membership.enquiry') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label class="text-white">First Name:</label>
                               <input type="text" name="first_name" class="form-control bg-light text-dark" required
       oninput="lettersOnly(this)">
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label class="text-white">Last Name:</label>
                            <input type="text" name="last_name" class="form-control bg-light text-dark" required
       oninput="lettersOnly(this)">
                            </div>
                        </div>

                        <!-- Preferred Contact Mode & Time -->
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <label class="text-white">Preferred Contact Mode:</label>
                                <div class="d-flex flex-wrap">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="preferred_contact" id="contact_email" value="email" required>
                                        <label class="form-check-label text-white" for="contact_email">Email</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_contact" id="contact_phone" value="phone" required>
                                        <label class="form-check-label text-white" for="contact_phone">Phone</label>
                                    </div>
                                </div>
                                <div id="email_field" class="mb-3">
                                    <label class="text-white">Email:</label>
                                    <input type="email" name="email" class="form-control bg-light text-dark w-100">
                                </div>
                                <div id="phone_field" class="mb-3">
                                    <label class="text-white">Phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control bg-light text-dark" pattern="\d{10}" maxlength="10" required oninput="this.value = this.value.replace(/\D/g, '')">
                                        <small class="text-warning d-none" id="PhoneError">Phone number must be exactly 10 digits.</small>
                                     </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="text-white">Preferred Time to Contact:</label>
                                <div class="input-group">
                                    <select name="preferred_time" class="form-select bg-light text-dark" required>
                                        <option value="daytime">Daytime</option>
                                        <option value="evening">Evening</option>
                                        <option value="either">Either</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- Email & Phone Fields -->


                             <div class="col-md-6 col-12 mb-3">
                                <label class="text-white">Message:</label>
                                <textarea name="comment" id="message"
                                          class="form-control bg-light text-dark"
                                          rows="3" maxlength="250"
                                          oninput="updateCounter()"></textarea>
                                <small id="charCount" class="text-white">0 / 250</small>
                            </div>



                        <div class="text-center">
                            <button type="submit" class=" button1 border border-warning w-80">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <style>
        .swal2-confirm.custom-ok {
            background:linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(46, 103, 178) 158.5%) !important;
            color: white !important;
            border: 2px solid #e6b800  !important;
            box-shadow: none !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Thanks for your interest to become a member of Lions International District 3241 E!',
                text: 'One of our office bearers will contact you for further proceedings.',
                confirmButtonText: 'OK',
                width: '449px',
                customClass: {
                    confirmButton: 'custom-ok'
                }
            });
        });
    </script>
@endif


</section>


<style>

textarea.form-control {
    resize: vertical;
    font-size: 16px;
    border-radius: 8px;
    width:500px;
}


    #phone_field,#email_field{
        width:242px;
    }
/* Responsive Card */
.custom-card {
    background: rgba(8, 8, 8, 0.527);
    background-size: cover;
    border: 2px solid #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    margin-top: 30px;
    width: 100%;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    padding: 15px;
}

.button {
margin-top:20px;
 margin-right:43px;
gap: 3px; /* Space between buttons */

}

.button1 {
    background:linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(46, 103, 178) 158.5%);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    border:2px solid #e6b800 !important;
    text-decoration: none;
    margin-top:30px;

}


/* Mobile Responsive */
@media (max-width: 768px) {
    /* Center Align Buttons */
    .button {
        display: flex;
        align-items: center;
        margin-left: 15px;
        width: 333px;

    }

    .button .btn {
        width: 90%;
        max-width: 300px;
        text-align: center;
        margin: 5px 0;
        font-size:12px/* Reset margin for mobile */
    }

    /* Responsive Card */
    .custom-card {
        width: 95%;
        max-width: 100%;
        margin: 20px auto;
        padding: 20px;
    }


    textarea.form-control {
    resize: vertical;
    font-size: 16px;
    border-radius: 8px;
    width: -webkit-fill-available;;
}



}


</style>



<script>
    function lettersOnly(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }
    </script>

<script>
    function updateCounter() {
        var message = document.getElementById('message');
        var counter = document.getElementById('charCount');
        counter.textContent = message.value.length + ' / 250';
    }
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.getElementById("phone");
        const phoneError = document.getElementById("phoneError");

        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, ''); // Allow only numbers
            if (this.value.length !== 10) {
                phoneError.classList.remove("d-none");
            } else {
                phoneError.classList.add("d-none");
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const emailRadio = document.getElementById("contact_email");
        const phoneRadio = document.getElementById("contact_phone");
        const emailField = document.getElementById("email_field");
        const phoneField = document.getElementById("phone_field");
        const emailInput = emailField.querySelector("input");
        const phoneInput = phoneField.querySelector("input");
        const form = document.querySelector("form");

        // Hide fields initially
        emailField.style.display = "none";
        phoneField.style.display = "none";
        emailInput.removeAttribute("required");
        phoneInput.removeAttribute("required");

        // Event listeners for radio buttons
        emailRadio.addEventListener("change", function () {
            emailField.style.display = "block";
            phoneField.style.display = "none";
            emailInput.setAttribute("required", "required");
            phoneInput.removeAttribute("required");
        });

        phoneRadio.addEventListener("change", function () {
            phoneField.style.display = "block";
            emailField.style.display = "none";
            phoneInput.setAttribute("required", "required");
            emailInput.removeAttribute("required");
        });

        // Optional: Extra validation before submit (if needed)
        form.addEventListener("submit", function (e) {
            if (emailRadio.checked && !emailInput.value.trim()) {
                e.preventDefault();
                alert("Please enter your email.");
            }
            if (phoneRadio.checked && !phoneInput.value.trim()) {
                e.preventDefault();
                alert("Please enter your phone number.");
            }
        });
    });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll('.lazy-bg');

    const loadLazyBackground = (entry, observer) => {
      if (entry.isIntersecting) {
        entry.target.style.backgroundImage = `url(${entry.target.dataset.bg})`;
        observer.unobserve(entry.target);
      }
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => loadLazyBackground(entry, observer));
    }, { threshold: 0.1 });

    sections.forEach(section => {
      observer.observe(section);
    });
  });
</script>
@endsection
