@extends('layouts.navbar')

@section ('content')
<style>
.banner {
    position: relative;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ccc;
}

/* ✨ This overlay dims the background image */
.banner::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* 👈 Change 0.5 to control opacity */
    z-index: 1;
}

/* ✨ This keeps your content above the overlay */
.banner > .d-flex {
    position: relative;
    z-index: 2;
}

</style>


<section class="banner lazy-banner" data-bg="assets/images/sample2.png">
<div class="overlay"></div> <!-- Add this line -->

<div class="d-flex align-items-center justify-content-center">

<div class="container d-flex flex-column " >

    <div class="top-buttons button">
        <a href="{{ route('membership.form') }}" class="button1 m-2">Join a club</a>
        <a href="{{ route('donation.form') }}" class="button1 m-2">Donation Enquiry</a>
    </div>

   

    <!-- Donation Form Section -->
    <div class="row justify-content-center flex-grow-1">
        <div class="col-md-6">
            <div class="card p-4 custom-card py-3">
                <h4 class="text-center text-white">Donation Enquiry Form</h4>



                <form action="{{ route('donation.submit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Name:</label>
                            <input type="text" name="name" class="form-control bg-light text-dark" required
                            oninput="lettersOnly(this)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control bg-light text-dark" pattern="\d{10}" maxlength="10" required oninput="this.value = this.value.replace(/\D/g, '')">
                                <small class="text-warning d-none" id="PhoneError">Phone number must be exactly 10 digits.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Email:</label>
                            <input type="email" name="email" class="form-control bg-light text-dark" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Location:</label>
                            <input type="text" name="location" class="form-control bg-light text-dark" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12 mb-3">
                            <label class="text-white">Message:</label>
                            <textarea name="message" id="message" 
                                      class="form-control bg-light text-dark" 
                                      rows="3" maxlength="250" 
                                      oninput="updateCounter()"></textarea>
                            <small id="charCount" class="text-white">0 / 250</small>
                        </div>
                        


                    </div>

                    <div class="text-center">
                        <button type="submit" class="button1 border border-warning">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
</section>

<!-- SweetAlert2 -->

<!-- Include SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Check for session success and trigger SweetAlert -->
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            icon: 'success',
            title: 'Thanks for your interest in donating to Lions International District 3241 E!',
            text: 'One of our office bearers will contact you for further proceedings.',
            confirmButtonText: 'OK',
            width: '449px',
            customClass: {
                confirmButton: 'custom-swal-btn'
            },
            didOpen: () => {
                const btn = document.querySelector('.swal2-confirm.custom-swal-btn');
                if (btn) {
                    btn.style.background = 'linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(46, 103, 178) 158.5%) ';
                    btn.style.color = 'white';
                    btn.style.padding = '10px 20px';
                    btn.style.borderRadius = '5px';
                    btn.style.border = '2px solid #e6b800';
                    btn.style.marginTop = '30px';
                    btn.style.textDecoration = 'none';
                    btn.style.boxShadow = 'none';
                    btn.style.transition = 'none';
                }
            }
        });
    });
</script>

@endif




<style>

textarea.form-control {
    resize: vertical;
    font-size: 16px;
    border-radius: 8px;
    width:400px;
}
    .custom-card {
    background: rgba(8, 8, 8, 0.527);
    background-size: cover;
    border: 2px solid #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    margin-top: 30px;
    width: 90%;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    padding: 15px;
}
</style>

<style>

.button {
margin-top:20px;
margin-left:705px;
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
    .button {
        display: flex
;
        transform: translateX(-5px);
        align-items: center;
        margin-left: auto;
        gap: 15px;
    }


    .button .btn {
        width: 90%;
        max-width: 300px;
        text-align: center;
        margin: 5px 0;
        font-size:12px;
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
    width:-webkit-fill-available;;
}
}

</style>



<script>
    function updateCounter() {
        var message = document.getElementById('message');
        var counter = document.getElementById('charCount');
        counter.textContent = message.value.length + ' / 250';
    }
    </script>
<script>
    function lettersOnly(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
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
document.addEventListener("DOMContentLoaded", () => {
    const lazyBanner = document.querySelector(".lazy-banner");
    if (!lazyBanner) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bg = lazyBanner.getAttribute("data-bg");
                lazyBanner.style.backgroundImage = `url('${bg}')`;
                observer.unobserve(lazyBanner);
            }
        });
    });

    observer.observe(lazyBanner);
});
</script>

@endsection
