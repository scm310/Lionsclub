<style>
    .zoom-image,
    .zoom-image1 {
        transition: transform 1.3s ease;
        cursor: pointer;
    }

    .zoom-image:hover,
    .zoom-image1:hover {
        transform: translateX(10px) translateY(20px) scale(1.6);
        /* Reduced scale for 60px base */
        z-index: 10000;
        position: relative;
    }

    .zoom-left:hover {
        transform: translateX(-20px) translateY(20px) scale(1.6);
        /* Matches visual intensity */
    }

    /* Subtle zoom for .top-ad-banner1 image */
    .top-ad-banner1 .zoom-image:hover {
        transform: scale(1.2);
        /* Slight zoom */
        z-index: 10;
        position: relative;
    }
</style>
{{-- Css blade Start --}}
@include('Frontend.bannersincludes.topbannercss')
{{-- Css blade End --}}

{{-- Member Profile & banner Date  start --}}

@php
    use Illuminate\Support\Facades\DB;

    $member = \App\Models\Member::with('team')
        ->whereHas('team', function ($query) {
            $query->where('position', 'District Governor')->where('year', 'CurrentYear');
        })
        ->first();


    $pinImages = DB::table('pin_images')->select('image_path')->get(); // Fetch all pin images

    $banners_10000 = DB::table('banner_10000')->select('image_path', 'url')->get();
    $banners_5000 = DB::table('banner_5000')->select('image_path', 'url')->get();
    $banners_1000 = DB::table('banner_1000')->select('image_path', 'url')->get();

    $bannerData = [
        '10000' => $banners_10000,
        '5000' => $banners_5000,
        '1000' => $banners_1000,
    ];

@endphp

@if ($member)
    <!-- Member Section -->
    <div id="top-ad1" class="top-ad-container1 mx-1 mobile ">

        <!-- Blue Strip inside the Member Details Container -->
        <div class="bg-blue text-white p-2 mt-3 position-relative"
            style="background-color: #003366; width: 366px;     height: 117px; z-index: 1000; top: -12%;">

            <div class="d-flex align-items-center justify-content-between h-100 px-2">
                <!-- Start Image (Left) -->
                <img src="{{ asset('assets/images/logo.png') }}" class="zoom-image" alt="Logo"
                    style="height: 60px; width: auto;">

                <!-- End Image (Right) -->
                @foreach ($pinImages as $image)
                    <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Pin Image"
                        style="height: 60px; width: auto; margin: 5px;" />
                @endforeach
            </div>

            <!-- Center Text (Overlapping flex container) -->
            <div class="position-absolute top-50 start-50 translate-middle text-center" style="line-height: 1;">
                <h5 class="m-0">
                    <span style="display: block;">Lions International</span>
                    <span style="display: block; font-size: 14px;">District 3241 E</span>
                </h5>
            </div>
        </div>

        <!-- Flex container to align the image and details side by side -->
        <div class="d-flex align-items-center mt-1" style="min-height: 80px;">
            <!-- Member Image on the Left -->
            <div class="top-ad-banner1"
                style="flex-shrink: 0; margin-right: 15px; overflow: visible; position: relative;">
                <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                    alt="{{ $member->salutation.' '.$member->first_name . ' ' . $member->last_name }} " class="ban zoom-image"
                    style="height: 102px; margin-left: -100px; margin-top: 10px;" />
            </div>

            <!-- Member Name and Role on the Right -->
            <div class="details-container" style="line-height: 1.2;">
                <h2 class="fs-5 mb-1">{{ $member->first_name . ' ' . $member->last_name }} </h2>
                <p class="fs-6 mb-0"><b>{{ $member->team->position }}</b></p>
            </div>
        </div>

    </div>
@endif





<div id="top-ad" class="top-ad-container mobile"></div>


{{-- Member Profile & banner Date  End --}}

{{-- ******script section **** --}}

{{-- Banner Script Section start --}}
<script>
    const bannerData = <?php echo json_encode($bannerData); ?>;
    let bannerQueue = [];
    let currentIndex = 0;

    function shuffle(array) {
        return array.sort(() => Math.random() - 0.5);
    }

    function prepareBanners() {
        let b10000 = shuffle(bannerData['10000'].map(banner => ({
            ...banner,
            type: '10000'
        })));
        let b5000 = shuffle(bannerData['5000'].map(banner => ({
            ...banner,
            type: '5000'
        })));
        let b1000 = shuffle(bannerData['1000'].map(banner => ({
            ...banner,
            type: '1000'
        })));

        let maxLength = Math.max(b10000.length, Math.floor(b5000.length / 2), Math.floor(b1000.length / 3));

        let tempQueue = [];
        for (let i = 0; i < maxLength; i++) {
            if (b10000[i]) tempQueue.push([b10000[i]]);
            if (b5000[i * 2] && b5000[i * 2 + 1]) tempQueue.push([b5000[i * 2], b5000[i * 2 + 1]]);
            if (b1000[i * 3] && b1000[i * 3 + 1] && b1000[i * 3 + 2]) {
                tempQueue.push([b1000[i * 3], b1000[i * 3 + 1], b1000[i * 3 + 2]]);
            }
        }


        bannerQueue = shuffle(tempQueue);
        sessionStorage.setItem('bannerQueue', JSON.stringify(bannerQueue));
    }

    function showNextBanner() {
        if (bannerQueue.length === 0) return;

        const topAdContainer = document.getElementById("top-ad");
        let bannersToShow = bannerQueue[currentIndex];

        let bannerHtml = generateBannerHtml(bannersToShow);
        topAdContainer.innerHTML = bannerHtml;

        currentIndex = (currentIndex + 1) % bannerQueue.length;
    }

    function generateBannerHtml(banners) {
        let html = '<div class="top-ad-row">';
        banners.forEach(banner => {
            html += `
              <div class="top-ad-banner">
           <a href="/track-click?type=top&url=${encodeURIComponent(banner.url)}&image=${encodeURIComponent(banner.image_path)}" target="_blank">

                      <img src="/storage/app/public/${banner.image_path}" alt="Banner Image" class="ad-banner-image" loading="lazy"/>
                  </a>
              </div>
          `;
        });
        html += '</div>';
        return html;
    }
    let storedQueue = sessionStorage.getItem('bannerQueue');
    if (storedQueue) {
        bannerQueue = JSON.parse(storedQueue);
    } else {
        prepareBanners();
    }

    showNextBanner();
    setInterval(showNextBanner, 5000);
</script>

{{-- Banner Script Section End --}}
