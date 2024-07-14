$(document).ready(function() {
    var table = $('#rankingAset').DataTable({
        ajax: {
            url: "http://localhost:8000/ranking/data-table",
            dataSrc: function(json) {
                return Object.values(json.data);
            }
        },
        columns: [
            { data: "rank" },
            { data: "asset_code" },
            { data: "asset_name" },
            { data: "preference_value" },
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
                                '<a href="javascript:;" class="dropdown-item maintain-asset" data-id="' + full['id'] + '">' +
                                    feather.icons['tool'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Maintain</a>' +
                                '<a href="javascript:;" class="dropdown-item delete-asset" data-id="' + full['id'] + '">' +
                                feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                                'Delete</a>' +
                            '</div>' +
                        '</div>'
                    );
                }
            }
        ],
        order: [[0, 'asc']],
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
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    }
                ],
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary');
                    $(node).parent().removeClass('btn-group');
                    setTimeout(function() {
                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                    }, 50);
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return `Details of ${data['asset_name']}`;
                    }
                }),
                type: 'column',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col) {
                        return col.title !== ''
                            ? `<tr data-dt-row="${col.rowIdx}" data-dt-column="${col.columnIndex}">` +
                                `<td>${col.title}:</td> ` +
                                `<td>${col.data}</td>` +
                                `</tr>`
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/>').append(`<tbody>${data}</tbody>`) : false;
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

    var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Pastikan token CSRF tersedia di meta tag

    $('div.head-label').html('<h3 class="mb-0">Hasil Perankingan Aset</h3>');

    $('#rankingAset').on('click', '.delete-asset', function() {
        var assetId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary', 
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/assets/' + assetId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF di header
                    },
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'The asset has been deleted.',
                            'success'
                        ).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting asset:', error);
                        Swal.fire(
                            'Failed!',
                            'An error occurred while deleting the asset.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#rankingAset').on('click', '.maintain-asset', function() {
        var assetId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This asset will be marked for maintenance!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, mark it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/assets/maintain/' + assetId,
                    type: 'POST',
                    success: function(result) {
                        Swal.fire(
                            'Success!',
                            'The asset has been marked for maintenance.',
                            'success'
                        ).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error maintaining asset:', error);
                        Swal.fire(
                            'Failed!',
                            'An error occurred while marking the asset for maintenance.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});