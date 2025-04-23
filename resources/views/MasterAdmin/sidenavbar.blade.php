<style>
    /* Set blue background for the sidebar */
    #layout-menu {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5)
    }

    /* Remove background from non-active menu items */
    .menu-inner .menu-item {
        background: none !important;
        border: none;

    }

    /* Set active menu item with a slightly darker blue shade */
    .menu-item.active>a {
        background-color:rgb(1, 6, 10) !important;
        /* Darker blue for active item */
        color: rgb(243, 241, 233) !important;
        /* Yellow text */
    }

    /* Set default text and icon color */
    .menu-item>a {
        color: rgb(236, 235, 226) !important;
        /* Yellow text */
    }

    /* Set icon color to yellow */
    .menu-item>a .menu-icon {
        color: rgb(243, 242, 238) !important;
        /* Yellow icon */
    }

    /* On hover, change background slightly */
    .menu-item>a:hover {
        background-color: #004494 !important;
        /* Darker blue on hover */
        color: rgb(236, 235, 229) !important;
    }

    /* Remove sidebar shadow */
    .menu-inner-shadow {
        display: none;
    }
    .logo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.bg-menu-theme .menu-inner > .menu-item.active:before {
        background:rgb(14, 18, 206); /* or your desired color */
    }



</style>



<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
<div class="app-brand demo">
    <a class="app-brand-link">
    <div class="logo-container" style="margin-bottom: 20px;">
    <img src="/assets/images/logo.png" alt="" width="50" height="50">
    <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 18px; color:rgb(241, 240, 235);">Welcome, Admin!</span>
</div>

    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none" >
        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
</div>



    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('banner.upload.view') ? 'active' : '' }}">
            <a href="{{ route('banner.upload.view') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-image"></i>
                <div class="text-truncate">Upload Ads</div>
            </a>
        </li>

        {{-- Events created by scm 10.3.2023 --}}
        <li class="menu-item {{ request()->routeIs('event_index') ? 'active' : '' }}">
            <a href="{{ route('event_index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div class="text-truncate">Events</div>
            </a>
        </li>

        {{-- Event End --}}


        <li class="menu-item {{ request()->routeIs(['members.list', 'members.add', 'admin.approve-members']) ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link has-dropdown">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div class="text-truncate">Members</div>
        <i class="bx bx-chevron-down menu-arrow"></i>
    </a>

    <ul class="menu-sub" style="{{ request()->routeIs(['members.list', 'members.add', 'admin.approve-members']) ? 'display: block;' : 'display: none;' }}">
        <!-- Members List -->
        <li class="menu-item {{ request()->routeIs('members.list') ? 'active' : '' }}">
            <a href="{{ route('members.list') }}" class="menu-link">
                <div class="text-truncate">Members List</div>
            </a>
        </li>

        <!-- Add Members -->
        <li class="menu-item {{ request()->routeIs('members.add') ? 'active' : '' }}">
            <a href="{{ route('members.add') }}" class="menu-link">
                <div class="text-truncate">Add Members</div>
            </a>
        </li>

        <!-- Approve Member -->
        @if(session('admin_role') === 'club_administrator')
        <li class="menu-item {{ request()->routeIs('admin.approve-members') ? 'active' : '' }}">
            <a href="{{ route('admin.approve-members') }}" class="menu-link">
                <div class="text-truncate">Approve Member</div>
            </a>
        </li>
        @endif
    </ul>
</li>



<li class="menu-item {{ request()->routeIs('admin.member.lounge') ? 'active' : '' }}">
    <a href="{{ route('admin.member.lounge') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div class="text-truncate">Member Lounge</div>
    </a>
</li>



        {{-- //Member Role --}}

        <li class="menu-item {{ request()->routeIs(['assign.club','assign.member', 'members.remove']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link has-dropdown">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div class="text-truncate">Member Role</div>
                <i class="bx bx-chevron-down menu-arrow"></i>
            </a>
            <ul class="menu-sub" style="{{ request()->routeIs(['assign.club','assign.member', 'members.remove']) ? 'display: block;' : 'display: none;' }}">
                <!-- Members List -->

                <li class="menu-item {{ request()->routeIs('assign.club') ? 'active' : '' }}">
                    <a href="{{ route('assign.club') }}" class="menu-link">
                        <div class="text-truncate">Assign club</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('assign.member') ? 'active' : '' }}">
                    <a href="{{ route('assign.member') }}" class="menu-link">
                        <div class="text-truncate">Assign Member</div>
                    </a>
                </li>

                <!-- Add Members -->
                <li class="menu-item {{ request()->routeIs('members.remove') ? 'active' : '' }}">
                    <a href="{{ route('members.remove') }}" class="menu-link">
                        <div class="text-truncate"> Remove Member Role</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- //Member Role End  --}}




        <li class="menu-item {{ request()->routeIs('admin.birthday') ? 'active' : '' }}">
            <a href="{{ route('admin.birthday') }}" class="menu-link" title="View Birthdays and Anniversaries">
                <i class="menu-icon tf-icons bx bx-cake"></i>
                <div class="text-truncate">Birthdays and Anniversary</div>
            </a>
        </li>


        <li class="menu-item {{ request()->routeIs('membership.awards.index') ? 'active' : '' }}">
            <a href="{{ route('membership.awards.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-award"></i>
                <div class="text-truncate">Membership Awards</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.banner.clicks') ? 'active' : '' }}">
    <a href="{{ route('admin.banner.clicks') }}" class="menu-link d-flex justify-content-between align-items-center" title="Banner Clicks Statistics">
        <span>
            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
            <span class="text-truncate">Banner Click Stats</span>
        </span>

    </a>
</li>

<li class="menu-item {{ request()->routeIs('admin.visitors') ? 'active' : '' }}">
    <a href="{{ route('admin.visitors') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt"></i>
        <div class="text-truncate">Website Visitor Stats</div>
    </a>
</li>

        <li class="menu-item {{ request()->routeIs('admin.enquiries.*') || request()->routeIs('career.enquiry.page') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link has-dropdown">
        <i class="menu-icon tf-icons bx bx-envelope"></i>
        <div class="text-truncate">Enquiry Management</div>
        <i class="bx bx-chevron-down menu-arrow"></i>
    </a>
    <ul class="menu-sub" style="{{ request()->routeIs('admin.enquiries.*') || request()->routeIs('career.enquiry.page') ? 'display: block;' : 'display: none;' }}">
        <li class="menu-item {{ request()->routeIs('admin.enquiries.index') ? 'active' : '' }}">
            <a href="{{ route('admin.enquiries.index') }}" class="menu-link">
                <div class="text-truncate">Membership Enquiries</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.enquiries.donate') ? 'active' : '' }}">
            <a href="{{ route('admin.enquiries.donate') }}" class="menu-link">
                <div class="text-truncate">Donate Enquiry</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('career.enquiry.page') ? 'active' : '' }}">
            <a href="{{ route('career.enquiry.page') }}" class="menu-link">
                <div class="text-truncate">Post Job</div>
            </a>
        </li>
    </ul>
</li>


<li class="menu-item {{ request()->routeIs('admin.homepage.pinimage') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link has-dropdown">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div class="text-truncate">Homepage Setting</div>
        <i class="bx bx-chevron-down menu-arrow"></i>
    </a>
    <ul class="menu-sub" style="{{ request()->routeIs('admin.homepage.pinimage') ? 'display: block;' : 'display: none;' }}">
        <li class="menu-item {{ request()->routeIs('admin.homepage.pinimage') ? 'active' : '' }}">
            <a href="{{ route('admin.homepage.pinimage') }}" class="menu-link">
                <div class="text-truncate">Pin Image</div>
            </a>
        </li>
        <li class="menu-item">
    <a href="{{ route('footer.index') }}" class="menu-link">
        <div class="text-truncate">Footer Settings</div>
    </a>
</li>
    </ul>
</li>



        <li class="menu-item">
            <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div class="text-truncate">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

    </ul>
</aside>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".menu-item .has-dropdown").forEach(function(menu) {
            menu.addEventListener("click", function() {
                let subMenu = this.nextElementSibling;
                if (subMenu.style.display === "block") {
                    subMenu.style.display = "none";
                } else {
                    subMenu.style.display = "block";
                }
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".menu-item.has-sub > .menu-link").click(function(e) {
            e.preventDefault(); // Prevent default action
            $(this).parent().toggleClass("open");
            $(this).next(".menu-sub").slideToggle(); // Toggle submenu visibility
        });
    });
</script>
