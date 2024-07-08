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
                                <div class="table-responsive w-100">
                                    <table id="dataEvaluation" class="table table-bordered table-responsive w-100">
                                        <thead>
                                            <tr>
                                                <th>Nama Alternatif</th>
                                                <th>Kode</th>
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
                                <h4 class="modal-title" id="ModalFormEvaluationLabel">Form Data Penilaian</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="evaluationForm" action="{{ route('evaluation.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="asset_id" name="asset_id">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Kriteria 1</label>
                                            <div class="mb-1">
                                                <select class="form-select" name="criteria_1" id="criteria_1">
                                                    <option selected>-- select option ---</option>
                                                    <!-- Options will be populated dynamically -->
                                                </select>
                                            </div>
                                            <label>Kriteria 2</label>
                                            <div class="mb-1">
                                                <select class="form-select" name="criteria_2" id="criteria_2">
                                                    <option selected>-- select option ---</option>
                                                    <!-- Options will be populated dynamically -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Kriteria 3</label>
                                            <div class="mb-1">
                                                <select class="form-select" name="criteria_3" id="criteria_3">
                                                    <option selected>-- select option ---</option>
                                                    <!-- Options will be populated dynamically -->
                                                </select>
                                            </div>
                                            <label>Kriteria 4</label>
                                            <div class="mb-1">
                                                <select class="form-select" name="criteria_4" id="criteria_4">
                                                    <option selected>-- select option ---</option>
                                                    <!-- Options will be populated dynamically -->
                                                </select>
                                            </div>
                                        </div>
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