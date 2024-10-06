$(document).ready(function() {

    function formatIDR(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    var appUrl = "http://localhost:8000";

    var table = $('#dataRental').DataTable({
        ajax: {
            url: appUrl + "/rentals/data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "user.name" },
            { data: "car.model" },
            { data: "start_date" },
            { data: "end_date" },
            { data: "total_days" },
            { data: "total_cost",
                render: function(data, type, row) {
                    return formatIDR(data);
                }
            },
            { data: "status" },
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
                targets: -2,
                render: function(data, type, full, meta) {
                    var statusNumber = full['status'];
                    var status = {
                        'active': { title: 'Active', class: 'badge-light-success' },
                        'returned': { title: 'Returned', class: 'badge-light-danger' },
                    };
                    if (typeof status[statusNumber] === 'undefined') {
                        return data;
                    }
                    return (
                        '<span class="badge rounded-pill ' +
                        status[statusNumber].class +
                        '">' +
                        status[statusNumber].title +
                        '</span>'
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
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
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
                    'data-bs-target': '#ModalFormRental'
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
                        return 'Details of ' + data['user.name'];
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


    $('div.head-label').html('<h3 class="mb-0">Data Rental</h3>');

    // Calculate total days
    $('#start_date, #end_date').on('change', function() {
        var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());
        if (startDate && endDate && endDate >= startDate) {
            var timeDiff = Math.abs(endDate - startDate);
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            $('#total_days').val(diffDays);
        } else {
            $('#total_days').val('');
        }
    });

    // Calculate total cost
    $('#start_date, #end_date, #car_id').on('change', function() {
        var startDate = new Date($('#start_date').val());
        var endDate = new Date($('#end_date').val());
        var rentalRate = $('#car_id option:selected').data('rental-rate');
        
        if (startDate && endDate && endDate >= startDate && rentalRate) {
            var timeDiff = Math.abs(endDate - startDate);
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            var totalCost = diffDays * rentalRate;
            $('#total_cost').val(totalCost);
        } else {
            $('#total_cost').val('');
        }
    });

    var totalCostInput = document.getElementById('total_cost');

    function formatToIDR(number) {
        var numberString = number.toString();
        var split = numberString.split('.');
        var rupiah = split[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        rupiah = 'Rp ' + rupiah + (split[1] ? ',' + split[1] : '');

        return rupiah;
    }

    totalCostInput.addEventListener('input', function(e) {
        var value = e.target.value;
        value = value.replace(/[^,\d]/g, '');
        e.target.value = formatToIDR(value);
    });

    // Set start_date to today's date
    var today = new Date().toISOString().split('T')[0];
    $('#start_date').val(today);

    // Function to clear the form
    function clearForm() {
        $('#rentalForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#rentalForm').attr('action', appUrl + '/rentals/store');
    }

    // Handle form submission
    $('#rentalForm').on('submit', function(e) {
        e.preventDefault();

        // Convert total_cost back to number
        var totalCostInput = $('#total_cost');
        var costValue = totalCostInput.val().replace(/[^0-9]/g, '');
        totalCostInput.val(costValue);

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
                        title: 'Successful',
                    });

                    // Clear form fields
                    clearForm();

                    $('#ModalFormRental').modal('hide');
                    $('#dataRental').DataTable().ajax.reload();
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
                    title: 'Failed',
                    html: errorText
                });
            }
        });
    });

    // Edit rental
    $('#dataRental').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        // Get rental data
        $.ajax({
            url: appUrl + '/rentals/' + id,
            method: 'GET',
            success: function(response) {
                // Populate modal fields
                $('#rentalForm').attr('action', appUrl + '/rentals/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#user_id').val(response.user_id);
                $('#car_id').val(response.car_id);
                $('#start_date').val(response.start_date);
                $('#end_date').val(response.end_date);
                $('#total_days').val(response.total_days);
                $('#total_cost').val(response.total_cost);
                $('#status').val(response.status);
                // Show modal
                $('#ModalFormRental').modal('show');
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get rental data'
                });
            }
        });
    });

    // Clear form when modal is closed
    $('#ModalFormRental').on('hidden.bs.modal', function () {
        clearForm();
    });

    // Function to delete rental
    $('#dataRental').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "The rental data will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: appUrl + '/rentals/delete/' + id,
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
                        $('#dataRental').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'Rental failed to delete.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Show rental details in Swal.fire
    $('#dataRental').on('click', '.details-record', function() {
        var id = $(this).data('id');

        $.ajax({
            url: appUrl + '/rentals/' + id,
            method: 'GET',
            success: function(response) {
                var rentalDetails = `
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>User</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.user.name}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Car</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.car.model}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Start Date</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.start_date}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>End Date</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.end_date}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Total Days</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.total_days}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Total Cost</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${formatIDR(response.total_cost)}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Status</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: <span class="badge rounded-pill ${response.status === 'active' ? 'badge-light-success' : response.status === 'inactive' ? 'badge-light-danger' : 'badge-light-warning'}">${response.status}</span></p>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: 'Informasi Detail Rental',
                    html: '<div style="text-align: left;">' + rentalDetails + '</div>',
                    width: '700px',
                    confirmButtonText: 'Back to table',
                });
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get rental data'
                });
            }
        });
    });

});