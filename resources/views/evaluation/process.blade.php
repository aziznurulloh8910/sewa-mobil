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
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <!-- Matriks Keputusan -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="matriksKeputusan" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Aset</th>
                                                <th>Kode</th>
                                                @foreach($criteria as $criterion)
                                                    <th>{{ $criterion->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($decisionMatrix as $index => $row)
                                                <tr>
                                                    <td>{{ $assets[$index]->name }}</td>
                                                    <td>A{{ $assets[$index]->id }}</td>
                                                    @foreach($row as $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Matriks Normalisasi -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="matriksNormalisasi" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Aset</th>
                                                @foreach($criteria as $criterion)
                                                    <th>{{ $criterion->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($normalizedMatrix as $index => $row)
                                                <tr>
                                                    <td>{{ $assets[$index]->name }}</td>
                                                    @foreach($row as $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Matriks Ternormalisasi Terbobot -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="matriksTerbobot" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Aset</th>
                                                @foreach($criteria as $criterion)
                                                    <th>{{ $criterion->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($weightedMatrix as $index => $row)
                                                <tr>
                                                    <td>{{ $assets[$index]->name }}</td>
                                                    @foreach($row as $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Solusi Ideal Positif dan Negatif -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="solusiIdeal" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach($criteria as $criterion)
                                                    <th>{{ $criterion->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Ideal Positif</td>
                                                @foreach($idealPositive as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Ideal Negatif</td>
                                                @foreach($idealNegative as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Jarak ke Solusi Ideal -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="jarakSolusiIdeal" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Aset</th>
                                                <th>Jarak Positif</th>
                                                <th>Jarak Negatif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($distances as $index => $distance)
                                                <tr>
                                                    <td>{{ $assets[$index]->name }}</td>
                                                    <td>{{ $distance['positive'] }}</td>
                                                    <td>{{ $distance['negative'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Nilai Preferensi -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="nilaiPreferensi" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Aset</th>
                                                <th>Nilai Preferensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($preferences as $index => $preference)
                                                <tr>
                                                    <td>{{ $assets[$index]->name }}</td>
                                                    <td>{{ $preference }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Ranking Aset -->
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="rankingAset" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Kode</th>
                                                <th>Aset</th>
                                                <th>Nilai Preferensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $rank = 1; @endphp
                                            @foreach($rankedAssets as $index => $rankedAsset)
                                                <tr>
                                                    <td>{{ $rank++ }}</td>
                                                    <td>A{{ $index + 1 }}</td>
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
        <script src="{{ asset('/js/data/process.js') }}"></script>
    @endpush

    <x-footer></x-footer>
</x-layout-dashboard>