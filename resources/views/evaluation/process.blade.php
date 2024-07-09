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
        <div class="content-body">

            <!-- Basic table -->
            <section id="ranking-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h1>Proses Perhitungan</h1>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Tables end -->
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>
</x-layout-dashboard>