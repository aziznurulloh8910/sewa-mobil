<x-layout-dashboard>
    <x-navbar></x-navbar>
    <x-sidebar></x-sidebar>

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-body">
            <section id="car-return">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pengembalian Mobil</h4>
                            </div>
                            <div class="card-body">
                                <form id="carReturnForm" action="{{ route('car-return.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="car_id">Nomor Plat Mobil</label>
                                            <select class="select2 form-select" id="car_id" name="car_id">
                                                <option value="" disabled selected>Pilih Nomor Plat Mobil</option>
                                                @foreach($cars as $car)
                                                    <option value="{{ $car->id }}">{{ $car->license_plate }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Kembalikan Mobil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <x-footer></x-footer>

    @push('data')
        <script src="{{ asset('/js/data/car_return.js') }}"></script>
    @endpush
</x-layout-dashboard>