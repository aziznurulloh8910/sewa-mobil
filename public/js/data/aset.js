$(document).ready(function() {
    $('#dataAset').DataTable({
        ajax: {
            "url": "http://localhost:8000/aset-data-table",
            "dataSrc": "data"
        },
        columns: [
            { "data": "id" },
            { "data": "asset_code" },
            { "data": "location" },
            { "data": "quantity" },
            { "data": "acquisition_cost" },
            { "data": "condition" },
            { "data": "" },
        ],
        columnDefs: [
            {
                // Actions
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
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
                            '<a href="javascript:;" class="dropdown-item delete-record">' +
                            feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Delete</a>' +
                        '</div>' +
                    '</div>' +
                    '<a href="javascript:;" class="item-edit">' +
                    feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                    '</a>'
                    );
                }
            },
            {
                // Label
                targets: -2,
                render: function (data, type, full, meta) {
                    var $condition_number = full['condition'];
                    var $condition = {
                        1: { title: 'Tidak Ada', class: ' badge-light-danger' },
                        2: { title: 'Rusak Berat', class: 'badge-light-warning' },
                        3: { title: 'Rusak Ringan', class: ' badge-light-secondary' },
                        4: { title: 'Baik', class: ' badge-light-success' },
                    };
                    if (typeof $condition[$condition_number] === 'undefined') {
                        return data;
                    }
                    return (
                        '<span class="badge rounded-pill ' +
                        $condition[$condition_number].class +
                        '">' +
                        $condition[$condition_number].title +
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
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function () {
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
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
            }
        ],
        responsive: {
            details: {
            display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                var data = row.data();
                return 'Details of ' + data['name'];
                }
            }),
            type: 'column',
            renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
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

    $('#assetForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "http://localhost:8000/aset/store",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#ModalFormAset').modal('hide');
                    $('#dataAset').DataTable().ajax.reload();
                    alert(response.success);
                }
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                for (let key in errors) {
                    alert(errors[key]);
                }
            }
        });
    });

});
