
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>


    .banner-img-container {
        position: relative;
        display: inline-block;
    }

    .banner-img {
        width: 100px;
        /* Initial size */
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img-container:hover .banner-img {
        transform: scale(1.5);
        /* Zoom out */

    }


    /* datatable */
#memberDetailsBody th {
    text-transform: capitalize;
    font-size: 14px; /* Adjust header font size */
}

#memberDetailsBody td {
    font-size: 13px; /* Adjust data font size */
}

#memberDetailsContainer {
    font-size: 14px; /* Adjust overall font size */
}
.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}

.table th{
    color: white !important;
    background-color:#003366;
    font-size: 15px;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white; /* Ensures text is readable */
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px; /* Optional rounded edges */
    display: inline-block; /* Adjusts width to fit content */
    width: 100%; /* Ensures it spans across the container */
}

.bg-primary{
    background-color: rgba(0, 0, 0, 0.151) !important;
}

.custom-btn {
    background: rgb(30,144,255);
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border: none;
    color: white;
    padding: 8px 17px;
    font-size: 16px;
    border-radius: 5%;
    transition: 0.3s;
}

.custom-btn:hover {
    background: linear-gradient(159deg, rgba(153,186,221,1) 0%, rgba(30,144,255,1) 100%);
    color: white;
}


/* Push search and length dropdown down a little */
.dataTables_length,
.dataTables_filter {
    margin-top: 0.5rem; /* Adjust as needed */
}

/* Odd and even row color for anniversariesTable1, anniversariesTable5000, and anniversariesTable1000 */
#anniversariesTable1 tbody tr:nth-child(odd),
#anniversariesTable5000 tbody tr:nth-child(odd),
#anniversariesTable1000 tbody tr:nth-child(odd) {
    background-color: #F0F8FF; /* Alice Blue */
}

#anniversariesTable1 tbody tr:nth-child(even),
#anniversariesTable5000 tbody tr:nth-child(even),
#anniversariesTable1000 tbody tr:nth-child(even) {
    background-color: #B9D9EB; /* Soft pastel blue */
}

/* Table cell padding and border for anniversariesTable1, anniversariesTable5000, and anniversariesTable1000 */
#anniversariesTable1 td,
#anniversariesTable5000 td,
#anniversariesTable1000 td {
    padding: 10px;
    border-color: #ddd;
}

/* Active pagination button style */
.page-item.active .page-link {
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border: none;
}


</style>



<div class="overflow-auto">
    <ul class="nav nav-tabs flex-nowrap" id="pricingTabs" role="tablist" style="white-space: nowrap;">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab10000" data-bs-toggle="tab" href="#banner10000" role="tab">
                {{ $bannerNames['10000'] ?? 'Banner 10,000' }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab5000" data-bs-toggle="tab" href="#banner5000" role="tab">
                {{ $bannerNames['5000'] ?? 'Banner 5,000' }}
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab1000" data-bs-toggle="tab" href="#banner1000" role="tab">
                {{ $bannerNames['1000'] ?? 'Banner 1,000' }}
            </a>
        </li>
    </ul>
</div>







<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="banner10000" role="tabpanel">
        {{-- banner10000 --}}
        <div class="text-center mb-0" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); padding: 4px; margin-bottom: 0; border-radius: 8px 8px 0 0;">
        <h4 class="text-white">{{ $bannerNames['10000'] ?? 'Banner 10,000' }} List</h4> <!-- Table Header Strip -->
        </div>
        <div class="table-responsive mt-2 ">
            <table id="anniversariesTable1" class="table table-striped table-bordered dt-responsive nowrap w-100">
                <thead class="bg-dark text-white text-center text-capitalize">
                    <tr>
                        <th>S.No</th>
                        <th>Banner Images</th>
                        <th>Website Link</th>
                        <th>Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banner10000 as $index => $banner)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" style="max-width: 100px;">
                            </td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <a href="{{ $banner->url }}" target="_blank" title="{{ $banner->url }}" class="d-inline-block text-truncate w-100">
                                    {{ $banner->url }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $banner->created_at ? \Carbon\Carbon::parse($banner->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                            </td>
                            <td class="text-center">
    <div style="min-width: 70px;">
        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="10000">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="banner5000" role="tabpanel">
        {{-- banner5000 --}}
        <div class="text-center mb-0" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); padding: 4px; margin-bottom: 0; border-radius: 8px 8px 0 0;">
        <h4 class="text-white">  {{ $bannerNames['5000'] ?? 'Banner 5,000' }} List</h4> <!-- Table Header Strip -->
        </div>
        <div class="table-responsive mt-2">
            <table id="anniversariesTable5000" class="table table-striped table-bordered table-hover w-100">
                <thead class="bg-dark text-white text-center text-capitalize">
                    <tr>
                        <th>S.No</th>
                        <th>Banner Image</th>
                        <th>Website Link</th>
                        <th>Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banner5000 as $index => $banner)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" style="max-width: 100px;">
                            </td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <a href="{{ $banner->url }}" target="_blank" title="{{ $banner->url }}" class="d-inline-block text-truncate w-100">
                                    {{ $banner->url }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $banner->created_at ? \Carbon\Carbon::parse($banner->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="5000">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="banner1000" role="tabpanel">
    {{-- banner1000 --}}
    <div class="text-center mb-0" style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); padding: 4px; margin-bottom: 0; border-radius: 8px 8px 0 0;">
        <h4 class="text-white">{{ $bannerNames['1000'] ?? 'Banner 1,000' }} List</h4> <!-- Table Header Strip -->
    </div>
    <div class="table-responsive mt-0">
        <table id="anniversariesTable1000" class="table table-striped table-bordered table-hover w-100">
            <thead class="bg-dark text-white text-center text-capitalize">
                <tr>
                    <th data-priority="1">S.No</th> <!-- High priority: always shown -->
                    <th data-priority="5">Banner Image</th>
                    <th data-priority="4">Website Link</th>
                    <th data-priority="3">Date & Time</th>
                    <th data-priority="2">Action</th> <!-- High priority: always shown -->
                </tr>
            </thead>

            <tbody>
                @foreach ($banner1000 as $index => $banner)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            <img src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" style="max-width: 100px;">
                        </td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <a href="{{ $banner->url }}" target="_blank" title="{{ $banner->url }}" class="d-inline-block text-truncate w-100">
                                {{ $banner->url }}
                            </a>
                        </td>
                        <td class="text-center">
                            {{ $banner->created_at ? \Carbon\Carbon::parse($banner->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="1000">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    function initDataTable(selector) {
        $(selector).DataTable({
            pageLength: 10,
            ordering: false,
            searching: true,
            lengthChange: true,
            info: true,
            responsive: true,
    columnDefs: [
        { responsivePriority: 1, targets: 0 }, // S.No
        { responsivePriority: 2, targets: -1 }, // Action (last column)
    ],
            lengthMenu: [10, 25, 50, 100]
        });
    }

    $(document).ready(function () {
        initDataTable('#anniversariesTable1');
        initDataTable('#anniversariesTable5000');
        initDataTable('#anniversariesTable1000');


        // Fix DataTables layout when switching tabs
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().responsive.recalc();
        });
    });


</script>











