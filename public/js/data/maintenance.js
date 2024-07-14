$(document).ready(function() {

    function formatIDR(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    function parseIDR(formatted) {
        return parseInt(formatted.replace(/[^0-9]/g, ''), 10);
    }

    function clearForm() {
        $('#maintenanceForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#maintenanceForm').attr('action', 'http://localhost:8000/maintenance/store');
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
        $('#ModalFormMaintenance').modal('hide');
        $('#dataMaintenance').DataTable().ajax.reload();
    }

    var table = $('#dataMaintenance').DataTable({
        ajax: {
            url: "http://localhost:8000/maintenance/data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "asset.name" },
            { data: "maintenance_date" },
            { data: "cost",
                render: function(data) {
                    return formatIDR(data);
                }
            },
            { data: "status",
                render: function(data) {
                    let badgeClass = '';
                    if (data === 'done') {
                        badgeClass = 'badge-light-success';
                    } else if (data === 'in progress') {
                        badgeClass = 'badge-light-primary';
                    } else if (data === 'planned') {
                        badgeClass = 'badge-light-danger';
                    }
                    return `<span class="badge ${badgeClass}">${data}</span>`;
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
                    'data-bs-target': '#ModalFormMaintenance'
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

    $('div.head-label').html('<h3 class="mb-0">Maintenance Records</h3>');

    $('#maintenanceForm').on('submit', function(e) {
        e.preventDefault();

        // Convert formatted cost back to number
        let costInput = $('#cost');
        let costValue = parseIDR(costInput.val());
        costInput.val(costValue);

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
                    handleAjaxSuccess(response, 'Add New Maintenance Successful');
                }
            },
            error: handleAjaxError
        });
    });

    $('#dataMaintenance').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'http://localhost:8000/maintenance/' + id,
            method: 'GET',
            success: function(response) {
                $('#maintenanceForm').attr('action', 'http://localhost:8000/maintenance/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#asset_id').val(response.asset_id);
                $('#maintenance_date').val(response.maintenance_date);
                $('#cost').val(response.cost);
                $('#status').val(response.status);
                $('#description').val(response.description);

                $('#ModalFormMaintenance').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get maintenance data'
                });
            }
        });
    });

    $('#ModalFormMaintenance').on('hidden.bs.modal', clearForm);

    $('#dataMaintenance').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "The maintenance record will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'danger',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'http://localhost:8000/maintenance/delete/' + id,
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

                        $('#dataMaintenance').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire(
                            'Failed!',
                            'Maintenance record failed to delete.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#dataMaintenance').on('click', '.details-record', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'http://localhost:8000/maintenance/' + id,
            method: 'GET',
            success: function(response) {
                let badgeClass = '';
                if (response.status === 'done') {
                    badgeClass = 'badge-light-success';
                } else if (response.status === 'in progress') {
                    badgeClass = 'badge-light-primary';
                } else if (response.status === 'planned') {
                    badgeClass = 'badge-light-danger';
                }

                var maintenanceDetails = `
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
                            <p><strong>Maintenance Date</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.maintenance_date}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Cost</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${formatIDR(response.cost)}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Status</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: <span class="badge ${badgeClass}">${response.status}</span></p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Description</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.description}</p>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: 'Maintenance Details',
                    html: '<div style="text-align: left;">' + maintenanceDetails + '</div>',
                    width: '700px',
                    confirmButtonText: 'Back to table',
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get maintenance data'
                });
            }
        });
    });

    $('#asset_id').select2({
        dropdownParent: $('#ModalFormMaintenance')
    });

    $('#asset_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var cost = selectedOption.data('cost');
        var status = selectedOption.data('status');

        $('#cost').val(cost);
        $('#status').val(status);
    });

    $('#cost').on('input', function() {
        let value = $(this).val().replace(/[^,\d]/g, '');
        if (value) {
            $(this).val(formatIDR(value));
        }
    });
});