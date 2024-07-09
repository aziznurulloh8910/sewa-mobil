$(document).ready(function() {

    var table = $('#dataCriteria').DataTable({
        ajax: {
            url: "http://localhost:8000/criteria/data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "name" },
            { data: "criteria_code" },
            { data: "attribute" },
            { data: "weight" },
            { data: "" },
        ],
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full, meta) {
                    return (
                        '<div class="d-inline-flex">' +
                            '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                                '<a href="javascript:;" class="dropdown-item details-record" data-id="' + full['id'] + '">' +
                                    feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" class="dropdown-item delete-record" data-id="' + full['id'] + '">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a>' +
                            '</div>' +
                        '</div>' +
                        '<a href="javascript:;" class="item-edit" data-id="' + full['id'] + '">' +
                        feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                        '</a>'
                    );
                }
            },
            {
                targets: -3,
                render: function(data, type, full, meta) {
                    var attributeNumber = full['attribute'];
                    var attribute = {
                        "cost": { title: 'Cost', class: ' badge-light-warning' },
                        "benefit": { title: 'Benefit', class: 'badge-light-success' },
                    };
                    if (typeof attribute[attributeNumber] === 'undefined') {
                        return data;
                    }
                    return (
                        '<span class="badge rounded-pill ' +
                        attribute[attributeNumber].class +
                        '">' +
                        attribute[attributeNumber].title +
                        '</span>'
                    );
                }
            },
        ],
        order: [[1, 'asc']],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25],
        buttons: [
            {
                text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Record',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#ModalFormCriteria'
                },
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details of ' + data['name'];
                    }
                }),
                type: 'column',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return col.title !== ''
                            ? '<tr data-dt-row="' +
                                col.rowIdx +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                            : '';
                        }).join('');

                        return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                    }
            }
        },
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.head-label').html('<h3 class="mb-0">Data Kriteria</h3>');

    // Handle form submission
    $('#criteriaForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Add New Criteria Successful',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Clear form fields
                    clearForm();

                    $('#ModalFormCriteria').modal('hide');
                    $('#dataCriteria').DataTable().ajax.reload();
                }
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                let errorText = '';
                for (let key in errors) {
                    errorText += errors[key] + '<br>';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: errorText
                });
            }
        });
    });

    // Fungsi untuk membersihkan form
    function clearForm() {
        $('#criteriaForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#criteriaForm').attr('action', 'http://localhost:8000/criteria/store');
    }

    // Event listener untuk menampilkan modal form criteria
    $('.create-new').on('click', function() {
        // Generate kode kriteria baru
        var lastCode = getLastCriteriaCode();
        var newCode = generateNextCriteriaCode(lastCode);

        // Set nilai kode kriteria pada form
        $('#criteria_code').val(newCode);

        // Show modal
        $('#ModalFormCriteria').modal('show');
    });

    // Fungsi untuk mendapatkan kode kriteria terakhir dari tabel
    function getLastCriteriaCode() {
        var lastCode = '';
        var data = table.rows().data();

        // Loop melalui setiap data untuk mendapatkan kode kriteria terakhir
        data.each(function(rowData) {
            var criteriaCode = rowData.criteria_code;
            var codeNumber = parseInt(criteriaCode.substring(1)); // Mengambil angka setelah huruf C
            if (codeNumber && (criteriaCode.startsWith('C') && (criteriaCode.length === 2))) {
                if (codeNumber > lastCode) {
                    lastCode = codeNumber;
                }
            }
        });

        return lastCode;
    }

    // Fungsi untuk menghasilkan kode kriteria berikutnya
    function generateNextCriteriaCode(lastCode) {
        // Menambahkan 1 ke angka terakhir
        var nextCodeNumber = lastCode + 1;
        return 'C' + nextCodeNumber;
    }

    // Edit criteria
    $('#dataCriteria').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        // Get criteria data
        $.ajax({
            url: 'http://localhost:8000/criteria/' + id,
            method: 'GET',
            success: function(response) {
                // Populate modal fields
                $('#criteriaForm').attr('action', 'http://localhost:8000/criteria/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#criteria_name').val(response.name);
                $('#criteria_code').val(response.criteria_code);
                $('#attribute').val(response.attribute);
                $('#weight').val(response.weight);

                // Show modal
                $('#ModalFormCriteria').modal('show');
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get criteria data'
                });
            }
        });
    });

    // Clear form when modal is closed
    $('#ModalFormCriteria').on('hidden.bs.modal', function () {
        clearForm();
    });


    function getAttributeText(attribute) {
        switch (attribute) {
            case "cost":
                return '<span class="badge badge-light-warning">Cost</span>';
            case "benefit":
                return '<span class="badge badge-light-success">Benefit</span>';
            default:
                return '<span class="badge badge-light">Unknown</span>';
        }
    }

    // Show criteria details in Swal.fire
    $('#dataCriteria').on('click', '.details-record', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'http://localhost:8000/criteria/' + id,
            method: 'GET',
            success: function(response) {
                var criteriaDetails = `
                    <div class="row mx-1">
                        <div class="col-md-5">
                            <p><strong>Nama Kriteria</strong></p>
                        </div>
                        <div class="col-md-7">
                            <p>: ${response.name}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-5">
                            <p><strong>Kode Kriteria</strong></p>
                        </div>
                        <div class="col-md-7">
                            <p>: ${response.criteria_code}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-5">
                            <p><strong>Atribut</strong></p>
                        </div>
                        <div class="col-md-7">
                            <p>: ${getAttributeText(response.attribute)}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-5">
                            <p><strong>Bobot</strong></p>
                        </div>
                        <div class="col-md-7">
                            <p>: ${response.weight}</p>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: 'Informasi Detail Kriteria',
                    html: '<div style="text-align: left;">' + criteriaDetails + '</div>',
                    width: '500px',
                    confirmButtonText: 'Back to table',
                });
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get criteria data'
                });
            }
        });
    });

    // Function to delete criteria
    $('#dataCriteria').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "The data criteria will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'http://localhost:8000/criteria/delete/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        );

                        // Reload table data
                        $('#dataCriteria').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'Data criteria failed to delete.',
                            'error'
                        );
                    }
                });
            }
        });
    });

});
