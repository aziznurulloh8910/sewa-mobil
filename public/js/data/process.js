$(document).ready(function() {
    var table = $('#matriksKeputusan').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label matriksKeputusan-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.matriksKeputusan-label').html('<h3 class="mb-0">Matriks Keputusan</h3>');
});

$(document).ready(function() {
    var table = $('#matriksNormalisasi').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label matriksNormalisasi-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.matriksNormalisasi-label').html('<h3 class="mb-0">Matriks Normalisasi</h3>');
});

$(document).ready(function() {
    var table = $('#matriksTerbobot').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label matriksTerbobot-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.matriksTerbobot-label').html('<h3 class="mb-0">Matriks Ternormalisasi Terbobot</h3>');
});

$(document).ready(function() {
    var table = $('#solusiIdeal').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label solusiIdeal-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.solusiIdeal-label').html('<h3 class="mb-0">Solusi Ideal</h3>');
});

$(document).ready(function() {
    var table = $('#jarakSolusiIdeal').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label jarakSolusiIdeal-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.jarakSolusiIdeal-label').html('<h3 class="mb-0">Jarak Solusi Ideal</h3>');
});

$(document).ready(function() {
    var table = $('#nilaiPreferensi').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label nilaiPreferensi-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.nilaiPreferensi-label').html('<h3 class="mb-0">Nilai Preferensi</h3>');
});

$(document).ready(function() {
    var table = $('#rankingAset').DataTable({
        dom: '<"card-header border-bottom p-1"<"head-label rankingAset-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        order: [[2, 'desc']],
        displayLength: 5,
        lengthMenu: [5, 7, 10, 25],
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        }
    });

    $('div.rankingAset-label').html('<h3 class="mb-0">Ranking Aset</h3>');
});