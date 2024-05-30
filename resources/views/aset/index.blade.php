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
                            <div class="table-responsive">
                                <table id="dataAset" class="datatables-basic table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Asset Code</th>
                                            <th>Location</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Condition</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal to add new record -->
                <div class="modal modal-slide-in fade" id="modals-slide-in">
                    <div class="modal-dialog sidebar-sm">
                        <form class="add-new-record modal-content pt-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                            <input
                                type="text"
                                class="form-control dt-full-name"
                                id="basic-icon-default-fullname"
                                placeholder="John Doe"
                                aria-label="John Doe"
                            />
                            </div>
                            <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-post">Post</label>
                            <input
                                type="text"
                                id="basic-icon-default-post"
                                class="form-control dt-post"
                                placeholder="Web Developer"
                                aria-label="Web Developer"
                            />
                            </div>
                            <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <input
                                type="text"
                                id="basic-icon-default-email"
                                class="form-control dt-email"
                                placeholder="john.doe@example.com"
                                aria-label="john.doe@example.com"
                            />
                            <small class="form-text"> You can use letters, numbers & periods </small>
                            </div>
                            <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-date">Joining Date</label>
                            <input
                                type="text"
                                class="form-control dt-date"
                                id="basic-icon-default-date"
                                placeholder="MM/DD/YYYY"
                                aria-label="MM/DD/YYYY"
                            />
                            </div>
                            <div class="mb-4">
                            <label class="form-label" for="basic-icon-default-salary">Salary</label>
                            <input
                                type="text"
                                id="basic-icon-default-salary"
                                class="form-control dt-salary"
                                placeholder="$12000"
                                aria-label="$12000"
                            />
                            </div>
                            <button type="button" class="btn btn-primary data-submit me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- Modal -->
                <div
                    class="modal fade text-start"
                    id="inlineForm"
                    tabindex="-1"
                    aria-labelledby="ModalFormAset"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title" id="ModalFormAset">Form Data Aset</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="#">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label>Nama Barang</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Nama Barang" name="asset_name" id="asset_name" class="form-control" />
                                        </div>
                                        <label>Kode Barang</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Kode Barang" name="asset_code" id="asset_code" class="form-control" />
                                        </div>
                                        <label>Nomor Registrasi</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Nomor Registrasi" name="registration_number" id="registration_number" class="form-control" />
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
                                            <input type="text" placeholder="Tahun Pengadaan" name="year_procurment" id="year_procurment" class="form-control" />
                                        </div>
                                        <label>Jumlah Barang</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Jumlah Barang" name="quantity" id="quantity" class="form-control" />
                                        </div>
                                        <label>Harga Satuan</label>
                                        <div class="mb-1">
                                            <input type="text" placeholder="Harga Satuan" name="registration_number" id="registration_number" class="form-control" />
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
                                            <input type="text" placeholder="Keterangan" id="description" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                        </form>
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

    <x-footer></x-footer>



    @push('data')
        <script src="{{ asset('/js/data/aset.js') }}"></script>
    @endpush
</x-layout-dashboard>
