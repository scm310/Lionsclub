@extends('MasterAdmin.layout')
<style>
    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 25%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }

    #save {
        border-radius: 24px;
        width: 70px;
    }

    .card {
        margin-left: 120px; /* Adjust margin as needed */
    }

    /* Mobile responsiveness */
    @media (max-width: 767px) {
        .container {
            width: 100%;
            padding: 0 15px;
        }

        .card {
            margin-left: 0;
            width: 100%;
        }

        .col-md-9 {
            width: 100%;
            margin-bottom: 15px;
        }

        .custom-btn {
            width: 100%;
            font-size: 14px;
        }

        h5 {
            font-size: 18px;
        }

        .form-group {
            width: 100%;
        }

        #accountNamesContainer,
        #membershipTypesContainer,
        #districtNamesContainer {
            width: 100%;
        }

        #addAccountNameBtn,
        #addMembershipTypeBtn,
        #addDistrictNameBtn {
            width: 100%;
            text-align: center;
            display: block;
        }

        .alert {
            width: 100%;
            position: static;
            margin-top: 20px;
        }
    }

    
</style>

@section('content')
<h5 class="mb-4 text-center mt-4">Settings</h5>

<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="justify-content-center">
            @if(session('success'))
                <div class="alert alert-success text-center position-fixed top-0 start-50 translate-middle-x" id="successMessage">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center position-fixed top-0 start-50 translate-middle-x" id="errorMessage">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="row justify-content-center">
            <div class="row">
                <!-- Card to add Parent Multiple District -->
                <div class="col-md-9 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Parent Multiple District Name</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">District Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter District Name" required>
                                </div>
                                <button type="submit" class="btn custom-btn mt-3" id="save" style="color: white;">Save</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Card to add Account Names -->
                <div class="col-md-9 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Account Names</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.storeAccountNames') }}" method="POST">
                                @csrf
                                <div id="accountNamesContainer">
                                    <div class="form-group">
                                        <label for="name"> Account Names</label>
                                        <input type="text" class="form-control mb-2" name="account_names[]" placeholder="Enter Account Name" required>
                                    </div>
                                </div>
                                <button type="button" class="btn custom-btn mt-3" id="addAccountNameBtn" style=" border-radius: 24px; width:100px; color: white; ">Add More</button>
                                <button type="submit" class="btn custom-btn mt-3" id="save" style="color: white;">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Card to add Parent District with Parent -->
                <div class="col-md-9 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Parent District </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.storedistrict') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="parent_district_id">Select Parent District</label>
                                    <select class="form-control" id="parent_district_id" name="parent_district_id">
                                        <option value="">Select a Parent District</option>
                                        @foreach($ParentsMultipleDistrict as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="districtNamesContainer">
                                    <div class="form-group">
                                        <label for="name">District Name</label>
                                        <input type="text" class="form-control" name="name[]" placeholder="Enter District Name" required>&nbsp;
                                    </div>
                                </div>

                                <button type="button" class="btn custom-btn mt-3" id="addDistrictNameBtn" style=" border-radius: 24px; width:100px;  Color: white;">Add More</button>
                                <button type="submit" class="btn custom-btn mt-3" style="Color: white;" id="save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Card to add Membership Types -->
                <div class="col-md-9 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Add Membership Types</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.storeMembershipTypes') }}" method="POST">
                                @csrf
                                <div id="membershipTypesContainer">
                                    <div class="form-group">
                                        <label for="name"> Membership Types</label>
                                        <input type="text" class="form-control mb-2" name="membership_types[]" placeholder="Enter Membership Type" required>
                                    </div>
                                </div>
                                <button type="button" class="btn custom-btn mt-3" id="addMembershipTypeBtn" style=" border-radius: 24px; width:100px; Color: white; ">Add More</button>
                                <button type="submit" class="btn custom-btn mt-3" style="Color: white;" id="save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript placed inside section -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function addInputField(containerId, inputName, placeholderText) {
            var container = document.getElementById(containerId);
            var inputGroup = document.createElement('div');
            inputGroup.classList.add('form-group', 'd-flex', 'align-items-center', 'mb-2');

            var input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control', 'me-2');
            input.name = inputName + '[]';
            input.placeholder = placeholderText;
            input.required = true;

            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
            removeBtn.innerText = 'Remove';
            removeBtn.addEventListener('click', function () {
                container.removeChild(inputGroup);
            });

            inputGroup.appendChild(input);
            inputGroup.appendChild(removeBtn);
            container.appendChild(inputGroup);
        }

        document.getElementById('addAccountNameBtn').addEventListener('click', function () {
            addInputField('accountNamesContainer', 'account_names', 'Enter Account Name');
        });

        document.getElementById('addMembershipTypeBtn').addEventListener('click', function () {
            addInputField('membershipTypesContainer', 'membership_types', 'Enter Membership Type');
        });

        document.getElementById('addDistrictNameBtn').addEventListener('click', function () {
            addInputField('districtNamesContainer', 'name', 'Enter District Name');
        });
    });
</script>

<script>
   // Hide messages after 3 seconds
   setTimeout(function() {
       let successMessage = document.getElementById('successMessage');
       if (successMessage) {
           successMessage.style.transition = "opacity 0.5s ease";
           successMessage.style.opacity = 0;
           setTimeout(() => successMessage.remove(), 800);
       }

       let errorMessage = document.getElementById('errorMessage');
       if (errorMessage) {
           errorMessage.style.transition = "opacity 0.5s ease";
           errorMessage.style.opacity = 0;
           setTimeout(() => errorMessage.remove(), 800);
       }
   }, 3000);
</script>

@endsection
