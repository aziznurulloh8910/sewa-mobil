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
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="rankingAset" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Aset</th>
                                                <th>Nilai Preferensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rankedAssets as $index => $rankedAsset)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $rankedAsset['asset']->name }}</td>
                                                    <td>{{ $rankedAsset['preference'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    @push('data')
        <script src="{{ asset('/js/data/ranking.js') }}"></script>
    @endpush

    <x-footer></x-footer>
</x-layout-dashboard>
