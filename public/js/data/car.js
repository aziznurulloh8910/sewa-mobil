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

    var table = $('#dataCar').DataTable({
        ajax: {
            url: appUrl + "/cars/data-table",
            dataSrc: "data"
        },
        columns: [
            { data: "brand" },
            { data: "model" },
            { data: "license_plate" },
            { data: "rental_rate",
                render: function(data, type, row) {
                    return formatIDR(data);
                }
            },
            { data: "availability" },
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
                    var conditionNumber = full['availability'];
                    var condition = {
                        1: { title: 'Available', class: ' badge-light-success' },
                        0: { title: 'Not Available', class: 'badge-light-danger' },
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
                    'data-bs-target': '#ModalFormCar'
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

    $('div.head-label').html('<h3 class="mb-0">Data Car</h3>');

    var rentalInput = document.getElementById('rental_rate');

    function formatToIDR(number) {
        var numberString = number.toString();
        var split = numberString.split('.');
        var rupiah = split[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        rupiah = 'Rp ' + rupiah + (split[1] ? ',' + split[1] : '');

        return rupiah;
    }

    rentalInput.addEventListener('input', function(e) {
        var value = e.target.value;
        value = value.replace(/[^,\d]/g, '');
        e.target.value = formatToIDR(value);
    });

    // Function to clear the form
    function clearForm() {
        $('#carForm')[0].reset();
        $('input[name="_method"]').val('POST');
        $('#carForm').attr('action', appUrl + '/cars/store');
    }

    // Handle form submission
    $('#carForm').on('submit', function(e) {
        e.preventDefault();

        // Convert rental_rate back to number
        var rentalRateInput = $('#rental_rate');
        var rentalRateValue = rentalRateInput.val().replace(/[^0-9]/g, '');
        rentalRateInput.val(rentalRateValue);

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
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Clear form fields
                    clearForm();

                    $('#ModalFormCar').modal('hide');
                    $('#dataCar').DataTable().ajax.reload();
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

    // Edit car
    $('#dataCar').on('click', '.item-edit', function() {
        var id = $(this).data('id');

        // Get car data
        $.ajax({
            url: appUrl + '/cars/' + id,
            method: 'GET',
            success: function(response) {
                // Populate modal fields
                $('#carForm').attr('action', appUrl + '/cars/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#brand').val(response.brand);
                $('#model').val(response.model);
                $('#license_plate').val(response.license_plate);
                $('#rental_rate').val(response.rental_rate);
                $('#availability').val(response.availability);
                // Show modal
                $('#ModalFormCar').modal('show');
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get car data'
                });
            }
        });
    });

    // Clear form when modal is closed
    $('#ModalFormCar').on('hidden.bs.modal', function () {
        clearForm();
    });

    // Function to delete car
    $('#dataCar').on('click', '.delete-record', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "The data car will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'primary',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: appUrl + '/cars/delete/' + id,
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
                        $('#dataCar').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire(
                            'Failed!',
                            'car failed to delete.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    function getAvailablity(condition) {
        switch (condition) {
            case 1:
                return '<span class="badge badge-light-success">Available</span>';
            case 0:
                return '<span class="badge badge-light-danger">Not Available</span>';
            default:
                return '<span class="badge badge-light">Unknown</span>';
        }
    }

    // Show car details in Swal.fire
    $('#dataCar').on('click', '.details-record', function() {
        var id = $(this).data('id');

        $.ajax({
            url: appUrl + '/cars/' + id,
            method: 'GET',
            success: function(response) {
                var carDetails = `
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Brand</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.brand}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Model</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.model}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Plat Nomor</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.license_plate}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Lokasi</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.location}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Jumlah Barang</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${response.quantity}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>Harga Rental</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${formatIDR(response.rental_rate)}</p>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md-4">
                            <p><strong>availability</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>: ${getAvailablity(response.availability)}</p>
                        </div>
                    </div>
                `;
                Swal.fire({
                    title: 'Informasi Detail Car',
                    html: '<div style="text-align: left;">' + carDetails + '</div>',
                    width: '700px',
                    confirmButtonText: 'Back to table',
                });
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get car data'
                });
            }
        });
    });

});