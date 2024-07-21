<!-- resources/views/subcriteria/index.blade.php -->

<x-layout-dashboard>
    <x-navbar></x-navbar>
    <x-sidebar></x-sidebar>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-body">

            @foreach ($criterias as $criteria)
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Sub Kriteria for {{ $criteria->name }} ({{ $criteria->criteria_code }})</h4>
                                    <button class="btn btn-primary create-new" data-criteria-id="{{ $criteria->id }}">Add New Sub Kriteria</button>
                                </div>
                                <div class="card-datatable">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Sub Kriteria</th>
                                                    <th>Nilai</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($criteria->subCriteria as $subCriteria)
                                                    <tr>
                                                        <td>{{ $subCriteria->name }}</td>
                                                        <td>{{ $subCriteria->score }}</td>
                                                        <td>
                                                            <a href="javascript:;" class="item-edit" data-id="{{ $subCriteria->id }}"><i data-feather="edit"></i></a>
                                                            <a href="javascript:;" class="item-delete" data-id="{{ $subCriteria->id }}"><i data-feather="trash-2"></i></a>
                                                        </td>
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
            @endforeach

            <div class="modal fade text-start" id="ModalFormSubCriteria" tabindex="-1" aria-labelledby="ModalFormSubCriteriaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="ModalFormSubCriteriaLabel">Form Data Sub Kriteria</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="subCriteriaForm" action="{{ route('subcriteria.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="_method" name="_method" value="POST">
                            <input type="hidden" name="criteria_id" id="criteria_id">
                            <div class="modal-body">
                                <div class="mb-1">
                                    <label>Nama Sub Kriteria</label>
                                    <input type="text" placeholder="Nama Sub Kriteria" name="name" id="sub_criteria_name" class="form-control" />
                                </div>
                                <div class="mb-1">
                                    <label>Nilai</label>
                                    <input type="number" placeholder="Nilai" name="score" id="score" class="form-control" />
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

        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>

    @push('data')
        <script src="{{ asset('/js/data/subCriteria.js') }}"></script>
    @endpush
</x-layout-dashboard>
