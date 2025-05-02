<style>

    .top-ad-container {

        height: 250px;
        justify-content: center;
        align-items: center;
        padding: 0;
        background-color: #ffcc00;
        transition: all 1s ease;

    }

    .top-ad-banner {
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
        transition: transform 1s ease;
        /* Smooth transition for sliding */
    }

    .slider-item {
        min-width: 100%;
        transition: opacity 1s ease;
        /* Fade effect for items */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .slider-item .top-ad-banner {
        width: 100%;
        /* Full width for each ad banner */
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



    .top-ad-banner {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 1px;
        padding: 1px;

    }

    .ad-banner-image {
        width: 100%;
        height: 100%;
        object-fit:fill;
        border-radius: 10px;
    }

    .top-ad-container {

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
        object-fit:fill;
        display: block;

    }

    .top-ad-container1 {
        display: flex;
        flex-direction: column;
        /* Stack image and details vertically */
        align-items: center;
        /* Center content */
        justify-content: center;
        background-color: #ffffff;
        padding: 2px;
        border-radius: 10px;

        /* Adjusted for a compact look */
        margin: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        overflow: hidden;
        width: 500px;
    height: 189px;
    margin-top: 6px;
    }

    .top-ad-banner1 {
        width: 150px;
        /* Fixed square size */
        height: 135px;
        overflow: hidden;
        border-radius: 0;
        /* Keeps it square */
        margin-bottom: 8px;
        /* Space between image and details */
    }

    .top-ad-banner1 img {

        width: 86%;
        height: 100%;
        object-fit: fill;
        /* Ensures the image fills the square */
        border-radius: 10px;
        /* Removes rounded corners */
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
    font-size: 14px !important;
    margin: 15px 20px; /* Reduced top margin from 23px to 15px */
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
/* Mobile Responsive */
    @media (max-width: 768px) {

        #top-ad1,
        #top-ad {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .top-ad-container1,
        .top-ad-container {
            width: 100%;

        }

        .top-ad-banner1 img {
            width: 100%;
            height: auto;

        }

        #top-ad {
            position: relative;
            overflow: hidden;
            width: 100%;
            transform: translateY(-70px);
            height: 126px;
        }

        .top-ad-container1 {
            max-width: 600px;
            height: 85px;
            border-radius: 0px;
        }

        .details-container {
            height: 50px;
        }

        .details-container h2 {
            font-size: 13px !important;
        }

        .details-container p {

            font-size: 12px !important;
        }

        .top-ad-banner1 img {
            height: 50px;
            width: 80px;
            margin-left: 60px;
            margin-top: 28px;
            border-radius: 5px;
        }

        .top-ad-banner1 {
            margin-bottom: 0px;
        }

        .top-ad-banner {
            border-radius: 0px;
        }

        .top-ad-banner img {
            border-radius: 1px;
        }

        .details-container {
            flex: 1;
        }

        #top-ad1 {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            gap: 10px;
            flex-wrap: nowrap;
        }
    }
</style>
