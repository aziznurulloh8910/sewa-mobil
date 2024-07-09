$(document).ready(function() {
    function initializeDataTable(selector, label) {
        $(selector).DataTable({
            dom: `<"card-header border-bottom p-1"<"head-label ${label}-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>`,
            displayLength: 5,
            lengthMenu: [5, 7, 10, 25],
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });

        $(`div.${label}-label`).html(`<h3 class="mb-0">${label.replace(/([A-Z])/g, ' $1').trim()}</h3>`);
    }

    initializeDataTable('#matriksKeputusan', 'matriksKeputusan');
    initializeDataTable('#matriksNormalisasi', 'matriksNormalisasi');
    initializeDataTable('#matriksTerbobot', 'matriksTerbobot');
    initializeDataTable('#solusiIdeal', 'solusiIdeal');
    initializeDataTable('#jarakSolusiIdeal', 'jarakSolusiIdeal');
    initializeDataTable('#nilaiPreferensi', 'nilaiPreferensi');
    initializeDataTable('#rankingAset', 'rankingAset');
});