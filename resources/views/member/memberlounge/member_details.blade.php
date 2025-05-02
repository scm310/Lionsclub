<style>
    .tabs {
        display: flex;
        justify-content: start;
        gap: 2px;
        margin-top: 1rem;
        width: 100%;
        overflow-x: auto; /* Enable horizontal scrolling when buttons overflow */
        padding-bottom: 10px; /* Optional: some padding at the bottom for better look */
    }

    .tabs::-webkit-scrollbar {
    display: none; /* Hides the scrollbar */
}

    .tab-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        color: white;
        background: #1e90ff;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-size: 12px;
        white-space: nowrap; /* Prevent text from wrapping */
    }

    .tab-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .tab-btn.active {
        box-shadow: 0 0 10px #77dcf5;
    }
    #client th,td {
        font-size: 10px;
        justify-content: center;
        align-items: center;
        color:white;

    }

    /* Mobile responsiveness */
    @media (max-width: 767.98px) {
        .tabs {
            flex-direction: row;
            justify-content: start;
            gap: 10px;
            padding: 0 10px;
            width: 100%;
            margin-left: 16px;
        }

        .tab-btn {
            font-size: 11px;
            padding: 6px 10px;
        }
    }

    .scrollable-content {
        overflow-y: auto;
      
        padding-right: 5px;

        /* Hide scrollbar */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }

    .scrollable-content::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }

    .responsive-card {
        height: 400px;
    }

    @media (max-width: 767.98px) {
        .responsive-card {
            height: 700px;
        }
    }
</style>

<div id="memberDetailsContainer" class="member-details-container" style="display: none; background:#fffd8c; color: white;">
    <div class="member-details-content">
        <button class="close-btn" onclick="closeMemberDetails()" style="margin-top: -10px;">✖</button>

        <!-- Tabs -->
<!-- Tabs -->
<div class="tabs text-center mt-3" style="position: sticky; top: -12px; z-index: 1000; background: #fffd8c; padding: 10px 0;">
    <button class="tab-btn active" onclick="showTab('personal')" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none;">Personal</button>
    <button class="tab-btn" onclick="showTab('company')" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none;">Company </button>
    <button class="tab-btn" onclick="showTab('product')" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none;">Products</button>
    <button class="tab-btn" onclick="showTab('service')" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none;">Services</button>
    <button class="tab-btn" onclick="showTab('project')" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none;">Projects</button>

</div>




        <!-- Tab Content -->
        <div id="tabContent">
            <!-- Account Tab -->
            <div id="personal" class="tab-pane active" style="background: linear-gradient(115deg, rgb(15, 11, 140), rgb(119, 220, 245)); border-radius: 10px;">
    <div class="card p-3 responsive-card" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
        <h6 class="text-center text-white">Member  Details</h6>
        <div class="text-center mb-3">
            <img id="profilePic" src="" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 3px solid white;">
        </div>

        <!-- Scrollable content starts here -->
        <div class="scrollable-content" style="border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; padding: 10px;">
            <table class="table table-bordered text-white mb-0">
                <tbody>
                    <!-- Personal Details FIRST -->
                    <tr><th colspan="2" class="text-center">Personal Details</th></tr>
                    <tr><td>Member Role</td><td><span id="memberRole"></span></td></tr>
                    <tr><td>Member ID</td><td><span id="memberId"></span></td></tr>
                    <tr><td>Salutation</td><td><span id="salutation"></span></td></tr>
                    <tr><td>First Name</td><td><span id="firstName"></span></td></tr>
                    <tr><td>Last Name</td><td><span id="lastName"></span></td></tr>
                    <tr><td>Suffix</td><td><span id="suffix"></span></td></tr>
                    <tr><td>Spouse Name</td><td><span id="spouseName"></span></td></tr>
                    <tr><td>Date of Birth</td><td><span id="dob"></span></td></tr>
                    <tr><td>Anniversary</td><td><span id="anniversary"></span></td></tr>

               

                    <!-- Contact Details -->
                    <tr><th colspan="2" class="text-center">Contact Details</th></tr>
                    <tr><td>Preferred Email</td><td><span id="preferredEmail"></span></td></tr>
                    <tr><td>Personal Email</td><td><span id="email"></span></td></tr>
                    <tr><td>Work Email</td><td><span id="workEmail"></span></td></tr>
                    <tr><td>Alternate Email</td><td><span id="alternateEmail"></span></td></tr>
                    <tr><td>Preferred Phone</td><td><span id="preferredPhone"></span></td></tr>
                    <tr><td>Mobile</td><td><span id="phone"></span></td></tr>
                    <tr><td>Work Number</td><td><span id="workNumber"></span></td></tr>
                    <tr><td>Home Number</td><td><span id="homeNumber"></span></td></tr>

                </tbody>
            </table>
        </div>
    </div>
</div>




            {{-- service --}}

            <div id="service" class="tab-pane" style="background: linear-gradient(115deg, rgb(15, 11, 140), rgb(119, 220, 245));border-radius: 10px">
                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Services</h6>
                    <div id="servicesContainer"></div>
                </div>
            </div>


            <!-- Project Tab -->
            <div id="project" class="tab-pane" style="background: linear-gradient(115deg, rgb(15, 11, 140), rgb(119, 220, 245));    border-radius: 10px">

                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Projects </h6>
                    <div id="projectsContainer">

                    </div>

                </div>
            </div>

            <div id="product" class="tab-pane" style="background: linear-gradient(115deg, rgb(15, 11, 140), rgb(119, 220, 245));    border-radius: 10px">

<div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
    <h6 class="text-center text-white">Products </h6>
    <div id="productContainer">

    </div>

    

</div>
</div>

<div id="company" class="tab-pane" style="background: linear-gradient(115deg, rgb(15, 11, 140), rgb(119, 220, 245));    border-radius: 10px">

<div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
    <h6 class="text-center text-white">Company Details </h6>
    <div id="companyContainer">

    </div>

    

</div>
</div>

      

        </div>
    </div>
</div>

<script>
    // Sample JavaScript to handle tab switching
    function showTab(tabId) {
        // Hide all tabs
        let tabs = document.querySelectorAll('.tab-pane');
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });

        // Show the selected tab
        document.getElementById(tabId).classList.add('active');

        // Update the active tab button
        let buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
    }
</script>
