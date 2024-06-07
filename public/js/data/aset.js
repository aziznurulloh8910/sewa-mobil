$(document).ready(function() {

    function formatIDR(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }


    var table = $('#dataAset').DataTable({
        ajax: {
            url: "http://localhost:8000/aset-data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "name" },
            { data: "registration_number" },
            { data: "asset_code" },
            { data: "location" },
            { data: "quantity" },
            { data: "acquisition_cost",
                render: function(data, type, row) {
                    return formatIDR(data);
                }
            },
            { data: "recorded_value",
                render: function(data, type, row) {
                    return formatIDR(data);
                }
            },
            { data: "condition" },
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
                                '<a href="javascript:;" class="dropdown-item">' +
                                    feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Details</a>' +
                                '<a href="javascript:;" class="dropdown-item">' +
                                feather.icons['archive'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Archive</a>' +
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
                targets: -2,
                render: function(data, type, full, meta) {
                    var conditionNumber = full['condition'];
                    var condition = {
                        1: { title: 'Tidak Ada', class: ' badge-light-danger' },
                        2: { title: 'Rusak Berat', class: 'badge-light-warning' },
                        3: { title: 'Rusak Ringan', class: ' badge-light-secondary' },
                        4: { title: 'Baik', class: ' badge-light-success' },
                    };
                    if (typeof condition[conditionNumber] === 'undefined') {
                        return data;
                    }
                    return (
                        '<span class="badge rounded-pill ' +
                        condition[conditionNumber].class +
                        '">' +
                        condition[conditionNumber].title +
                        '</span>'
                    );
                }
            },
        ],
        order: [[0, 'desc']],
        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                buttons: [
                    {
                        extend: 'print',
                        text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [1, 2, 3, 4, 5] }
                    }
                ],
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function() {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
            },
            {
                text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Record',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#ModalFormAset'
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
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
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
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.head-label').html('<h3 class="mb-0">Data Aset</h3>');

    // Function to clear the form
    function clearForm() {
        $('#assetForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#assetForm').attr('action', 'http://localhost:8000/aset/store');
    }

    // Handle form submission
    $('#assetForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.ajax({
            url: actionUrl,
            method: 'POST', // Always POST because _method will override
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Clear form fields
                    clearForm();

                    $('#ModalFormAset').modal('hide');
                    $('#dataAset').DataTable().ajax.reload();
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

    // Edit asset
    $('#dataAset').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        // Get asset data
        $.ajax({
            url: 'http://localhost:8000/aset/' + id,
            method: 'GET',
            success: function(response) {
                // Populate modal fields
                $('#assetForm').attr('action', 'http://localhost:8000/aset/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#asset_name').val(response.name);
                $('#asset_code').val(response.asset_code);
                $('#registration_number').val(response.registration_number);
                $('#location').val(response.location);
                $('#brand_type').val(response.brand_type);
                $('#procurement_year').val(response.procurement_year);
                $('#quantity').val(response.quantity);
                $('#acquisition_cost').val(response.acquisition_cost);
                $('#condition').val(response.condition);
                $('#description').val(response.description);

                // Show modal
                $('#ModalFormAset').modal('show');
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengambil data aset'
                });
            }
        });
    });

    // Clear form when modal is closed
    $('#ModalFormAset').on('hidden.bs.modal', function () {
        clearForm();
    });

    // Function to delete asset
    $('#dataAset').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data aset ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'http://localhost:8000/aset/delete/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            'Dihapus!',
                            response.success,
                            'success'
                        );

                        // Reload table data
                        $('#dataAset').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire(
                            'Gagal!',
                            'Data aset gagal dihapus.',
                            'error'
                        );
                    }
                });
            }
        });
    });

});
