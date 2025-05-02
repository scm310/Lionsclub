@extends('layouts.navbar')

@section('content')

<style>
    .shadow {
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
}
</style>
<div class="container mt-4 mb-5">  {{-- Added bottom spacing --}}
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('member.gallery') }}">Gallery</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->event ? $event->event->event_name : 'Unknown Event' }}</li>
        </ol>
    </nav>
<!-- Event Title, Date & Day in Same Row with Blue Background, Rounded Edges, and Centered Strip -->
<div class="d-flex justify-content-center align-items-center gap-3 flex-wrap text-center shadow" 
     style="
background: linear-gradient(115deg, #1a1683, #77dcf5); padding: 10px 20px; border-radius: 20px; max-width:700px; width: 100%; margin: 0 auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h5 class="fw-bold mb-0 text-white">
        {{ $event->event ? $event->event->event_name : 'Unknown Event' }} 
        - {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }} 
        - {{ \Carbon\Carbon::parse($event->event_date)->format('l') }}
    </h5>
</div>



<!-- Image Gallery -->
<div class="row g-3 mt-3 justify-content-center">  {{-- Centering images --}}
    @foreach($event->images as $image)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6 d-flex justify-content-center"> {{-- Responsive grid with centering --}}
            <img src="{{ asset('storage/app/public/' . $image) }}" 
                 class="img-fluid rounded shadow-sm border border-secondary mx-auto d-block" 
                 style="width: 250px; height: 250px; object-fit: cover;">
        </div>
    @endforeach
</div>

</div>
@endsection
