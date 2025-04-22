

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('sweetalert'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: '{{ session('sweetalert') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('sweetalert_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('sweetalert_error') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
