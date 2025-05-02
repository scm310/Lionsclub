@extends('memberlayout.sidebar')

@section('content')
    <style>
        .member-details-container {
            position: fixed;
            top: 0;
            right: 0;
            width: 400px;
            height: 100%;
            background-color: white;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            overflow-y: auto;
            display: none;
            transition: all 0.3s ease;
            padding: 10px;
            margin-top: 100px;
            border-radius: 24px;
        }

        .member-details-content {
            padding: 10px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .tab-btn {
            margin: 0 -1px;
            padding: 5px 10px;
            cursor: pointer;
            background: #f0f0f0;
            border: none;
            border-radius: 3px;
            font-size: 13px;
        }

        .tab-btn.active {
            background: #0f0b8c;
            color: white;
        }

        .tab-pane {
            display: none;
            margin-top: 15px;
        }

        .tab-pane.active {
            display: block;
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }



        .member-card-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            transition: grid-template-columns 0.3s ease;
        }

        .member-card {
            max-width: 160px;
            width: 100%;
            margin: 0 auto;
        }


        /* When sidebar (memberDetailsContainer) is active */
        .member-card-grid.sidebar-active {
            grid-template-columns: repeat(4, minmax(160px, 0fr));
        }




        /* Card styling */
        .member-card {
            transition: all 0.3s ease;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .member-card-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                /* Always 2 per row on mobile */
                margin-left: -13px;
            }

            /* Even if sidebar is active, override to 2 columns */
            .member-card-grid.sidebar-active {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .member-details-container {
                width: 100%;
                border-radius: 0;
                margin-top: 0;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .member-card {
                width: 100% !important;
            }
        }



        /* Default */
        .search-box {
            width: 50%;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            transition: margin-left 0.3s ease;
        }


        .custom-input {
            border-radius: 5px;
            font-size: 12px;
            padding: 5px 30px 5px 10px;
            /* extra right padding for X icon */
            flex: 1;
            position: relative;
        }

        .custom-btn {
            background: #0f0b8c;
            color: white;
            border-radius: 5px;
            font-size: 12px;
            padding: 5px 10px;
            white-space: nowrap;
        }

        .custom-btn:hover {
            background: #0f0b8c;
            color: white;
        }


        /* ❌ Clear Button inside input */
        .clear-btn {
            position: absolute;
            right: 109px;
            /* Adjust depending on button size */
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #aaa;
            text-decoration: none;
            cursor: pointer;
            z-index: 10;
        }

        .clear-btn:hover {
            color: #000;
        }

        /* Base font size for all screen sizes */
        .custom-input::placeholder {
            font-size: 9px;
            /* or any size you prefer */
            color: #888;
            /* optional: change color too */
        }


        .main-content {
            transition: margin-left 0.3s ease;
            width: 100%;
            max-width: 1400px;
            margin: auto;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 0 10px;
            }
        }

        @media (min-width: 1400px) {
            .main-content {
                max-width: 1400px;
            }
        }

        /* Default positioning */
        .search-grid-wrapper {

            margin-left: 270px;
            transition: all 0.3s ease;
        }

        /* When sidebar is active, push search to right */
        .search-grid-wrapper.sidebar-active {
            margin-left: 55px;
            width: 70%;
        }

        @media (max-width: 768px) {
            .search-grid-wrapper.sidebar-active {
                margin-left: 0 !important;
                width: 528px;
            }
        }


        @media (max-width: 768px) {
            .search-grid-wrapper {
                width: 528px;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center !important;
            }

            .pagination .page-item {
                margin: 2px;
            }

            .pagination .page-link {
                padding: 6px 10px;
                font-size: 14px;
            }
        }

        .member-lounge-heading {
            color: white;
            font-size: 2rem;
            /* default desktop size */
            white-space: nowrap;
            /* keep text in one line */
        }

        @media (max-width: 768px) {
            .member-lounge-heading {
                font-size: 1.3rem;
                /* smaller size for mobile */
                text-align: center;
            }
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

        .card-title {
            margin-bottom: -0.25rem;
        }

        p {
            margin-top: -3px;
            margin-bottom: 0rem;
        }


    </style>

    <!-- Main Content Wrapper -->
    <div class="d-flex justify-content-center align-items-start mt-4 px-2" style="overflow-x: hidden; width: 100%;">
        <div class="main-content w-100 px-1 px-md-4" style="margin: 0 auto;">



            <div class="card shadow-lg p-4 bg-white rounded">

                <!-- Header -->
                <h3 class="mb-3 custom-heading">Member Lounge</h3>


                <!-- Search Bar -->
                <form action="{{ route('member.lounge') }}" method="GET" class="mb-4 ">
                    <div class="search-grid-wrapper">
                        <div class="input-group search-box position-relative">
                            <input type="text" name="search" class="form-control custom-input"
                                placeholder="Search by Name, Club or Phone" value="{{ request('search') }}">

                            @if (request('search'))
                                <a href="{{ route('member.lounge') }}" class="clear-btn" title="Clear Search">
                                    &times;
                                </a>
                            @endif

                            <button type="submit" class="btn" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border: none; padding: 4px 16px; border-radius: 5px;">Search</button>

                        </div>
                    </div>
                </form>


                <!-- Member Cards Grid -->
                <div id="memberCardGrid" class="member-card-grid">
                    @foreach ($members as $member)
                        <div class="member-card" style="width: 100%;">

                            <div class="card text-center shadow-sm border-0 d-flex flex-column justify-content-between "
                                onclick="showMemberDetails({!! htmlspecialchars(
                                    json_encode([
                                        'profile' => $member->profile_photo,
                                        'firstName' => ucwords(strtolower($member->first_name)),
                                        'lastName' => ucwords(strtolower($member->last_name)),

                                        'role' => $member->role ?? '',
                                        'memberId' => $member->member_id,
                                        'salutation' => $member->salutation ?? '',
                                        'suffix' => $member->suffix ?? '',
                                        'spouseName' => ucwords(strtolower($member->spouse_name ?? '')),
                                        'dob' => $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d M Y') : '',
                                        'anniversary' => $member->anniversary_date
                                            ? \Carbon\Carbon::parse($member->anniversary_date)->format('d M Y')
                                            : '',

                                        'email' => $member->email_address ?? '',
                                        'preferredEmail' => $member->preferred_email ?? '',
                                        'workEmail' => $member->work_email ?? '',
                                        'alternateEmail' => $member->alternate_email ?? '',
                                        'phone' => $member->phone_number ?? '',
                                        'preferredPhone' => $member->preferred_phone ?? '',
                                        'workNumber' => $member->work_number ?? '',
                                        'homeNumber' => $member->home_number ?? '',
                                        'multipleDistrict' => $member->parentMultipleDistrict->name ?? '',
                                        'district' => $member->parentDistrict->name ?? '',
                                        'accountName' => ucwords(strtolower($member->account->chapter_name ?? '')),
                                        'membershipType' => $member->membership_type ?? '',
                                        'membershipFullType' => $member->membershipType->name ?? '',
                                        'testimonials' => $member->testimonial ?? [],
                                        'clients' => $member->client ?? [],
                                        'projects' => $member->project ?? [],
                                        'services' => $member->service ?? [],
                                        'products' => $member->product ?? [],
                                        'companies' => $member->company ?? [],

                                    ]),
                                    ENT_QUOTES,
                                    'UTF-8',
                                ) !!})"
                                style="cursor:pointer; background-color: #ffffff; background-image: linear-gradient(506deg, #ffffff 0%, #1e90ff 74%); color: #fff; border-radius: 10px; height: 210px;">

                                <div class="card-body p-2">
                                    <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                        alt="Profile Picture" class="mb-2 shadow-sm"
                                        style="height: 120px; width: 120px; object-fit: fill; border-radius: 5px; border: 3px solid white;">

                                    @php
                                        $fullName = trim($member->first_name . ' ' . $member->last_name);
                                        $displayName =
                                            strlen($fullName) > 15 ? substr($fullName, 0, 15) . '...' : $fullName;
                                    @endphp

                                    <h6 class="card-title" style="font-size: 12px; padding:4px;"
                                        title="{{ Str::title($fullName) }}">
                                        {{ Str::title($displayName) }}
                                    </h6>


                                    <p class="" style="font-size: 11px;"><strong>ID:</strong> {{ $member->member_id }}
                                    </p>

                                    <p class="" style="font-size: 10px;"
                                        title="{{ $member->account->chapter_name ?? 'N/A' }}">
                                        <strong>
                                            {{ isset($member->account->chapter_name) ? Str::limit(Str::title($member->account->chapter_name), 15) : 'N/A' }}
                                        </strong>
                                    </p>
                                    <p class="" style="font-size: 10px;"><i class="fa fa-phone"></i>
                                        {{ $member->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $members->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Member Detail Side Container -->
    @include('member.memberlounge.member_details')


    <script>
        function showMemberDetails(member) {

            // Display container
            document.getElementById('memberDetailsContainer').style.display = 'block';


            // Shift content and grid layout
            document.querySelector('.main-content').classList.add('shift-left');
            document.getElementById('memberCardGrid').classList.add('sidebar-active');
            document.querySelector('.search-grid-wrapper').classList.add('sidebar-active');


            // Set image
            document.getElementById('profilePic').src = member.profile ? `/storage/app/public/${member.profile}` :
                '/assets/images/default.png';

            // Basic info
            document.getElementById('firstName').innerText = member.firstName + ' ' + member.lastName;
            document.getElementById('memberRole').innerText = member.role;


            // Personal tab
            document.getElementById('memberId').innerText = member.memberId || 'NA';
            document.getElementById('salutation').innerText = member.salutation || 'NA';
            document.getElementById('firstName').innerText = member.firstName || 'NA';
            document.getElementById('lastName').innerText = member.lastName || 'NA';
            document.getElementById('suffix').innerText = member.suffix || 'NA';
            document.getElementById('spouseName').innerText = member.spouseName || 'NA';
            document.getElementById('dob').innerText = member.dob || 'NA';
            document.getElementById('anniversary').innerText = member.anniversary || 'NA';

            // Contact tab
            document.getElementById('preferredEmail').innerText = member.preferredEmail || 'NA';
            document.getElementById('email').innerText = member.email || 'NA';
            document.getElementById('workEmail').innerText = member.workEmail || 'NA';
            document.getElementById('alternateEmail').innerText = member.alternateEmail || 'NA';
            document.getElementById('preferredPhone').innerText = member.preferredPhone || 'NA';
            document.getElementById('phone').innerText = member.phone || 'NA';
            document.getElementById('workNumber').innerText = member.workNumber || 'NA';
            document.getElementById('homeNumber').innerText = member.homeNumber || 'NA';








//project
const projectsContainer = document.getElementById('projectsContainer');

if (member.projects && member.projects.length > 0) {
    projectsContainer.innerHTML = '';

    member.projects.forEach((project) => {
        // Create row for each card
        const row = document.createElement('div');
        row.classList.add('row', 'mb-4');

        const col = document.createElement('div');
        col.classList.add('col-12');

        // Card
        const card = document.createElement('div');
        card.classList.add('card', 'shadow-sm', 'border-0','px-2');
        card.style.background = 'rgba(255, 255, 255, 0.1)';
        card.style.color = 'white';

        // Row inside card for image and content
        const cardInnerRow = document.createElement('div');
        cardInnerRow.classList.add('row', 'g-0', 'align-items-center');

        // Image column
        const imageCol = document.createElement('div');
        imageCol.classList.add('col-md-4');

        const projectImage = document.createElement('img');
        projectImage.src = project.project_image ? `/storage/app/public/${project.project_image}` :
            '/assets/images/default-project.png';
        projectImage.classList.add('img-fluid', 'rounded-start');
        projectImage.alt = project.project_name || 'Project Image';

        imageCol.appendChild(projectImage);

        // Content column
        const contentCol = document.createElement('div');
        contentCol.classList.add('col-md-8');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        const title = document.createElement('h6');
        title.classList.add('card-title','text-white','text-center','mb-1');
        title.innerText = project.project_name || 'Unnamed Project';

        const info = document.createElement('p');
        info.classList.add('card-text','text-center');
        info.innerHTML = `
             ${project.location || 'N/A'}<br>
             ${project.client_name || 'N/A'}<br>
            ${project.company_name || 'N/A'}
        `;

        cardBody.appendChild(title);
        cardBody.appendChild(info);
        contentCol.appendChild(cardBody);

        // Assemble card
        cardInnerRow.appendChild(imageCol);
        cardInnerRow.appendChild(contentCol);
        card.appendChild(cardInnerRow);
        col.appendChild(card);
        row.appendChild(col);
        projectsContainer.appendChild(row);
    });
} else {
    projectsContainer.innerHTML = '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><p class="text-white m-0">No projects available.</p></div>';

}

//products

const productContainer = document.getElementById('productContainer');

if (member.products && member.products.length > 0) {
    productContainer.innerHTML = '';

    member.products.forEach((product) => {
        // Create row for each card
        const row = document.createElement('div');
        row.classList.add('row', 'mb-4');

        const col = document.createElement('div');
        col.classList.add('col-12');

        // Card
        const card = document.createElement('div');
        card.classList.add('card', 'shadow-sm', 'border-0','px-2');
        card.style.background = 'rgba(255, 255, 255, 0.1)';
        card.style.color = 'white';

        // Row inside card
        const cardInnerRow = document.createElement('div');
        cardInnerRow.classList.add('row', 'g-0', 'align-items-center');

        // Image column
        const imageCol = document.createElement('div');
        imageCol.classList.add('col-md-4');

        const productImage = document.createElement('img');
        productImage.src = product.product_image ? `/storage/app/public/${product.product_image}` :
            '/assets/images/default-product.png';
        productImage.classList.add('img-fluid', 'rounded-start');
        productImage.alt = product.product_name || 'Product Image';

        imageCol.appendChild(productImage);

        // Content column
        const contentCol = document.createElement('div');
        contentCol.classList.add('col-md-8');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        const title = document.createElement('h6');
        title.classList.add('card-title','text-white','text-center','mb-1');
        title.innerText = product.product_name || 'Unnamed Product';

        cardBody.appendChild(title);
        contentCol.appendChild(cardBody);

        // Assemble card
        cardInnerRow.appendChild(imageCol);
        cardInnerRow.appendChild(contentCol);
        card.appendChild(cardInnerRow);
        col.appendChild(card);
        row.appendChild(col);
        productContainer.appendChild(row);
    });
} else {
    productContainer.innerHTML = '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><p class="text-white m-0">No products available.</p></div>';
}

//company

const companyContainer = document.getElementById('companyContainer');

if (member.companies && member.companies.length > 0) {
    companyContainer.innerHTML = '';

    member.companies.forEach((company) => {
        const row = document.createElement('div');
        row.classList.add('row', 'mb-4');

        const col = document.createElement('div');
        col.classList.add('col-12');

        const card = document.createElement('div');
        card.classList.add('card', 'shadow-sm', 'border-0');
        card.style.background = 'rgba(255, 255, 255, 0.1)';
        card.style.color = 'white';

        const body = document.createElement('div');
        body.classList.add('card-body');
        const name = document.createElement('h5');
name.classList.add('card-title', 'text-center');
name.textContent = company.company_name || 'Unnamed Company';
name.style.color = 'white'; // Set text color to white


        const industry = document.createElement('p');
        industry.classList.add('card-text');
        industry.innerHTML = `<strong>Industry:</strong> ${company.industry || 'N/A'}`;

        const designation = document.createElement('p');
        designation.classList.add('card-text');
        designation.innerHTML = `<strong>Designation:</strong> ${company.designation || 'N/A'}`;

        const website = document.createElement('p');
        website.classList.add('card-text');
        website.innerHTML = `<strong>Website:</strong> <a href="${company.website}" target="_blank" class="text-white">${company.website}</a>`;

        body.appendChild(name);
        body.appendChild(industry);
        body.appendChild(designation);
        if (company.website) body.appendChild(website);

        card.appendChild(body);
        col.appendChild(card);
        row.appendChild(col);

        companyContainer.appendChild(row);
    });

} else {
    companyContainer.innerHTML = '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><p class="text-white m-0">No company information available.</p></div>';
}

            //services

            const servicesContainer = document.getElementById('servicesContainer');

if (member.services && member.services.length > 0) {
    servicesContainer.innerHTML = '';

    member.services.forEach((service) => {
        const row = document.createElement('div');
        row.classList.add('row', 'mb-4');

        const col = document.createElement('div');
        col.classList.add('col-12'); // Full width

        // Card
        const card = document.createElement('div');
        card.classList.add('card', 'shadow-sm', 'border-0');
        card.style.background = 'rgba(255, 255, 255, 0.1)';
        card.style.color = 'white';

       // Image
const image = document.createElement('img');
image.src = service.image ? `/storage/app/public/${service.image}` :
    '/assets/images/default-service.png';
image.classList.add('card-img-top', 'mx-auto', 'mt-3'); // mx-auto centers image, mt-3 adds top margin
image.alt = service.service_name || 'Service Image';
image.style.height = '70px';
image.style.width = '70px';
image.style.objectFit = 'cover';
        // Card Body
        const body = document.createElement('div');
        body.classList.add('card-body');

        const title = document.createElement('h6');
        title.classList.add('card-title','text-center');
        title.innerText = service.service_name || 'Unnamed Service';

        body.appendChild(title);
        card.appendChild(image);
        card.appendChild(body);
        col.appendChild(card);
        row.appendChild(col);

        servicesContainer.appendChild(row);
    });

} else {
    servicesContainer.innerHTML = '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><p class="text-white m-0">No services available.</p></div>';

}





            // Default tab
            showTab('personal');
        }

        function closeMemberDetails() {
            document.getElementById('memberDetailsContainer').style.display = 'none';
            document.querySelector('.main-content').classList.remove('shift-left');
            document.getElementById('memberCardGrid').classList.remove('sidebar-active');
            document.querySelector('.search-grid-wrapper').classList.remove('sidebar-active');
        }

        function showTab(tabName, event) {
            document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            if (event) event.target.classList.add('active');
        }
    </script>
@endsection
