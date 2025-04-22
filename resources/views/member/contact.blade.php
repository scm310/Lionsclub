@extends('layouts.navbar')

@section('content')

<div class="custom-bg d-flex align-items-center justify-content-center"
style="background: url('{{ asset('assets/images/sample.png') }}') no-repeat center top; background-size: cover; min-height:70vh;" loading="lazy">


    <div class="d-flex justify-content-end button">
        <a href="{{ route('membership.form') }}" class=" button1 m-2">Join a club</a>
        <a href="{{ route('donation.form') }}"  class=" button1 m-2">Donation Enquiry</a>
    </div>

    <div class="card p-4 text-center custom-card"
    style="background: rgba(255, 255, 255, 0.2); border-radius: 50px;  backdrop-filter: blur(10px);">
    <h4 class="text-white">Our Address</h4>
    <p class="text-white">
        T3, 4th Floor, Ruby Manor Apartments,<br>
        208A, Velachery Main Road, Selaiyur,<br>
        Chennai 600073.
    </p>
</div>
</div>

<style>
.button {
    gap: 3px; /* Space between buttons */
    margin-top: -345px;
    margin-left:22%;
    transform:translateX(370px);

}

.button1 {
    background:linear-gradient(181deg, rgb(2, 0, 97) 15%, rgb(46, 103, 178) 158.5%); 
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    border:2px solid #e6b800;
    text-decoration: none;

}



/* Responsive Design */
@media (max-width: 768px) {

    .button {
        gap: 3px;
        margin-top: -373px;
        margin-left: -93%;
        transform: translateX(335px);
    }


}
</style>

@endsection
