<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .banner-img-container {
        position: relative;
        display: inline-block;
    }

    .banner-img {
        width: 100px;
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img-container:hover .banner-img {
        transform: scale(1.5);
    }

    #memberDetailsBody th {
        text-transform: capitalize;
        font-size: 14px;
    }

    #memberDetailsBody td {
        font-size: 13px;
    }

    #memberDetailsContainer {
        font-size: 14px;
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
    }

    .table th {
        color: white !important;
        background-color: #003366;
        font-size: 15px;
    }

    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        display: inline-block;
        width: 100%;
    }

    .bg-primary {
        background-color: rgba(0, 0, 0, 0.151) !important;
    }

    .custom-btn {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 8px 17px;
        font-size: 16px;
        border-radius: 5%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }
</style>

<!-- Tabs -->
<div class="overflow-auto">
    <ul class="nav nav-tabs flex-nowrap" id="pricingTabs" role="tablist" style="white-space: nowrap;">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="image1-tab" data-bs-toggle="tab" href="#image1" role="tab">Image 1</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="image2-tab" data-bs-toggle="tab" href="#image2" role="tab">Image 2</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="image3-tab" data-bs-toggle="tab" href="#image3" role="tab">Image 3</a>
        </li>
    </ul>
</div>

<!-- Tab Panes -->
<div class="tab-content mt-3">

    <div class="tab-pane fade show active" id="image1" role="tabpanel">
        <div class="table-responsive mt-2">
            <table id="Table1" class="table table-striped table-bordered dt-responsive nowrap w-100">
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
                @foreach ($image1 as $index => $img)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="banner-img-container text-center">
                                <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                            </div>
                        </td>
                        <td style="max-width: 200px;">
                            <a href="{{ $img->website_link }}" target="_blank" title="{{ $img->website_link }}" class="d-inline-block text-truncate w-100">{{ $img->website_link }}</a>
                        </td>
                        <td class="text-center">{{ $img->created_at ? \Carbon\Carbon::parse($img->created_at)->format('d-m-Y h:i A') : 'N/A' }}</td>
                        <td class="text-center">
                            <form action="{{ route('delete.image1', $img->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="image2" role="tabpanel">
        <div class="table-responsive mt-2">
            <table id="Table2" class="table table-striped table-bordered dt-responsive nowrap w-100">
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
                @foreach ($image2 as $index => $img)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="banner-img-container text-center">
                                <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                            </div>
                        </td>
                        <td style="max-width: 200px;">
                            <a href="{{ $img->website_link }}" target="_blank" title="{{ $img->website_link }}" class="d-inline-block text-truncate w-100">{{ $img->website_link }}</a>
                        </td>
                        <td class="text-center">{{ $img->created_at ? \Carbon\Carbon::parse($img->created_at)->format('d-m-Y h:i A') : 'N/A' }}</td>
                        <td class="text-center">
                            <form action="{{ route('delete.image2', $img->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="image3" role="tabpanel">
        <div class="table-responsive mt-2">
            <table id="Table3" class="table table-striped table-bordered dt-responsive nowrap w-100">
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
                @foreach ($image3 as $index => $img)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="banner-img-container text-center">
                                <img class="banner-img" src="{{ asset('storage/app/public/' . $img->image_path) }}" alt="Image">
                            </div>
                        </td>
                        <td style="max-width: 200px;">
                            <a href="{{ $img->website_link }}" target="_blank" title="{{ $img->website_link }}" class="d-inline-block text-truncate w-100">{{ $img->website_link }}</a>
                        </td>
                        <td class="text-center">{{ $img->created_at ? \Carbon\Carbon::parse($img->created_at)->format('d-m-Y h:i A') : 'N/A' }}</td>
                        <td class="text-center">
                            <form action="{{ route('delete.image3', $img->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-button" data-name="Image 3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
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
            lengthMenu: [10, 25, 50, 100]
        });
    }

    $(document).ready(function () {
        initDataTable('#Table1');
        initDataTable('#Table2');
        initDataTable('#Table3');

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().responsive.recalc();
        });
    });
</script>
