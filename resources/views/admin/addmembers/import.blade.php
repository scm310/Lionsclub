@extends('MasterAdmin.layout')
<style>
    .custom-btn {
        background: rgb(30,144,255);
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border: none;
        color: white !important;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .small-input {
    max-width: 300px;
}

.container-white {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .header-strip {
        background-color: #4682b4;
        color: white;
        padding: 10px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        font-weight: bold;
        font-size: 18px;
    }

    .white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:100%;
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


  
</style>



@section('content')
<div class="container mt-4">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Import Data</h3>

        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="container" style="background-color:#87cefa; border-radius: 15px;">

            <div class="row mb-3">
                {{-- International Officers --}}
                <div class="col-md-4 mt-4">
    <div class="import-card">
        <h5>Import International Officers</h5>
        <form action="{{ route('import.international.officers') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Upload Excel File</label>
                <input type="file" name="file" class="form-control small-input" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn custom-btn mt-2">Import</button>
            </div>
        </form>
    </div>
</div>

{{-- DG Team --}}
<div class="col-md-4 mt-4">
    <div class="import-card">
        <h5>Import DG Team</h5>
        <form action="{{ route('import.dg.team') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Upload Excel File</label>
                <input type="file" name="file" class="form-control small-input" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn custom-btn mt-2">Import</button>
            </div>
        </form>
    </div>
</div>

{{-- Past Governors --}}
<div class="col-md-4 mt-4">
    <div class="import-card">
        <h5>Import Past Governors</h5>
        <form action="{{ route('import.past.governors') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Upload Excel File</label>
                <input type="file" name="file" class="form-control small-input" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn custom-btn mt-2">Import</button>
            </div>
        </form>
    </div>
</div>

            </div>

            <div class="row">
                {{-- District Chairpersons --}}
                <div class="col-md-4">
                    <div class="import-card">
                        <h5>Import District Chairpersons</h5>
                        <form action="{{ route('import.district.chairpersons') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Upload Excel File</label>
                                <input type="file" name="file" class="form-control small-input" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn mt-2">Import</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- District Governors --}}
                <div class="col-md-4">
                    <div class="import-card">
                        <h5>Import District Governors</h5>
                        <form action="{{ route('import.district.governors') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Upload Excel File</label>
                                <input type="file" name="file" class="form-control small-input" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn mt-2">Import</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Region Members --}}
                <div class="col-md-4">
                    <div class="import-card">
                        <h5>Import Region Members</h5>
                        <form action="{{ route('import.region.members') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Upload Excel File</label>
                                <input type="file" name="file" class="form-control small-input" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn mt-2">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Club Positions --}}
                <div class="col-md-4">
                    <div class="import-card">
                        <h5>Import Club Positions</h5>
                        <form action="{{ route('import.club.positions') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Upload Excel File</label>
                                <input type="file" name="file" class="form-control small-input" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn custom-btn mt-2">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Close inner .container -->
    </div> <!-- Close .white-container -->
</div> <!-- Close outermost .container -->


    


   

    <script>
        setTimeout(() => {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
    </script>
@endsection
