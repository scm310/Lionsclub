<style>

    .displayscreen {
        max-width: 1400px !important;
    }

    .modalmodify {
        height: 276px;!important
    }
    .small {
        font-size: 11px;

    }



.nav-pills {
    display: flex ;
    gap: 0px ;
    overflow-x: auto ;
    padding: 10px ;
    border-radius: 5px ;

}


.nav-pills .nav-link {
    color: #000 ;
    background-color: transparent ;
    border: none ;
    font-weight: 600;
    padding: 10px 15px;
}


.nav-pills .nav-link.active {
    background-color: #003366;
    color: #ffffff ;
    font-weight: bold;
    border-bottom: 2px solid #003366;
}

.tab-content {

    padding: 20px;
    border-radius: 5px ;
    min-height: 200px ;

}


    .profile-img:hover {
        transform: scale(1.5);
    }



</style>


<div class="row  ">
    <div class="col-12">
        <div class="overflow-auto">
            <ul class="nav nav-pills justify-content-start flex-nowrap d-flex" id="memberTabs" style="white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('international_officers') ? 'active' : '' }}"
                       href="{{ route('international_officers') }}">International Officers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dgteam') ? 'active' : '' }}"
                       href="{{ route('dgteam') }}">DG Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pastdistrictgovernor') ? 'active' : '' }}"
                       href="{{ route('pastdistrictgovernor') }}">Past District Governors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('districtchairperson') ? 'active' : '' }}"
                       href="{{ route('districtchairperson') }}">District Chairpersons</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('regionmember') ? 'active' : '' }}"
                       href="{{ route('regionmember') }}">Regions Member</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('chapter') ? 'active' : '' }}"
                       href="{{ route('chapter') }}">Clubs</a>
                </li>
            </ul>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabContainer = document.getElementById("memberTabs");
        const activeTab = document.querySelector("#memberTabs .nav-link.active");

        let isDragging = false;
        let startX, scrollLeft;

        // Ensure the active tab stays in view on page load
        if (activeTab) {
            const containerWidth = tabContainer.offsetWidth;
            const activeTabOffset = activeTab.offsetLeft - (containerWidth / 2) + (activeTab.offsetWidth / 2);
            tabContainer.scrollLeft = activeTabOffset;
        }

        // Drag functionality
        tabContainer.addEventListener("mousedown", (e) => {
            isDragging = true;
            startX = e.pageX - tabContainer.offsetLeft;
            scrollLeft = tabContainer.scrollLeft;
        });

        tabContainer.addEventListener("mouseleave", () => {
            isDragging = false;
        });

        tabContainer.addEventListener("mouseup", () => {
            isDragging = false;
        });

        tabContainer.addEventListener("mousemove", (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - tabContainer.offsetLeft;
            const walk = (x - startX) * 2; // Adjust drag speed
            tabContainer.scrollLeft = scrollLeft - walk;
        });

        // Touch functionality (for mobile)
        tabContainer.addEventListener("touchstart", (e) => {
            isDragging = true;
            startX = e.touches[0].pageX - tabContainer.offsetLeft;
            scrollLeft = tabContainer.scrollLeft;
        });

        tabContainer.addEventListener("touchend", () => {
            isDragging = false;
        });

        tabContainer.addEventListener("touchmove", (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX - tabContainer.offsetLeft;
            const walk = (x - startX) * 2;
            tabContainer.scrollLeft = scrollLeft - walk;
        });
    });
</script>


