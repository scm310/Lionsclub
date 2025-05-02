@extends('MasterAdmin.layout') {{-- or whatever your layout is --}}

@section('content')


<style>
    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
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

    .custom-btn2 {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white;
        font-size: 15px;
        border-radius: 50%;

        transition: 0.3s;
    }

    .custom-btn1:hover {
        background: gray !important;

    }

    .btn:hover {
        color: white !important;
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-border-color);
    }

    .form-control{
        font-size: 13px;
    }
</style>
<div class="white-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ url()->previous() }}" class="btn custom-btn2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg></a>


    </div>

    <div class="container p-4 rounded shadow-sm text-dark" style="max-width: 900px; margin: 0 auto; background-color:#87cefa;">
        <h3 class="custom-heading">Edit Job Posting</h3>

        @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif


        <form action="{{ route('career.update', $career->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Job Posted Date:</label>
                    <input type="date" name="job_posted" class="form-control" value="{{ old('job_posted', $career->job_posted ? \Carbon\Carbon::parse($career->job_posted)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label>No. Of Openings:</label>
                    <input type="tel" name="openings" class="form-control" value="{{ old('openings', $career->openings) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Job Title:</label>
                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $career->job_title) }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Company Name:</label>
                    <input type="text" name="company_name" class="form-control" required value="{{ old('company_name', $career->company_name) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Company Logo:</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($career->image)
                    <img src="{{ asset('storage/app/public/career_images/' . $career->image) }}" alt="Company Logo" style="max-width: 100px; margin-top: 10px;">
                    @endif
                </div>

                <div class="col-md-4 mb-3">
                    <label>Experience:</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $career->experience) }}">
                </div>



                <div class="col-md-3 mb-3">
                    <label>Salary:</label>
                    <input type="text" name="salary" id="salaryInput" class="form-control" value="{{ old('salary', $career->salary) }}">
                    <p><strong>Formatted:</strong> <span class="salary-output"></span></p>
                </div>
                
            </div>

            <div class="mb-3">
                <label>Job Description:</label>
                <textarea name="job_description" class="form-control" rows="3" maxlength="250"
                    oninput="updateCharCount(this)">{{ old('job_description', $career->job_description) }}</textarea>
                <small id="charCount">0 / 250 characters</small>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Job Location:</label>
                    <input type="text" name="job_location" class="form-control" value="{{ old('job_location', $career->job_location) }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Employment Type:</label>
                    <div>
                        <label>
                            <input type="radio" name="employment_type" value="Permanent"
                                {{ (isset($career) && $career->employment_type === 'Permanent') ? 'checked' : '' }}>
                            Permanent
                        </label>
                        <label class="ms-3">
                            <input type="radio" name="employment_type" value="Contract"
                                {{ (isset($career) && $career->employment_type === 'Contract') ? 'checked' : '' }}>
                            Contract
                        </label>
                    </div>
                </div>



                <div class="col-md-4 mb-3">
                    <label>Education:</label>
                    <input type="text" name="education" class="form-control" value="{{ old('education', $career->education) }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Key Skills:</label>
                    <textarea name="key_skills" class="form-control" rows="2" maxlength="250"
                        oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, ''); updateKeySkillsCharCount(this);"
                        id="keySkillsTextarea">{{ old('key_skills', $career->key_skills) }}</textarea>
                    <small class="text-muted" id="keySkillsCharCount">0 / 250 characters</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label>About the Company:</label>
                    <textarea name="about_company" class="form-control" rows="2" maxlength="250"
                        oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '');updateAboutCompanyCharCount(this)"
                        id="aboutCompanyTextarea">{{ old('about_company', $career->about_company) }}</textarea>
                    <small class="text-muted" id="aboutCompanyCharCount">0 / 250 characters</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Contact Person Name:</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $career->contact_person) }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s,.-]/g, '')">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Contact Phone:</label>
                    <input type="text" name="contact_details" class="form-control" value="{{ old('contact_details', $career->contact_details) }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Contact Email:</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $career->contact_email) }}">
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn custom-btn">Submit</button>
                <a href="javascript:history.back()" class="btn custom-btn1 ms-2">Close</a>
            </div>

        </form>
    </div>
</div>




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
    document.addEventListener("DOMContentLoaded", function() {
        const salaryInput = document.getElementById("salaryInput");
        const output = document.querySelector(".salary-output");

        function formatSalaryRange(input) {
            input = input.replace(/\s/g, ''); // Remove all spaces

            // Check for a valid salary range like "2000000-3000000"
            const match = input.match(/^(\d+)\-(\d+)$/);
            if (match) {
                let [_, minStr, maxStr] = match;
                let min = parseInt(minStr);
                let max = parseInt(maxStr);

                if (min >= 10000000) {
                    return `${min / 10000000} - ${max / 10000000} Crore PA`;
                } else if (min >= 100000) {
                    return `${min / 100000} - ${max / 100000} Lacs PA`;
                } else {
                    return `${min} - ${max} PA`;
                }
            } else if (/^\d+$/.test(input)) {
                let num = parseInt(input);
                if (num >= 10000000) {
                    return `${num / 10000000} Crore PA`;
                } else if (num >= 100000) {
                    return `${num / 100000} Lacs PA`;
                } else {
                    return `${num} PA`;
                }
            } else {
                return input; // For strings like "Negotiable"
            }
        }

        salaryInput.addEventListener("input", function() {
            const rawValue = salaryInput.value;
            output.textContent = formatSalaryRange(rawValue);
        });

        // Initial formatting on page load
        output.textContent = formatSalaryRange(salaryInput.value);
    });
</script>
@endsection