@extends('layouts.navbar')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    /* Card container */
    .job-card {
        border: 1px solid #e1e4e8;
        border-radius: 12px;
        padding: 20px;
        transition: 0.3s;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        color: white !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        cursor: pointer;
        width: 850px;
        align-items: center;
        justify-content: center;
    }

    /* Card hover effect */
    .job-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);

    }

    /* Header section - job title and meta data */
    .job-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .job-title {
        font-size:23px;
        font-weight: bold;
        color: rgb(255, 255, 255);
    }

    .badge {
        background-color: #0073e6;
        color: #fff;
        padding: 6px 16px;
        font-size: 13px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Job meta section (Experience, Salary, Location) */
    .job-meta {
        display: flex;
        gap: 15px;
        font-size: 1rem;
        color: white;
    }

    .job-meta i {
        color: rgb(255, 255, 255);
    }

    /* Details section for each job - initially hidden */
    .job-details {
        display: none;
        margin-top: 15px;
        color: #fff;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Layout of the details */
    .job-details span {
        display: block;
        margin-bottom: 10px;
    }

    /* Apply button */
    .apply-btn {
        background: linear-gradient(135deg, #0073e6, #005bb5);
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s ease;
        margin-top: 20px;
    }

    .apply-btn:hover {
        background: #004a99;
    }

    /* Icons for details */
    .job-details i {
        color: rgb(233, 244, 255);
        margin-right: 8px;
    }

    /* Grid layout for job details */
    .job-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    /* Styling for job detail sections */
    .job-details-grid div {
        margin-bottom: 10px;
    }

    /* Show expand button when expanded */
    .expand-btn {
        text-align: center;
        cursor: pointer;
        color: rgb(255, 255, 255);
        font-weight: bold;
        padding-top: 10px;
    }

    .currency {
        color: white;
    }

     .card1 {
        max-width: 95%;
        margin-left: 30px;
    } 


    @media (max-width: 768px) {
    .job-header {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .job-details .row > div {
        width: 100%;
    }

    .img-thumbnail {
        width:80px !important;
        height:80px !important;
        margin-top: 10px;
    }

    .d-flex.align-items-end.text-end.ms-auto {
        align-items: flex-start !important;
        text-align: left !important;
        margin-left: 0 !important;
        margin-top: 15px;
    }

    .job-meta {
        gap: 10px;
    }

    .job-card {
        width: 100%;
    }

    .job-title {
        font-size: 18px;
    }

    .card1 {
        max-width:100%;
      margin-left:0px;  
    } 

}

</style>

<!-- Card Wrapper -->
<div class="card shadow rounded-4  card1" style="background-color:#fcdab8; border: none; margin-top:12px;">

    <!-- Your Container Inside Card -->
    <div class="container mt-4">
    <div class="row">
        @if(isset($enquiries) && $enquiries->count() > 0)
            @foreach($enquiries as $enquiry)
                {{-- DO NOT MODIFY ANY OF THIS EXISTING BLOCK --}}
                <div class="col-md-12 mb-4 d-flex justify-content-center">
                    <div class="job-card shadow-sm p-3" onclick="toggleCard(this)">
                        <div class="job-header d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <div class="job-title fw-bold">{{ $enquiry->job_title }}</div>
                                &nbsp;
                                <div><span><i class="fas fa-building"></i>&nbsp;<strong>Company Name :</strong>&nbsp;{{ $enquiry->company_name }}</span></div>
                                &nbsp;
                                <div class="job-meta d-flex flex-wrap gap-3">
                                    <span><i class="fas fa-user-clock"></i>&nbsp;<strong>Experience:</strong>&nbsp;{{ $enquiry->experience }}</span>
                                    <span class="salary">
                                        <strong>Salary:</strong>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                            class="bi bi-currency-rupee currency" viewBox="0 0 16 16">
                                            <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                        </svg>
                                        <span class="salary-amount">{{ $enquiry->salary }}</span>
                                    </span>
                                </div>
                                <div class="job-meta d-flex flex-wrap gap-3 mt-2">
                                    <span><i class="fas fa-map-marker-alt"></i>&nbsp;<strong> Job Location:</strong>&nbsp;{{ $enquiry->job_location }}</span>
                                    <span><i class="fas fa-users"></i>&nbsp;<strong> Job openings:</strong>&nbsp;{{ $enquiry->openings }}</span>
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-end text-end ms-auto">
                                <span class="badge bg-primary mb-2">{{ $enquiry->employment_type }}</span>
                                @if($enquiry->image)
                                    <img src="{{ asset('storage/app/public/career_images/' . $enquiry->image) }}" alt="Career Image" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="text-muted" style="width: 80px; height: 80px;">No Image</div>
                                @endif
                                <span class="mt-2"><i class="fas fa-calendar-alt"></i><strong> Job Posted:</strong> {{ date('d-m-Y', strtotime($enquiry->job_posted)) }}</span>
                            </div>
                        </div>

                        <div class="job-details mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <p><i class="fas fa-building"></i><strong> About Company:</strong> {{ $enquiry->about_company }}</p>
                                    <p><i class="fas fa-tools"></i><strong> Key Skills:</strong> {{ $enquiry->key_skills }}</p>
                                    <p><i class="fas fa-graduation-cap"></i><strong> Education:</strong> {{ $enquiry->education }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p><i class="fas fa-briefcase"></i><strong> Job Description:</strong> {{ $enquiry->job_description }}</p>
                                    <p><i class="fas fa-user"></i><strong> Contact Person:</strong> {{ $enquiry->contact_person }}</p>
                                    <p><i class="fas fa-phone"></i><strong> Contact Details:</strong> {{ $enquiry->contact_details }}</p>
                                    <p><i class="fas fa-envelope"></i><strong> Contact Email:</strong> {{ $enquiry->contact_email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END OF YOUR EXISTING BLOCK --}}
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <strong>No data found.</strong>
                </div>
            </div>
        @endif
    </div>
</div>



</div>


<script>
    // Function to toggle the job card visibility
    function toggleCard(card) {
        var details = card.querySelector('.job-details');
        details.style.display = details.style.display === 'block' ? 'none' : 'block';
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.salary-amount').forEach(function(el) {
            let salary = parseInt(el.textContent.replace(/[^0-9]/g, ''));
            if (!isNaN(salary)) {
                el.textContent = new Intl.NumberFormat('en-IN').format(salary);
            }
        });
    });
</script>


@endsection