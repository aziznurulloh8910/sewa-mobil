$(document).ready(function() {
    var criteria = $('#dataEvaluation').data('criteria');

    var columns = [
        { data: "name" },
        { 
            data: "id",
            render: function(data, type, full, meta) {
                return "A" + data; // Menambahkan prefix "A" pada id
            }
        },
    ];

    criteria.forEach(function(item) {
        columns.push({ 
            data: "criteria_" + item.id,
            render: function(data, type, full, meta) {
                return data !== null ? data : '-'; // Menampilkan skor subkriteria
            }
        });
    });

    columns.push({ data: " " });

    var table = $('#dataEvaluation').DataTable({
        ajax: {
            url: "http://localhost:8000/evaluation-data-table",
            dataSrc: function(json) {
                // console.log(json.data); // Log data untuk debugging
                return json.data;
            }
        },
        columns: columns,
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full, meta) {
                    if (full['is_evaluated']) {
                        return (
                            '<a href="javascript:;" class="edit-nilai badge badge-light-success" data-bs-toggle="modal" data-bs-target="#ModalFormEvaluation" data-id="' + full['id'] + '">' +
                                feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                            ' Edit</a>'
                        );
                    } else {
                        return (
                            '<a href="javascript:;" class="input-nilai badge badge-light-primary" data-bs-toggle="modal" data-bs-target="#ModalFormEvaluation" data-id="' + full['id'] + '">' +
                                feather.icons['plus-square'].toSvg({ class: 'font-small-4' }) +
                            ' Input</a>'
                        );
                    }
                }
            }
        ],
        autoWidth: false, 
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
                        exportOptions: { columns: [0, 1] }
                    },
                    {
                        extend: 'csv',
                        text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1] }
                    },
                    {
                        extend: 'excel',
                        text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1] }
                    },
                    {
                        extend: 'pdf',
                        text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1] }
                    },
                    {
                        extend: 'copy',
                        text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                        className: 'dropdown-item',
                        exportOptions: { columns: [0, 1] }
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

    $('div.head-label').html('<h3 class="mb-0">Tabel Penilaian</h3>');

    // Function to clear the form
    function clearForm() {
        $('#evaluationForm')[0].reset();
        $('#evaluationForm').attr('action', 'http://localhost:8000/evaluation/store');
    }

    // Handle form submission
    $('#evaluationForm').on('submit', function(e) {
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
                        title: 'Penilaian Berhasil',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Clear form fields
                    clearForm();

                    $('#ModalFormEvaluation').modal('hide');
                    $('#dataEvaluation').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
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

    // Show modal and populate form fields
    $('#dataEvaluation').on('click', '.input-nilai', function() {
        var id = $(this).data('id');
        $('#asset_id').val(id);

        $('#ModalFormEvaluation').modal('show');
    });

    // Clear form when modal is closed
    $('#ModalFormEvaluation').on('hidden.bs.modal', function () {
        clearForm();
    });

});