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
            margin-left: -22px;
        }

        .tab-btn {
            font-size: 11px;
            padding: 6px 10px;
        }
    }
</style>

<div id="memberDetailsContainer" class="member-details-container" style="display: none; background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white;">
    <div class="member-details-content">
        <button class="close-btn" onclick="closeMemberDetails()" style="color: white;">✖</button>

        <!-- Tabs -->
        <div class="tabs text-center mt-3">
            <button class="tab-btn active" onclick="showTab('personal')">Personal</button>
            <button class="tab-btn " onclick="showTab('account')">Account</button>
            <button class="tab-btn" onclick="showTab('contact')">Contact</button>
            <button class="tab-btn" onclick="showTab('membership')">Membership</button>
            <button class="tab-btn" onclick="showTab('service')">Service</button>
            <button class="tab-btn" onclick="showTab('project')">Project</button> <!-- New Tab -->
            <button class="tab-btn" onclick="showTab('client')">Client</button> <!-- New Tab -->
            <button class="tab-btn" onclick="showTab('testimonial')">Testimonial</button> <!-- New Tab -->
        </div>

        <!-- Tab Content -->
        <div id="tabContent">
            <!-- Account Tab -->
            <div id="account" class="tab-pane active">
                <div class="card" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2);"><br>
                    <h6 class="text-center text-white">Account Details</h6>
                    <div class="card-body" style="color: white;">
                        <p><strong>Multiple District:</strong> <span id="multipleDistrict"></span></p>
                        <p><strong>District:</strong> <span id="district"></span></p>
                        <p><strong>Account Name:</strong> <span id="accountName"></span></p>
                    </div>
                </div>
            </div>

            <!-- Personal Tab -->
            <div id="personal" class="tab-pane">

                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Personal Detail</h6>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="flex-grow-1">
                            <p id="memberRole" style="font-size: 13px; margin-bottom: 0;"></p>
                            <p><strong>Member ID:</strong> <span id="memberId"></span></p>
                            <p><strong>Salutation:</strong> <span id="salutation"></span></p>
                            <p><strong>First Name:</strong> <span id="firstName"></span></p>
                            <p><strong>Last Name:</strong> <span id="lastName"></span></p>
                            <p><strong>Suffix:</strong> <span id="suffix"></span></p>
                            <p><strong>Spouse Name:</strong> <span id="spouseName"></span></p>
                            <p><strong>Date of Birth:</strong> <span id="dob"></span></p>
                            <p><strong>Anniversary:</strong> <span id="anniversary"></span></p>
                        </div>
                        <div class="flex-shrink-0">
                            <img id="profilePic" src="" alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 3px solid white;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Tab -->
            <div id="contact" class="tab-pane">
                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Contact </h6>
                    <p><strong>Preferred Email:</strong> <span id="preferredEmail"></span></p>
                    <p><strong>Personal Email:</strong> <span id="email"></span></p>
                    <p><strong>Work Email:</strong> <span id="workEmail"></span></p>
                    <p><strong>Alternate Email:</strong> <span id="alternateEmail"></span></p>
                    <p><strong>Preferred Phone:</strong> <span id="preferredPhone"></span></p>
                    <p><strong>Mobile:</strong> <span id="phone"></span></p>
                    <p><strong>Work Number:</strong> <span id="workNumber"></span></p>
                    <p><strong>Home Number:</strong> <span id="homeNumber"></span></p>
                </div>
            </div>

            <!-- Membership Tab -->
            <div id="membership" class="tab-pane">
                <div class="card p-3" style="background: rgba(214, 174, 174, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Membership </h6>
                    <p><strong>Membership Type:</strong> <span id="membershipType"></span></p>
                    <p><strong>Membership Full Type:</strong> <span id="membershipFullType"></span></p>
                </div>
            </div>


            {{-- service --}}

            <div id="service" class="tab-pane">
                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Services</h6>
                    <div id="servicesContainer"></div>
                </div>
            </div>


            <!-- Project Tab -->
            <div id="project" class="tab-pane">

                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Projects </h6>
                    <div id="projectsContainer">

                    </div>

                </div>
            </div>

            <!-- Client Tab -->
            <div id="client" class="tab-pane">
                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); ">
                    <h6 class="text-center text-white">Clients </h6>
                    <div class="table-responsive">
                        <table class="table  table-hover text-white">
                            <thead class="table-light text-dark" style="background: #1e90ff">
                                <tr>
                                    <th>Client Name</th>
                                    <th>Company Name</th>
                                    <th>Company Full Form</th>
                                    <th>Designation</th>
                                </tr>
                            </thead>
                            <tbody id="clientsTableBody">
                                <!-- Dynamic rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            <!-- Testimonial Tab -->
            <div id="testimonial" class="tab-pane">
                <div class="card p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">
                    <h6 class="text-center text-white">Testimonials </h6>
                    <div id="testimonialsContainer">

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
