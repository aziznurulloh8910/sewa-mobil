<x-layout-dashboard>
    <!-- BEGIN: Header-->
    <x-navbar></x-navbar>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <x-sidebar></x-sidebar>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                <strong>Info:</strong> Hello {{ auth()->user()->name }}, Selamat datang di Aplikasi Sewa Mobol PT Jasamedika 🙋🏻‍♂️🙋🏻‍♀️
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <!-- Tambahkan elemen di sini -->
                <div class="row">
                    <div class="col-12">
                        @if(session('error'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: '{{ session('error') }}',
                                    });
                                });
                            </script>
                        @endif
                    </div>
                </div>
                <!-- Akhir elemen yang ditambahkan -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>
</x-layout-dashboard>
