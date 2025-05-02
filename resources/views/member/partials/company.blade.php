<form action="{{ route('companystore') }}" method="POST">
    @csrf
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input 
                type="text" 
                name="company_name" 
                id="company_name"
                class="form-control" 
                placeholder="Company Name" 
                value="{{ old('company_name', $company->company_name ?? '') }}" 
                required
            >
        </div>

        <div class="col-md-3">
            <label for="industry" class="form-label">Industry</label>
            <input 
                type="text" 
                name="industry" 
                id="industry"
                class="form-control" 
                placeholder="Industry" 
                value="{{ old('industry', $company->industry ?? '') }}"
            >
        </div>

        <div class="col-md-3">
            <label for="website" class="form-label">Website</label>
            <input 
                type="text" 
                name="website" 
                id="website"
                class="form-control" 
                placeholder="Website" 
                value="{{ old('website', $company->website ?? '') }}"
            >
        </div>

        <div class="col-md-3">
            <label for="designation" class="form-label">Designation</label>
            <input 
                type="text" 
                name="designation" 
                id="designation"
                class="form-control" 
                placeholder="Designation" 
                value="{{ old('designation', $company->designation ?? '') }}"
            >
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn text-white" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); border: none;">
            Submit
        </button>
    </div>
</form>
