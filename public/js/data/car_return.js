$(document).ready(function() {
    $('#carReturnForm').on('submit', function(e) {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.success
                });

                $('#carReturnForm')[0].reset();
            },
            error: function(response) {
                let errorText = response.responseJSON.error || 'Terjadi kesalahan.';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorText
                });
            }
        });
    });
});