@extends('MasterAdmin.layout') {{-- or whatever your layout is --}}
@section('content')


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<!-- DataTables base CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables responsive extension CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Outer content area (fills the grey-blue background) -->
<div class="content-area">
    <div class="white-container">
        <!-- Gradient header bar -->
        <h3 class="custom-heading">Post a Job</h3>
        <!-- YOUR EXISTING FORM (unchanged) -->

        <div class="container  p-4 rounded shadow-sm text-dark" style=" margin: 0 auto;background-color:#87cefa; ">
            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('
                    success ') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
            @endif

            @if($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
            @endif

            <form action="{{ route('career.enquiry') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Job Posted Date:</label>
                        <input type="date" name="job_posted" class="form-control"
                            value="{{ old('job_posted', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>No. Of Openings:</label>
                        <input type="tel" name="openings" class="form-control" required value="{{ old('openings') }}" maxlength="6" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>


                    <div class="col-md-3 mb-3">
                        <label>Job Title:</label>
                        <input type="text" name="job_title" class="form-control" required value="{{ old('job_title') }}"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="company_name">Company Name:</label>
                        <input type="text" name="company_name" class="form-control" required>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Company Logo:</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Experience:</label>
                        <input type="text" name="experience" class="form-control" value="{{ old('experience') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Salary:</label>
                        <input type="text" name="salary" class="form-control" value="{{ old('salary') }}" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>

                </div>
                <div class="mb-3">
                    <label>Job Description:</label>
                    <textarea name="job_description" class="form-control" rows="3" maxlength="250"
                        oninput="updateCharCount(this)" required>{{ old('job_description') }}</textarea>
                    <small id="charCount">0 / 250 characters</small>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Job Location:</label>
                        <input type="text" name="job_location" class="form-control"
                            value="{{ old('job_location') }}"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')" required>
                    </div>



                    <div class="col-md-4 mb-3">
                        <label>Employment Type:</label>

                        <div>
                            <input type="radio" name="employment_type" value="permanent"> Permanent
                            <input type="radio" name="employment_type" value="contract"> Contract
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Education:</label>
                        <input type="text" name="education" class="form-control" value="{{ old('education') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Key Skills:</label>
                        <textarea
                            type="text"
                            name="key_skills"
                            class="form-control"
                            rows="2"
                            maxlength="250"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, ''); updateKeySkillsCharCount(this);"
                            id="keySkillsTextarea" required>{{ old('key_skills') }}</textarea>
                        <small class="text-muted" id="keySkillsCharCount">0 / 250 characters</small>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label>About the Company:</label>
                        <textarea
                            name="about_company"
                            class="form-control"
                            rows="2"
                            maxlength="250"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '');updateAboutCompanyCharCount(this)"
                            id="aboutCompanyTextarea" required>{{ old('about_company') }}</textarea>
                        <small class="text-muted" id="aboutCompanyCharCount">0 / 250 characters</small>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Contact Person Name:</label>
                        <input type="text" name="contact_person" class="form-control" oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Contact Phone:</label>
                        <input type="text" name="contact_details" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>


                    <div class="col-md-4 mb-3">
                        <label>Contact Email:</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}" required>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn custom-btn">Submit</button>
                </div>
            </form>

        </div>

        <br>
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('
                success ') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif

        <div class="container bg-white p-4 rounded shadow-sm text-dark" style=" margin: 0 auto;">
            <h2 class="text-center text-light custom-heading">Posted Jobs</h2>
            <div class="table-responsive">
                <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
                    <thead style="background-color:#003366 !important;">
                        <tr>
                            <th>S.No</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Experience</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $enquiry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $enquiry->job_title }}</td>
                            <td>{{ $enquiry->company_name }}</td>
                            <td>{{ $enquiry->job_location }}</td>
                            <td>{{ $enquiry->experience }}</td>
                            <td class="salary-amount">₹{{ number_format($enquiry->salary, 0, '.', ',') }}</td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm" type="button"
                                        id="dropdownMenuButton{{ $enquiry->id }}"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $enquiry->id }}">
                                        <li>
                                            <button class="dropdown-item"
                                                data-bs-toggle="modal"
                                                data-bs-target="#jobModal"
                                                data-enquiry="{{ json_encode($enquiry) }}">
                                                <i class="bi bi-eye me-2"></i> View
                                            </button>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('career.edit', $enquiry->id) }}">
                                                <i class="bi bi-pencil-square me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('career.enquiry.delete', $enquiry->id) }}" method="POST" id="delete-form-{{ $enquiry->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $enquiry->id }})">
                                                    <i class="bi bi-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title custom-heading" id="jobModalLabel">Posted Jobs</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-4">
                            <h5 class="modal-title custom-heading" id="jobModalLabel">Job Details</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <h5>Job Posted On:</h5>
                                                <p id="jobPostedDate"></p>
                                            </div>
                                            <div class="col-md-4">

                                                <h5>Job Openings:</h5>
                                                <p id="openings"></p>
                                            </div>

                                            <div class="col-md-4">
                                            <h5>Salary:</h5>
                                            <p id="salary"></p>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h5>Job Title:</h5>
                                                <p id="jobTitle"></p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Job Location:</h5>
                                                <p id="jobLocation"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row mb-3">

                                                <div class="col-md-6">
                                                    <h5>Employment Type:</h5>
                                                    <p id="employmentType"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Experience Required:</h5>
                                                    <p id="experience"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <h5>Job Description:</h5>
                                        <p id="jobDescription"></p>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="card mb-4">
                            <h5 class="modal-title custom-heading" id="jobModalLabel">Company Details</h5>
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h5>Company Name:</h5>
                                        <p id="companyName"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <h5 class="me-3 mb-0">Job Image:</h5>
                                            <div id="jobImage">
                                                <img src="your-image.jpg" alt="Job Image" style="max-height: 50px; width: auto;">
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <h5>About the Company:</h5>
                                <p id="aboutCompany"></p>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <h5 class="modal-title custom-heading" id="jobModalLabel">Education Details</h5>
                            <div class="card-body">
                                <h5>Education:</h5>
                                <p id="education"></p>

                                <h5>Key Skills:</h5>
                                <p id="keySkills"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="card mb-4">
                            <h5 class="modal-title custom-heading" id="jobModalLabel">Contact Details</h5>
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h5>Contact Person:</h5>
                                        <p id="contactPerson"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Contact Details:</h5>
                                        <p id="contactDetails"></p>
                                    </div>
                                </div>
                                <h5>Contact Email:</h5>
                                <p id="contactEmail"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
    document.addEventListener('DOMContentLoaded', () => {
        const jobModal = document.getElementById('jobModal');
        jobModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const enquiry = JSON.parse(button.getAttribute('data-enquiry'));

            // Format salary with ₹ symbol and comma separation (Indian format)
            let formattedSalary = enquiry.salary;
            if (!isNaN(formattedSalary)) {
                formattedSalary = new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    maximumFractionDigits: 0
                }).format(formattedSalary);
            }

            // Populate modal content
            document.getElementById('jobTitle').textContent = enquiry.job_title;
            document.getElementById('openings').textContent = enquiry.openings;
            document.getElementById('companyName').textContent = enquiry.company_name;
            document.getElementById('experience').textContent = enquiry.experience;
            document.getElementById('salary').textContent = formattedSalary;
            document.getElementById('jobLocation').textContent = enquiry.job_location;
            document.getElementById('contactPerson').textContent = enquiry.contact_person;
            document.getElementById('education').textContent = enquiry.education;
            document.getElementById('employmentType').textContent = enquiry.employment_type;
            document.getElementById('keySkills').textContent = enquiry.key_skills;
            document.getElementById('contactEmail').textContent = enquiry.contact_email;
            document.getElementById('aboutCompany').textContent = enquiry.about_company;
            document.getElementById('jobDescription').textContent = enquiry.job_description;
            document.getElementById('contactDetails').textContent = enquiry.contact_details;
            document.getElementById('jobPostedDate').textContent = new Date(enquiry.job_posted).toLocaleDateString();

            const imageContainer = document.getElementById('jobImage');
            if (enquiry.image) {
                imageContainer.innerHTML = `<img src="/storage/app/public/career_images/${enquiry.image}" width="60">`;
            } else {
                imageContainer.innerHTML = 'No Image Available';
            }
        });
    });
</script>



        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'swal-confirm-btn',
                        cancelButton: 'swal-cancel-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit(); // Submit the form if confirmed
                    }
                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </div>
</div>

<style>
    p {
        color: black;
    }

    /* full-viewport grey-blue background */
    .content-area {
        min-height: 100vh;
        padding: 20px 0;
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
    }

    /* Gradient header */
    .header-bar {
        background: linear-gradient(to right, #1e3c72, #2a5298);
        padding: 15px;
        border-radius: 10px;
        margin: 0 auto 20px auto;
        max-width: 1000px;
        text-align: center;
        color: #fff;
        font-size: 1.5rem;
        font-weight: 500;
    }

    .page-item.active .page-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
    }

    #imageTable1 tbody tr:nth-child(odd) {
        background-color: #F0F8FF;
    }

    #imageTable1 tbody tr:nth-child(even) {
        background-color: #B9D9EB;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 60px;
        display: inline-block;
    }

    th {
        color: white !important;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
        content: "-";
    }


    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        margin-right: .5em;
        display: inline-block;
        color: rgba(0, 0, 0, 0.5);
        content: "+";
    }

    /* Center your form container by overriding inline margin */
    .container.bg-white.p-4.rounded.shadow-sm {
        margin: 0 auto !important;
    }

    /* Ensure inputs take full column width */
    .custom-width {
        width: 100%;
    }

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

    .custom-btn1 {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5%;

        transition: 0.3s;
    }

    .custom-btn1:hover {
        background: gray !important;
    }

    .modal .modal-header .btn-close {
        position: absolute;
        top: 1.6875rem;
        right: 1.8125rem;
    }

    .swal-confirm-btn {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        /* Ensure text is visible */
    }

    .swal-cancel-btn {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%) !important;
        color: white !important;
        /* Ensure text is visible */
    }

    .swal-cancel-btn:hover {
        background: gray !important;
        color: white !important;
        /* Ensure text is visible */
    }

    .card-body {
        flex: 1 1 auto;
        padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);
        color: var(--bs-card-color);
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }

    .table .dropdown-item {
        z-index: 10000 !important;
    }

    .table .dropdown-item:hover {
        background-color: #87cefa;
    }

    .table-responsive {
        overflow: visible !important;
        position: relative;
        z-index: 1;
    }

    /* Try on the immediate parent if needed */
    .parent-container {
        overflow: visible !important;
        position: relative;
        z-index: 1;
    }

    .btn:hover {
        color: white !important;
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-border-color);
    }
</style>
<script>
    $(document).ready(function() {
        $('#imageTable1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "pageLength": 10
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.salary-amount').forEach(function(el) {
            let salary = parseInt(el.textContent.replace(/[^0-9]/g, ''));
            if (!isNaN(salary)) {
                el.textContent = '₹' + new Intl.NumberFormat('en-IN').format(salary);
            }
        });
    });
</script>


<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateCharCount(textarea) {
        const count = textarea.value.length;
        document.getElementById('charCount').innerText = `${count} / 250 characters`;
    }

    // Optional: update count on page load if editing
    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.querySelector('textarea[name="job_description"]');
        updateCharCount(textarea);
    });
</script>

<script>
    // Function to update the character count for "About the Company"
    function updateAboutCompanyCharCount(textarea) {
        const count = textarea.value.length; // Get current character count
        document.getElementById('aboutCompanyCharCount').innerText = `${count} / 250 characters`; // Update the count
    }

    // Update the character count on page load in case of pre-filled data
    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.querySelector('textarea[name="about_company"]');
        updateAboutCompanyCharCount(textarea); // Initialize the character count if there is any pre-filled data
    });
</script>

<script>
    // Function to update character count for Key Skills
    function updateKeySkillsCharCount(textarea) {
        const count = textarea.value.length;
        document.getElementById('keySkillsCharCount').innerText = `${count} / 250 characters`;
    }

    // Update on page load if old value exists
    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.getElementById('keySkillsTextarea');
        if (textarea) {
            updateKeySkillsCharCount(textarea);
        }
    });
</script>

<script>
    // Assuming enquiry.salary contains a number like 2000000
    let salaryAmount = enquiry.salary;

    // Format salary with ₹ and Indian comma style
    let formattedSalary = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0
    }).format(salaryAmount);

    // Display formatted salary
    document.getElementById('salary').textContent = formattedSalary;
</script>

@endsection