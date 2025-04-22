<style>
    .modal-content {
        height: 500px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        text-align: center;
        position: relative;
        padding: 40px 20px;
        border-radius: 10px;
        transition: background-image 1s ease-in-out;
        color: white;
    }

    .modal-body,
    .modal-header {
        position: relative;
        z-index: 2;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-title {
        font-size: 28px;
        font-weight: bold;
    }

    .modal-body p {
        font-size: 18px;
        margin-top: 10px;
    }

    .carousel-link {
        text-decoration: none;
        height: 100%;
        display: block;
        color: inherit;
        cursor: pointer;
        width: 100%;
    }

    @media (max-width: 768px) {
        .modal-content {
            margin-top: 50%;
            height: 225px;
            padding: 40px 20px;
        }
    }
</style>

@php
    $popups = \App\Models\Popup::latest()->get();
    $popupData = $popups->map(function ($popup) {
        $imagePath = asset('storage/app/public/' . $popup->image);
        return [
            'image' => $imagePath,
            'link' => $popup->link,
            'tracking_url' => route('track.banner.click', [
                'type' => 'popup',
                'url' => $popup->link,
                'image' => $imagePath,
            ]),
        ];
    })->toArray();
@endphp

@if(count($popupData) > 0)
    <div class="modal fade" id="popupCarouselModal" tabindex="-1" aria-labelledby="popupCarouselLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content position-relative" id="modalBackground"
                 style="background-image: url('{{ $popupData[0]['image'] ?? asset("assets/images/celebration.jpg") }}');">

                <!-- Clickable background -->
                <a href="{{ $popupData[0]['tracking_url'] ?? '#' }}" id="modalBgLink" target="_blank"
                   class="stretched-link d-block w-100 h-100" style="z-index: 5;"></a>

                <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"
                        style="top: 10px; right: 10px; z-index: 10;"></button>

                <div class="modal-body p-0">
                    <div id="popupCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($popupData as $key => $popup)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                                     data-bg="{{ $popup['image'] }}"
                                     data-link="{{ $popup['link'] }}"
                                     data-track="{{ $popup['tracking_url'] }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let popups = @json($popupData);
            let modalBg = document.getElementById("modalBackground");
            let modalBgLink = document.getElementById("modalBgLink");
            let carousel = document.getElementById("popupCarousel");
            let closeBtn = document.querySelector("#popupCarouselModal .btn-close");

            if (sessionStorage.getItem("popupShown")) return;

            let loadedImages = 0;
            const totalImages = popups.length;

            popups.forEach(popup => {
                const img = new Image();
                img.src = popup.image;
                img.onload = () => {
                    loadedImages++;
                    if (loadedImages === totalImages) {
                        setTimeout(() => {
                            let popupModal = new bootstrap.Modal(document.getElementById('popupCarouselModal'));
                            popupModal.show();
                            setTimeout(() => popupModal.hide(), 300000);
                        }, 3000);
                    }
                };
            });

            closeBtn.addEventListener("click", () => {
                sessionStorage.setItem("popupShown", "true");
            });

            carousel.addEventListener('slide.bs.carousel', function (event) {
                const nextSlide = event.relatedTarget;
                const nextImage = nextSlide.getAttribute('data-bg');
                const nextTrackingUrl = nextSlide.getAttribute('data-track');

                if (nextImage) {
                    modalBg.style.backgroundImage = `url('${nextImage}')`;
                }

                if (nextTrackingUrl) {
                    modalBgLink.href = nextTrackingUrl;
                    modalBgLink.style.display = 'block';
                } else {
                    modalBgLink.href = '#';
                    modalBgLink.style.display = 'none';
                }
            });
        });
    </script>
@endif



  