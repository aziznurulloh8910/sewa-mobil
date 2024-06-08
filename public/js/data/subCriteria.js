$(document).ready(function() {
    $('.create-new').on('click', function() {
        var criteriaId = $(this).data('criteria-id');
        $('#criteria_id').val(criteriaId);
        $('#ModalFormSubCriteria').modal('show');
    });

    $('#subCriteriaForm').on('submit', function(e) {
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
                        title: 'Add New SubCriteria Successful',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    clearForm();
                    $('#ModalFormSubCriteria').modal('hide');
                    location.reload();
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

    $('.item-edit').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'subcriteria/' + id,
            method: 'GET',
            success: function(response) {
                $('#subCriteriaForm').attr('action', 'subcriteria/update/' + id);
                $('input[name="_method"]').val('PUT');
                $('#criteria_id').val(response.criteria_id);
                $('#sub_criteria_name').val(response.name);
                $('#score').val(response.score);

                $('#ModalFormSubCriteria').modal('show');
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to get subcriteria data'
                });
            }
        });
    });

    $('.item-delete').on('click', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'subcriteria/delete/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            location.reload();
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Failed to delete subcriteria'
                        });
                    }
                });
            }
        });
    });

    function clearForm() {
        $('#subCriteriaForm').attr('action', '{{ route("subcriteria.store") }}');
        $('input[name="_method"]').val('POST');
        $('#sub_criteria_name').val('');
        $('#score').val('');
    }
});
