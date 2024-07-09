$(document).ready(function() {
    var criteria = $('#dataEvaluation').data('criteria');
    var baseUrl = "http://localhost:8000";

    var columns = [
        { data: "name" },
        { 
            data: "id",
            render: function(data) {
                return `A${data}`; // Menambahkan prefix "A" pada id
            }
        },
    ];

    criteria.forEach(function(item) {
        columns.push({ 
            data: `criteria_${item.id}`,
            render: function(data) {
                return data !== null ? data : '-'; // Menampilkan skor subkriteria
            }
        });
    });

    columns.push({ data: " " });

    var table = $('#dataEvaluation').DataTable({
        ajax: {
            url: `${baseUrl}/evaluation/data-table`,
            dataSrc: function(json) {
                return json.data;
            }
        },
        columns: columns,
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full) {
                    if (full['is_evaluated']) {
                        return (
                            `<a href="javascript:;" class="edit-nilai badge badge-light-success" data-bs-toggle="modal" data-bs-target="#ModalFormEvaluation" data-id="${full['id']}">` +
                                feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                            ' Edit</a>'
                        );
                    } else {
                        return (
                            `<a href="javascript:;" class="input-nilai badge badge-light-primary" data-bs-toggle="modal" data-bs-target="#ModalFormEvaluation" data-id="${full['id']}">` +
                                feather.icons['plus-square'].toSvg({ class: 'font-small-4' }) +
                            ' Input</a>'
                        );
                    }
                }
            }
        ],
        autoWidth: false, 
        order: [[0, 'desc']],
        dom: '<"card-header border-bottom p-1"<"head-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
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
        $('#evaluationForm').attr('action', `${baseUrl}/evaluation/store`);
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

    // Show modal and populate form fields for edit
    $('#dataEvaluation').on('click', '.edit-nilai', function() {
        var id = $(this).data('id');
        $('#asset_id').val(id);

        $.ajax({
            url: `${baseUrl}/evaluation/${id}/edit`,
            method: 'GET',
            success: function(response) {
                $('#asset_id').val(response.asset.id);
                $('#evaluation_id').val(response.asset.id); // Assuming evaluation_id is same as asset_id

                response.criteria.forEach(function(item) {
                    var evaluation = response.evaluations[item.id];
                    if (evaluation) {
                        $('#criteria_' + item.id).val(evaluation.sub_criteria_id);
                    }
                });

                $('#ModalFormEvaluation').modal('show');
            }
        });
    });
});