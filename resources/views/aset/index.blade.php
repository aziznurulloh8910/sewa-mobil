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

            @if (session()->has('success'))
                <div class="alert alert-primary">
                {{ session('success') }}
                </div>
            @endif

            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <div class="table-responsive">
                                    <table id="dataAset" class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Asset Name </th>
                                                <th>Reg Num</th>
                                                <th>Asset Code</th>
                                                <th>Location</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Mount</th>
                                                <th>Condition</th>
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
                <div class="modal fade text-start" id="ModalFormAset" tabindex="-1" aria-labelledby="ModalFormAsetLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormAsetLabel">Form Data Aset</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="assetForm" action="{{ route('aset.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Nama Barang</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Nama Barang" name="name" id="asset_name" class="form-control" />
                                                </div>
                                                <label>Kode Barang</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Kode Barang" name="asset_code" id="asset_code" class="form-control" />
                                                </div>
                                                <label>Nomor Registrasi</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Nomor Registrasi" name="registration_number" id="registration_number" class="form-control" />
                                                </div>
                                                <label>Lokasi</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Lokasi" name="location" id="location" class="form-control" />
                                                </div>
                                                <label>Merk/Type</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Merk/Type" name="brand_type" id="brand_type" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Tahun Pengadaan</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Tahun Pengadaan" name="procurement_year" id="procurement_year" class="form-control" maxlength="4" pattern="\d{4}" />
                                                </div>
                                                <label>Jumlah Barang</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Jumlah Barang" name="quantity" id="quantity" class="form-control" />
                                                </div>
                                                <label>Harga Satuan</label>
                                                <div class="mb-1">
                                                    <input type="number" placeholder="Harga Satuan" name="acquisition_cost" id="acquisition_cost" class="form-control" />
                                                </div>
                                                <label for="condition">Kondisi</label>
                                                <div class="mb-1">
                                                    <select class="form-select" name="condition" id="condition">
                                                        <option selected>-- Pilih Kondisi --</option>
                                                        <option value="4">Baik</option>
                                                        <option value="3">Rusak Ringan</option>
                                                        <option value="2">Rusak Berat</option>
                                                        <option value="1">Tidak Ada</option>
                                                    </select>
                                                </div>
                                                <label>Keterangan</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Keterangan" name="description" id="description" class="form-control" />
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
        <script src="{{ asset('/js/data/aset.js') }}"></script>
    @endpush
</x-layout-dashboard>
