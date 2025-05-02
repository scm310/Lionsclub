    @extends('memberlayout.sidebar')

    @section('content')
    <style>
        .announcement-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .announcement-card {
            flex: 1 1 calc(33.333% - 20px);
            background: linear-gradient(to right, #ffffff, #f0f4f8);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 320px;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        }

        .announcement-card img {
            height: 200px;
            object-fit: fill;
            width:100%;
            padding: 20px;
            border-radius:30px;
        }

        .announcement-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex-grow: 1;
        }

        .announcement-title {
            font-weight: bold;
            color: #2c3e50;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .announcement-date {
            font-size: 13px;
            color: #888;
            margin-bottom: 10px;
        }

        .announcement-message {
            font-size: 14px;
            color: #333;
            flex-grow: 1;
        }

        .announcement-footer {
            font-size: 12px;
            color: #555;
            margin-top: 15px;
            text-align: right;
        }

        @media (max-width: 992px) {
            .announcement-card {
                flex: 1 1 calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .announcement-card {
                flex: 1 1 100%;
            }
        }

        .white-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: auto;
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

        .custom-btn {
            background: linear-gradient(115deg, #0f0b8c, #77dcf5);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5%;
            align-items: center !;
            justify-content: center;
            transition: 0.3s;
        }

        .white-container {
            background-color: #fff;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
    </style>
<div class="white-container mt-3">
    <h3 class="custom-heading">Announcements</h3>
    <h6 class="text-danger text-center mt-2">This announcement will be closed within 48 hours.</h6>

    <div class="announcement-grid mt-4">
        @forelse($announcements as $announcement)
            <div class="announcement-card">
                <img
                    src="{{ $announcement->image ? asset('storage/app/public/' . $announcement->image) : asset('assets/images/default1.jpg') }}"
                    alt="Announcement Image"
                >
                <div class="announcement-content">
                    <div class="announcement-title">{{ $announcement->subject }}</div>
                    <div class="announcement-date">Posted on: {{ $announcement->created_at->format('d M Y') }}</div>
                    <div class="announcement-message">{{ $announcement->message }}</div>
                </div>
            </div>
        @empty
            <p class="text-center">No announcements available.</p>
        @endforelse
    </div>
</div>






    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(t => new bootstrap.Tooltip(t));
        });
    </script>
    @endsection