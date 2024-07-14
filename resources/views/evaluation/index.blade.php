<x-layout-dashboard>
    <x-navbar></x-navbar>
    <x-sidebar></x-sidebar>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-body">

            <!-- Tabel Penilaian -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="dataEvaluation" class="table table-bordered" data-criteria="{{ json_encode($criteria) }}">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Kode Alternatif</th>
                                                @foreach($criteria as $item)
                                                    <th>{{ $item->criteria_code }}</th>
                                                @endforeach
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Form Penilaian -->
                <div class="modal fade text-start" id="ModalFormEvaluation" tabindex="-1" aria-labelledby="ModalFormEvaluationLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormEvaluationLabel">Form Data Penilaian <span class="assetNameAccord"> </span></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="evaluationForm" action="{{ route('evaluation.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="asset_id" name="asset_id" value="{{ old('asset_id') }}">
                                <input type="hidden" id="evaluation_id" name="evaluation_id" value="{{ old('evaluation_id') }}">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-border mb-2" id="assetAccordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingAssetDetails">
                                                        <button class="accordion-button collapsed bg-light-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAssetDetails" aria-expanded="false" aria-controls="collapseAssetDetails" style="font-size: small;">
                                                            Lihat Detail Data "<span class="assetNameAccord"></span>"
                                                        </button>
                                                    </h2>
                                                    <div id="collapseAssetDetails" class="accordion-collapse collapse" aria-labelledby="headingAssetDetails" data-bs-parent="#assetAccordion">
                                                        <div class="accordion-body table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Aset</th>
                                                                        <th>Harga</th>
                                                                        <th>Quantity</th>
                                                                        <th>Kondisi</th>
                                                                        <th>Tahun Perolehan</th>
                                                                        <th>Depresiasi</th>
                                                                        <th>Nilai Residu</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="assetNameAccord"></td>
                                                                        <td class="assetCostAccord"></td>
                                                                        <td class="assetQuantityAccord"></td>
                                                                        <td class="assetConditionAccord"></td>
                                                                        <td class="assetYearAccord"></td>
                                                                        <td class="assetDepreciationAccord"></td>
                                                                        <td class="assetResidualAccord"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($criteria as $item)
                                            <div class="col-md-6">
                                                <label>{{ $item->name }}</label>
                                                <div class="mb-1">
                                                    <select class="form-select" name="criteria[{{ $item->id }}]" id="criteria_{{ $item->id }}" data-id="{{ $item->id }}" value="{{ old('criteria.' . $item->id) }}">
                                                        <option value="" selected>-- select option ---</option>
                                                        @foreach($item->subCriteria as $sub)
                                                            <option value="{{ $sub->id }}" {{ old('criteria.' . $item->id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary data-submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>

    @push('data')
        <script src="{{ asset('/js/data/evaluation.js') }}"></script>
    @endpush
</x-layout-dashboard>