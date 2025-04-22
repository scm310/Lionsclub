<style>
      .tabs {
    display: flex;
    justify-content: center;
    gap: 1px; /* space between buttons */
    margin-top: 1rem;
    width:258px;
}

.tab-btn {
    padding: 7px 12px; /* smaller vertical padding for reduced height */
    border: none;
    border-radius: 4px;
    color: white;


    background:#1e90ff ;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    font-size: 13px;
}


.tab-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.tab-btn.active {
    box-shadow: 0 0 10px #77dcf5;
}


/* Mobile responsiveness */
@media (max-width: 767.98px) {
    #memberDetailsContainer {
        width: 87%; /* Not full width */
        padding: 1rem;
        top: 217px;
        bottom: 10px;
        height: auto;
        border-radius: 8px 0 0 8px;
        margin-right: 25px;
    }
}

.close-btn {
    color: white;        /* White text/icon */
    background: none;    /* Optional: makes background transparent */
    border: none;        /* Optional: removes border */
    font-size: 20px;     /* Optional: makes the icon a bit bigger */
    cursor: pointer;     /* Shows pointer on hover */
}
    .close-btn:hover {
        color: white !important;
        opacity: 0.8;
    }

</style>




<div id="memberDetailsContainer" class="member-details-container" style="display: none; background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white;">
    <div class="member-details-content">
        <button class="close-btn" onclick="closeMemberDetails()" style="color: #ffffff !important; background: transparent !important; border: none; font-size: 20px;">&#10006;</button>





        <!-- Tabs -->
<div class="tabs text-center mt-3">
<button class="tab-btn" onclick="showTab('personal')">Personal</button>
    <button class="tab-btn active" onclick="showTab('account')">Account</button>

    <button class="tab-btn" onclick="showTab('contact')">Contact</button>
    <button class="tab-btn" onclick="showTab('membership')">Membership</button>
</div>





        <!-- Tab Content -->
        <div id="tabContent">
<!-- Parent & Account -->
<div id="account" class="tab-pane active">
    <div class="card" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2);">
        <div class="card-body" style="color: white;">
            <p><strong>Multiple District:</strong> <span id="multipleDistrict"></span></p>
            <p><strong>District:</strong> <span id="district"></span></p>
            <p><strong>Account Name:</strong> <span id="accountName"></span></p>
        </div>
    </div>
</div>


<!-- Personal -->
<div id="personal" class="tab-pane">
    <div class="card p-3"
         style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); color: white;">

        <!-- Flex Container: Text + Image Side by Side -->
        <div class="d-flex align-items-start gap-3 mb-3">
            <!-- Left: All Text Content -->
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

            <!-- Right: Profile Image -->
            <div class="flex-shrink-0">
                <img id="profilePic" src="" alt="Profile Picture"
                     style="width: 100px; height: 100px; object-fit: fill; border-radius: 10px; border: 3px solid white;">
            </div>
        </div>
    </div>
</div>





<!-- Contact -->
<div id="contact" class="tab-pane">
    <div class="card p-3"
         style="background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: white;">

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

<!-- Membership -->
<div id="membership" class="tab-pane">
    <div class="card p-3"
         style="background: rgba(214, 174, 174, 0.1);
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: white;">

        <p><strong>Membership Type:</strong> <span id="membershipType"></span></p>
        <p><strong>Membership Full Type:</strong> <span id="membershipFullType"></span></p>


    </div>
</div>

        </div>
    </div>
</div>
