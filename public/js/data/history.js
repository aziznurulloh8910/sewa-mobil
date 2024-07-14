$(document).ready(function() {

    function formatIDR(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    function formatToIDR(number) {
        var numberString = number.toString();
        var split = numberString.split('.');
        var rupiah = split[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return 'Rp ' + rupiah + (split[1] ? ',' + split[1] : '');
    }

    function clearForm() {
        $('#historyForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#historyForm').attr('action', 'http://localhost:8000/deletion-history/store');
    }

    function handleAjaxError(response) {
        let errors = response.responseJSON.errors;
        let errorText = '';
        for (let key in errors) {
            errorText += errors[key] + '<br>';
        }

        Swal.fire({
            icon: 'error',
            title: 'Failed',
            html: errorText
        });
    }

    function handleAjaxSuccess(response, message) {
        Swal.fire({
            icon: 'success',
            title: message,
            text: response.success,
            timer: 2000,
            showConfirmButton: false
        });

        clearForm();
        $('#ModalFormHistory').modal('hide');
        $('#dataHistory').DataTable().ajax.reload();
    }

    var table = $('#dataHistory').DataTable({
        ajax: {
            url: "http://localhost:8000/deletion-history/data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "asset.name" },
            { data: "date_of_deletion" },
            { data: "residual_value",
                render: function(data) {
                    return formatIDR(data);
                }
            },
            { data: "description" },
            { data: "" },
        ],
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full) {
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
            }
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
                init: function(api, node) {
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
                    'data-bs-target': '#ModalFormHistory'
                },
                init: function(api, node) {
                    $(node).removeClass('btn-secondary');
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details of ' + data['user_id'];
                    }
                }),
                type: 'column',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col) {
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

    $('div.head-label').html('<h3 class="mb-0">History Penghapusan Aset</h3>');

    var residualValueInput = document.getElementById('residual_value');

    residualValueInput.addEventListener('input', function(e) {
        var value = e.target.value.replace(/[^,\d]/g, '');
        e.target.value = formatToIDR(value);
    });

    $('#historyForm').on('submit', function(e) {
        e.preventDefault();

        var residualValue = residualValueInput.value.replace(/[^,\d]/g, '');
        var hiddenInput = $('<input>', {
            type: 'hidden',
            name: 'residual_value',
            value: residualValue
        });
        $(this).append(hiddenInput);
        residualValueInput.value = residualValue;

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
                    handleAjaxSuccess(response, 'Add New History Successful');
                }
            },
            error: handleAjaxError
        });
    });

    $('#dataHistory').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'http://localhost:8000/deletion-history/' + id,
            method: 'GET',
            success: function(response) {
                $('#historyForm').attr('action', 'http://localhost:8000/deletion-history/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#user_id').val(response.user_id);
                $('#asset_id').val(response.asset_id);
                $('#date_of_deletion').val(response.date_of_deletion);
                $('#residual_value').val(response.residual_value);
                $('#description').val(response.description);

                $('#ModalFormHistory').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get history data'
                });
            }
        });
    });

    $('#ModalFormHistory').on('hidden.bs.modal', clearForm);

    $('#dataHistory').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "The history record will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'http://localhost:8000/deletion-history/delete/' + id,
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

                        $('#dataHistory').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire(
                            'Failed!',
                            'History record failed to delete.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#dataHistory').on('click', '.details-record', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'http://localhost:8000/deletion-history/' + id,
            method: 'GET',
            success: function(response) {
                var historyDetails = `
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>User ID</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.user_id}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Asset ID</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.asset_id}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Tanggal Penghapusan</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.date_of_deletion}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Nilai Sisa</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${formatIDR(response.residual_value)}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Deskripsi</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.description}</p>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: 'Informasi Detail History Penghapusan',
                    html: '<div style="text-align: left;">' + historyDetails + '</div>',
                    width: '700px',
                    confirmButtonText: 'Back to table',
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get history data'
                });
            }
        });
    });

});