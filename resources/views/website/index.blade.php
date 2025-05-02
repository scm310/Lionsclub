@extends ('layouts.navbar')


@section('content')
    {{-- style css section --}}
    <style>
        /* General Styles */
        .ad-banner-image {
            width: 100%;
            height: 100%;
            object-fit: fill;
            border-radius: 10px;
        }

        /* Main Content Layout */
        .container {
            display: flex;
            max-width: 1400px;
            gap: 20px;
        }

        .left,
        .right {
            position: relative;
            max-width: 300px;
        }

        .left {
            top: 30px;
        }

        .right {
            top: 20px;
        }

        /* Center Content */
        .center {
            flex: 2;
            max-width: 900px;
            width: 100%;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        /* Scrollable Container */
        .scroll-container {
            max-height: 150px;
            overflow: hidden;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            background-image: url("{{ asset('assets/images/bb.png') }}");
            object-fit: fill;
            color: rgb(0, 0, 0);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Scrolling Animation */
        @keyframes verticalScroll {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-100%);
            }
        }

        .scroll-content {
            display: flex;
            flex-direction: column;
            animation: scrollUp 10s linear infinite;
        }

        /* Additional Containers */
        .additional-containers {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .additional-container {
            height: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #ffffff;
        }

        /* Right Column Ads */
        .banner-image {
            width: 48%;
            height: 100px;
            object-fit: fill;
            border-radius: 5px;
        }

        /* Ad Carousel */
        .ad-carousel {
            position: relative;
            width: 300px;
            height: 300px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .ad-images {
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.5s ease-in-out;
        }

        .ad-images img {
            width: 107%;
            height: 300px;
            display: none;
        }

        .ad-images img.active {
            display: block;
        }

        .next-btn,
        .prev-btn {
            position: absolute;
            width: 22px;
            padding: 0;
        }

        .next-btn {
            right: -5px;
        }

        .prev-btn {
            left: -5px;
        }

        .content1,
        .content2,
        .content3,
        .content4 p {
            font-size: small;
        }

        .bottom-ad-container {
            height: 200px;
        }



        .bottom-ad-banner {
            background-color: #ffffff00;
            color: #003366;
            font-weight: bold;
            text-align: center;
            border-radius: 10px;
            margin: 0px;
            height: inherit;
            padding: 5px;
            width: fit-content;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Responsive Adjustments */

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 10px;
                margin-top: -2px;
            }

            .left,
            .right {
                max-width: 100%;
            }

            .center {
                max-width: 100%;
                padding: 10px;
            }



            .right-ad {
                flex: 0 0 auto;
                width: 120px;
                height: 150px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 5px;
                background-color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .right-ad img {
                width: 100%;
                height: 100%;
                object-fit: fill;
                border-radius: 5px;
            }

            .additional-container {
                width: 100%;
                height: auto;
            }

            .bottom-ad-container {
                height: 125px;
            }

            .ad-banner-image {
                width: 100%;
                height: 100px;
                object-fit: fill;
                border-radius: 10px;
            }

            /* Bootstrap Utility Classes */
            .d-flex {
                display: flex !important;
            }

            .flex-column {
                flex-direction: column !important;
            }

            .align-items-center {
                align-items: center !important;
            }

            .justify-content-between {
                justify-content: space-between !important;
            }

            .gap-2 {
                gap: 0.5rem !important;
            }

            .overflow-auto {
                overflow: auto !important;
            }

            .rounded {
                border-radius: 5px !important;
            }

            .p-2 {
                padding: 0.5rem !important;
            }

            .m-0 {
                margin: 0 !important;
            }

            .ms {
                margin-top: -40px;
            }
        }
    </style>



    {{-- Code Section start --}}

    {{-- Code Section --}}
    <div class="container ms">
        <!-- Left Column: Birthday, Events Calendar, and Ad Containers -->
        <div class="left">
            {{-- Birthday --}}
            @include('website.partial.birthday')
            {{-- Event Calendar start --}}
            @include('website.partial.event')
            {{-- Event Calendar end --}}

            <div class="additional-containers" id="mobile">
                @foreach ([$images1, $images2] as $images)
                    <div class="additional-container ad-carousel">
                        <button class="prev-btn">&#10094;</button> <!-- Previous Button -->
                        <div class="ad-images">
                            @foreach ($images as $image)
                                <a href="{{ route('track.banner.click', ['type' => 'left', 'url' => $image->website_link, 'image' => $image->image_path]) }}"
                                    target="_blank">

                                    <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                        loading="lazy" />
                                </a>
                            @endforeach
                        </div>
                        <button class="next-btn">&#10095;</button> <!-- Next Button -->
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Rounded Edge Container -->
        <div
            style="max-width: 1200px; margin: 20px auto; padding: 8px; background: #fff; border-radius: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align:justify;">

            <!-- Center Column -->
            <div class="center">
                <div class="content1">
                    <h2>Welcome to Lions Club</h2>
                    <h5>Lions Club: A Beacon of Service and Community Empowerment</h5>
                    <p>The Lions Club is one of the largest and most respected international service organizations in the
                        world.
                        Founded in 1917 by Melvin Jones in Chicago, Illinois, the Lions Club was established with a mission
                        to
                        empower volunteers to serve their communities, meet humanitarian needs, encourage peace, and promote
                        international understanding. Today, the organization has a presence in over 200 countries, with more
                        than 1.4 million members committed to creating meaningful change in their communities and beyond.
                    </p>
                </div>

                {{-- mobile screen --}}
                <div class="additional-containers" id="mobilescreen">
                    @foreach ([$images1, $images2] as $images)
                        <div class="additional-container ad-carousel">
                            <button class="prev-btn">&#10094;</button> <!-- Previous Button -->
                            <div class="ad-images">
                                @foreach ($images as $image)
                                    <a href="{{ route('track.banner.click', ['type' => 'left', 'url' => $image->website_link, 'image' => $image->image_path]) }}"
                                        target="_blank">
                                        <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                            loading="lazy" />
                                    </a>
                                @endforeach
                            </div>
                            <button class="next-btn">&#10095;</button> <!-- Next Button -->
                        </div>
                        <br>
                    @endforeach
                </div>

                <div class="content2">
                    <h4>Vision and Mission</h4>
                    <p>The Lions Club’s vision is encapsulated in its motto, "We Serve." This guiding principle drives the
                        organization’s activities, which focus on helping those in need, whether through direct action,
                        advocacy, or resource mobilization. The Lions Club aims to tackle some of the world’s most pressing
                        challenges, such as hunger, poverty, environmental sustainability, and health crises. Through
                        collaborative efforts, the Lions Club fosters a sense of solidarity and shared responsibility,
                        uniting
                        people from diverse backgrounds to work toward common goals.
                    </p>
                </div>

                <div class="content4">
                    <h4>Key Areas of Focus</h4>
                    <p>The Lions Club’s initiatives are wide-ranging, reflecting its commitment to comprehensive community
                        betterment. Some of its major areas of focus include:</p>
                    <ul>
                        <li><strong>Vision and Eye Health:</strong>
                            <p>The Lions Club has long been associated with initiatives to
                                combat blindness and support eye health. The SightFirst program, for example, funds cataract
                                surgeries,
                                provides glasses, and raises awareness about eye care globally.</p>
                        </li>
                        <li><strong>Youth Empowerment:</strong>
                            <p>Through programs like the Leo Club, the Lions Club nurtures
                                young leaders by involving them in community service and leadership development. These
                                efforts inspire
                                the next generation to carry forward the spirit of service.</p>
                        </li>
                        <li><strong>Disaster Relief:</strong>
                            <p>The Lions Club is often at the forefront of providing emergency
                                relief in the wake of natural disasters, offering food, shelter, and medical aid to affected
                                communities.</p>
                        </li>
                        <li><strong>Environmental Sustainability:</strong>
                            <p>Recognizing the importance of protecting the planet,
                                the Lions Club engages in tree-planting campaigns, recycling initiatives, and other efforts
                                aimed at
                                preserving natural resources.</p>
                        </li>
                        <li><strong>Health and Hunger:</strong>
                            <p>From combating diabetes and cancer to addressing food
                                insecurity, the Lions Club is dedicated to improving public health and ensuring that no one
                                goes
                                hungry.</p>
                        </li>
                    </ul>
                </div>

                {{-- mobile screen --}}
                <div class="right" id="mobilescreen">
                    @foreach ([$image1s, $image2s, $image3s] as $images)
                        <div class="additional-container ad-carousel">
                            <button class="prev-btn">&#10094;</button> <!-- Previous Button -->
                            <div class="ad-images">
                                @foreach ($images as $image)
                                    <a href="{{ $image->website_link }}" target="_blank">
                                        <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                            loading="lazy" />
                                    </a>
                                @endforeach
                            </div>
                            <button class="next-btn">&#10095;</button> <!-- Next Button -->
                        </div>
                        <br>
                    @endforeach
                </div>

                <div class="content3">
                    <h4>Organizational Structure</h4>
                    <p>The Lions Club operates through local clubs, which are the backbone of the organization. Each club is
                        autonomous, allowing members to address the unique needs of their communities while adhering to the
                        broader mission of the Lions Club International. These local efforts are supported by regional,
                        national, and international structures, creating a network that facilitates the sharing of
                        resources,
                        expertise, and ideas.
                    </p>
                </div>
            </div>

        </div> <!-- End Rounded Edge Container -->

        <!-- Right Column: Ad Containers -->
        <div class="right " id="mobile">
            @foreach ([$image1s, $image2s, $image3s] as $images)
                <div class="additional-container ad-carousel">
                    <button class="prev-btn">&#10094;</button> <!-- Previous Button -->
                    <div class="ad-images">
                        @foreach ($images as $image)
                            <a href="{{ route('track.banner.click', ['type' => 'right', 'url' => $image->website_link, 'image' => $image->image_path]) }}"
                                target="_blank">

                                <img src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image"
                                    loading="lazy" />
                            </a>
                        @endforeach
                    </div>
                    <button class="next-btn">&#10095;</button> <!-- Next Button -->
                </div>
                <br>
            @endforeach
        </div>
    </div>

    <!-- Bottom banner -->
    <div class="bottom-ad-container">
        <div class="bottom-ad-banner">
            <button class="prev-btn" onclick="prevBottomAd()">&#10094;</button> <!-- Left Arrow -->
            @if (isset($bottomBanners) && $bottomBanners->isNotEmpty())
                @foreach ($bottomBanners as $banner)
                    <a href="{{ route('track.banner.click', ['type' => 'bottom', 'url' => $banner->website_link, 'image' => $banner->image]) }}"
                        target="_blank" style="height:-webkit-fill-available;">
                        <img src="{{ asset('storage/app/public/' . $banner->image) }}" alt="Bottom Ad"
                            class="ad-banner-image bottom-ad" loading="lazy">
                    </a>
                @endforeach
            @else
                <img src="{{ asset('assets/images/7.png') }}" alt="Bottom Ad" class="ad-banner-image" loading="lazy">
            @endif
            <button class="next-btn" onclick="nextBottomAd()">&#10095;</button> <!-- Right Arrow -->
        </div>
    </div>




    {{-- Script Section Start --}}

    <!--bottom banner-->
    <script>
        let currentAdIndex = 0;
        const ads = document.querySelectorAll('.bottom-ad');

        function showAd(index) {
            ads.forEach((ad, i) => {
                ad.style.display = i === index ? 'block' : 'none';
            });
        }

        function prevBottomAd() {
            currentAdIndex = (currentAdIndex - 1 + ads.length) % ads.length;
            showAd(currentAdIndex);
        }

        function nextBottomAd() {
            currentAdIndex = (currentAdIndex + 1) % ads.length;
            showAd(currentAdIndex);
        }

        // Auto slide every 5 seconds
        let autoSlide = setInterval(() => {
            nextBottomAd();
        }, 5000);

        // Initialize
        if (ads.length > 0) {
            showAd(currentAdIndex);
        }
    </script>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let topAdImages = [
                "{{ asset('images/1.png') }}",
                "{{ asset('images/2.png') }}",
                "{{ asset('images/3.png') }}"
            ];

            let bottomAdImages = [
                "{{ asset('assets/images/4.png') }}",
                "{{ asset('assets/images/5.png') }}",
                "{{ asset('assets/images/7.png') }}"
            ];

            let topAdIndex = 0;
            let bottomAdIndex = 0;

            function updateAd(id, images, index) {
                let imgElement = document.getElementById(id);
                if (imgElement) imgElement.src = images[index];
            }

            function nextAd(id, images, indexRef) {
                indexRef.value = (indexRef.value + 1) % images.length;
                updateAd(id, images, indexRef.value);
            }

            function prevAd(id, images, indexRef) {
                indexRef.value = (indexRef.value - 1 + images.length) % images.length;
                updateAd(id, images, indexRef.value);
            }

            setInterval(() => nextAd("topAd", topAdImages, {
                value: topAdIndex
            }), 3000);
            setInterval(() => nextAd("bottomAd", bottomAdImages, {
                value: bottomAdIndex
            }), 3000);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".ad-carousel").forEach(carousel => {
                let images = Array.from(carousel.querySelectorAll(".ad-images img"));
                let currentIndex = 0;

                function showImage(index) {
                    images.forEach((img, i) => img.style.display = i === index ? "block" : "none");
                    currentIndex = index;
                }

                let prevBtn = carousel.querySelector(".prev-btn");
                let nextBtn = carousel.querySelector(".next-btn");

                if (prevBtn) prevBtn.addEventListener("click", () => showImage((currentIndex - 1 + images
                    .length) % images.length));
                if (nextBtn) nextBtn.addEventListener("click", () => showImage((currentIndex + 1) % images
                    .length));

                setInterval(() => showImage((currentIndex + 1) % images.length), 3000);
                showImage(0);
            });
        });
    </script>

@endsection
