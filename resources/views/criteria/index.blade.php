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
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="dataCriteria" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Kriteria</th>
                                                <th>Kode Kriteria</th>
                                                <th>Atribut</th>
                                                <th>Bobot</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade text-start" id="ModalFormCriteria" tabindex="-1" aria-labelledby="ModalFormCriteriaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormCriteriaLabel">Form Data Kriteria</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="criteriaForm" action="{{ route('criteria.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Nama Kriteria</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Nama Kriteria" name="name" id="criteria_name" class="form-control" />
                                                </div>
                                                <label>Kode Kriteria</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Kode Kriteria" name="criteria_code" id="criteria_code" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="attribute">Atribut</label>
                                                <div class="mb-1">
                                                    <select class="form-select" name="attribute" id="attribute">
                                                        <option selected>-- Pilih Atribut --</option>
                                                        <option value="benefit">Benefit</option>
                                                        <option value="cost">Cost</option>
                                                    </select>
                                                </div>
                                                <label>Bobot</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Bobot" name="weight" id="weight" class="form-control" />
                                                </div>
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
            <!-- Basic Tables end -->
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>

    @push('data')
        <script src="{{ asset('/js/data/criteria.js') }}"></script>
    @endpush
</x-layout-dashboard>
