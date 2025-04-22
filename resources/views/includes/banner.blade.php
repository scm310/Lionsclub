<style>
    /* Dynamic Top Ad Banner Styling */
    .top-ad-container {
      display: flex;
      height: 250px;
      justify-content: center;
      align-items: center;
      padding: 0;
      background-color: #ffcc00;
      transition: all 1s ease; /* Smooth transition */
    }

    .top-ad-banner
  {
      background-color: #ffffff00;
      color: #003366;
      font-weight: bold;
      text-align: center;
      border-radius: 10px;
      margin: 5px;
      height: 200px;
      width: 100%;
    }

    /* Styling for the slider container */
    #top-ad {
      position: relative;
      overflow: hidden;
      width: 100.4%;
      transform: translateY(-60px);
      height: 95%;


      border-radius: 10px;
      object-fit: cover
    }



    .slider-wrapper {
      display: flex;
      transition: transform 1s ease; /* Smooth transition for sliding */
    }

    .slider-item {
      min-width: 100%;
      transition: opacity 1s ease; /* Fade effect for items */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slider-item .top-ad-banner {
      width: 100%; /* Full width for each ad banner */
      padding: 20px;
      text-align: center;
      background-color: #f1f1f100;
      border: 1px solid #dddddd00;
    }

    .slider-item:not(.active) {
      opacity: 0;
      visibility: hidden;
    }

    /* Optional: Styling for the active state */
    .slider-item.active {
      opacity: 1;
      visibility: visible;
    }

      /* .top-ad-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0px;
      background-color: #ffcc00;
      height: 250px;
      overflow: hidden;
      position: relative;
    } */

    .top-ad-banner {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 1px; /* Removes extra margins */
      padding: 1px; /* Removes extra padding */
    }

    .ad-banner-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .top-ad-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0px;
      background-color: #ffcc00;
      height: 200px;
      overflow: hidden;
    }
    .top-ad-banner img {
      max-width: 100%;
      max-height: 250%;
      object-fit: cover;
      display: block;

    }
    .top-ad-container1 {
  display: flex;
  flex-direction: column; /* Stack image and details vertically */
  align-items: center; /* Center content */
  justify-content: center;
  background-color: #ffffff;
  padding: 2px;
  border-radius: 10px;
  max-width: 220px; /* Adjusted for a compact look */
  margin: auto;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  overflow: hidden;
  width: 140%;
  height: 95%;
}

.top-ad-banner1 {
  width: 150px; /* Fixed square size */
  height: 135px;
  overflow: hidden;
  border-radius: 0; /* Keeps it square */
  margin-bottom: 8px; /* Space between image and details */
}

.top-ad-banner1 img {

  width: 100%;
  height: 100%;
  object-fit:fill; /* Ensures the image fills the square */
  border-radius:10px; /* Removes rounded corners */
}


.details-container {
  background-color: #ffffff00;
  padding: 6px;
  border-radius: 5px;
  width: 100%;
  font-size: 12px;
  word-wrap: break-word;
  overflow-wrap: break-word;
}

.details-container h2 {
  font-size:15px !important;
  margin: 4px 0;
  color: #003366;

}

.details-container p {
  font-size: 11px !important;
  margin: 2px 0;
  color: #333;
  line-height: 1.2;
}

.top-ad-row {

display: flex;
justify-content: center;
align-items: center;
gap: 5px;

}

@media (max-width: 768px) {
  #top-ad1, #top-ad {
      display: flex;
      flex-direction: column; /* Force each div into its own row */
      width: 100%; /* Ensure full width */
  }

  .top-ad-container1, .top-ad-container {
      width: 100%; /* Make sure both take up full width */
      display: block; /* Ensure each container stacks */
      margin-bottom:; /* Add space between them */
  }

  .top-ad-banner1 img {
      width: 100%; /* Ensure the image is responsive */
      height: auto;
      display: block; /* Prevent inline spacing issues */
  }

  #top-ad {
  position: relative;
  overflow: hidden;
  width: 100%;
  transform: translateY(-70px);
  height: 126px;
}

.top-ad-container1 {
max-width:400px;
height:85px;
border-radius: 0px;
}
.details-container{
height:50px;
}

.details-container h2 {
font-size:13px !important;
}

.details-container p {

font-size:12px !important;
}

.top-ad-banner1 img{
height:50px;
width:80px;
margin-left: 60px;
margin-top:28px;
border-radius: 5px;
}
.top-ad-banner1{
margin-bottom: 0px;
}
.top-ad-banner{
border-radius:0px;
}
.top-ad-banner img {
border-radius: 1px;
}
.details-container {
      flex: 1; /* Allow text to take remaining space */
  }

  #top-ad1 {
      display: flex;
      flex-direction: row; /* Arrange items in a row */
      align-items: center; /* Align items vertically */
      justify-content: start; /* Align items to the left */
      gap: 10px; /* Add space between elements */
      flex-wrap: nowrap; /* Prevent wrapping */
  }
}

      </style>


  <!-- Top Ad Banner (Dynamic) -->

  @php
  $member = \App\Models\MemberDetail::first(); // Fetch first member from the table
@endphp

@if($member)
  <div id="top-ad1" class="top-ad-container1 mx-1">
      <div class="top-ad-banner1">
          <img src="{{ asset('storage/app/public/' . $member->image) }}" alt="{{ $member->name }}" class="ban" />
      </div>
      <div class="details-container">
          <h2 class="fs-4">{{ $member->name }}</h2>
          <p class="fs-6 mb-1"><b>{{ $member->role }}</b></p>
      </div>
  </div>
@endif






<?php
use Illuminate\Support\Facades\DB;

$banners_10000 = DB::table('banner_10000')->select('image_path', 'url')->get();
$banners_5000 = DB::table('banner_5000')->select('image_path', 'url')->get();
$banners_1000 = DB::table('banner_1000')->select('image_path', 'url')->get();

$bannerData = [
  '10000' => $banners_10000,
  '5000' => $banners_5000,
  '1000' => $banners_1000,
];
?>

<div id="top-ad" class="top-ad-container "></div>

<script>
  const bannerData = <?php echo json_encode($bannerData); ?>;
  let bannerQueue = [];
  let currentIndex = 0;

  function shuffle(array) {
      return array.sort(() => Math.random() - 0.5);
  }

  function prepareBanners() {
      let b10000 = shuffle(bannerData['10000'].map(banner => ({ ...banner, type: '10000' })));
      let b5000 = shuffle(bannerData['5000'].map(banner => ({ ...banner, type: '5000' })));
      let b1000 = shuffle(bannerData['1000'].map(banner => ({ ...banner, type: '1000' })));

      let maxLength = Math.max(b10000.length, Math.floor(b5000.length / 2), Math.floor(b1000.length / 3));

      let tempQueue = [];
      for (let i = 0; i < maxLength; i++) {
          if (b10000[i]) tempQueue.push([b10000[i]]);
          if (b5000[i * 2] && b5000[i * 2 + 1]) tempQueue.push([b5000[i * 2], b5000[i * 2 + 1]]);
          if (b1000[i * 3] && b1000[i * 3 + 1] && b1000[i * 3 + 2]) {
              tempQueue.push([b1000[i * 3], b1000[i * 3 + 1], b1000[i * 3 + 2]]);
          }
      }

      // Shuffle the final banner queue
      bannerQueue = shuffle(tempQueue);

      // Store in sessionStorage to ensure a different set for each user session
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
                  <a href="${banner.url}" target="_blank">
                      <img src="/storage/app/public/${banner.image_path}" alt="Banner Image" class="ad-banner-image" loading="lazy"/>
                  </a>
              </div>
          `;
      });
      html += '</div>';
      return html;
  }

  // Check if banners exist in sessionStorage; if not, prepare new banners
  let storedQueue = sessionStorage.getItem('bannerQueue');
  if (storedQueue) {
      bannerQueue = JSON.parse(storedQueue);
  } else {
      prepareBanners();
  }

  showNextBanner();
  setInterval(showNextBanner, 5000);
</script>
