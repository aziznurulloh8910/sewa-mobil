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

            <!-- Maintenance table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="dataMaintenance" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Asset ID</th>
                                                <th>Tanggal Pemeliharaan</th>
                                                <th>Biaya</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
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
                <div class="modal fade text-start" id="ModalFormMaintenance" tabindex="-1" aria-labelledby="ModalFormMaintenanceLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormMaintenanceLabel">Form Data Pemeliharaan</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="maintenanceForm" action="{{ route('maintenance.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <label>Asset</label>
                                        <div class="mb-1">
                                            <select name="asset_id" id="asset_id" class="form-control select2">
                                                <option value="" disabled selected>Pilih Aset</option>
                                                @foreach($data as $asset)
                                                    <option value="{{ $asset->id }}">{{ $asset->asset_code }} - {{ $asset->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Tanggal Pemeliharaan</label>
                                        <div class="mb-1">
                                            <input type="date" name="maintenance_date" id="maintenance_date" class="form-control" value="{{ date('Y-m-d') }}" />
                                        </div>
                                        <label>Biaya</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Biaya" name="cost" id="cost" class="form-control" />
                                        </div>
                                        <label>Status</label>
                                        <div class="mb-1">
                                            <select class="form-select" name="status" id="status">
                                                <option selected>-- Pilih Status --</option>
                                                <option value="planned">Planned</option>
                                                <option value="in progress">In Progress</option>
                                                <option value="done">Done</option>
                                            </select>
                                        </div>
                                        <label>Keterangan</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Keterangan" name="description" id="description" class="form-control" />
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
            <!-- Maintenance Tables end -->
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>

    @push('data')
        <script src="{{ asset('/js/data/maintenance.js') }}"></script>
        <!-- Tambahkan CSS dan JS Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                display: none;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });

            $('#ModalFormMaintenance').on('shown.bs.modal', function () {
                $('#asset_id').select2({
                    dropdownParent: $('#ModalFormMaintenance')
                });
            });
        </script>
    @endpush
</x-layout-dashboard>