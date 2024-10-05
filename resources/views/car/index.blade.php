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
                                    <table id="dataCar" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Plat Nomor</th>
                                                <th>Harga Rental</th>
                                                <th>Availability</th>
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
                <div class="modal fade text-start" id="ModalFormCar" tabindex="-1" aria-labelledby="ModalFormCarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormCarLabel">Form Data Car</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="carForm" action="{{ route('car.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Brand</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Ex. Toyota" name="brand" id="brand" class="form-control" />
                                                </div>
                                                <label>Model</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Ex. Avanza" name="model" id="model" class="form-control" />
                                                </div>
                                                <label>Plat Nomor</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Plat Nomor" name="license_plate" id="license_plate" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Harga Rental</label>
                                                <div class="mb-1">
                                                    <input type="text" placeholder="Harga Rental" name="rental_rate" id="rental_rate" class="form-control" />
                                                </div>
                                                <label for="availability">Availability</label>
                                                <div class="mb-1">
                                                    <select class="form-select" name="availability" id="availability">
                                                        <option selected>-- Pilih Availability --</option>
                                                        <option value="1">Available</option>
                                                        <option value="0">Not Available</option>
                                                    </select>
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
        <script src="{{ asset('/js/data/car.js') }}"></script>
    @endpush
</x-layout-dashboard>
