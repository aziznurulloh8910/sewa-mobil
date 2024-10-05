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
                                    <table id="dataRental" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Peminjam</th>
                                                <th>Mobil</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Total Hari</th>
                                                <th>Total Biaya</th>
                                                <th>Status</th>
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
                <div class="modal fade text-start" id="ModalFormRental" tabindex="-1" aria-labelledby="ModalFormRentalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="ModalFormRentalLabel">Form Data Rental</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="rentalForm" action="{{ route('rental.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Peminjam</label>
                                                <div class="mb-1">
                                                    <select name="user_id" id="user_id" class="form-select">
                                                        <option value="">-- Pilih User --</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label>Mobil</label>
                                                <div class="mb-1">
                                                    <select name="car_id" id="car_id" class="form-select">
                                                    <option value="">-- Pilih Mobil --</option>
                                                        @foreach($cars as $car)
                                                            <option value="{{ $car->id }}" data-rental-rate="{{ $car->rental_rate }}">{{ $car->model }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label>Tanggal Mulai</label>
                                                <div class="mb-1">
                                                    <input type="date" name="start_date" id="start_date" class="form-control" />
                                                </div>
                                                <label>Tanggal Selesai</label>
                                                <div class="mb-1">
                                                    <input type="date" name="end_date" id="end_date" class="form-control"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label>Total Hari</label>
                                                <div class="mb-1">
                                                    <input type="number" name="total_days" id="total_days" class="form-control" placeholder="Total Hari" />
                                                </div>
                                                <label>Total Biaya</label>
                                                <div class="mb-1">
                                                    <input type="text" name="total_cost" id="total_cost" class="form-control" placeholder="Total Biaya" />
                                                </div>
                                                <label>Status</label>
                                                <div class="mb-1">
                                                    <select name="status" id="status" class="form-select">
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="active">Active</option>
                                                        <option value="returned">Returned</option>
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
        <script src="{{ asset('/js/data/rental.js') }}"></script>
    @endpush
</x-layout-dashboard>
