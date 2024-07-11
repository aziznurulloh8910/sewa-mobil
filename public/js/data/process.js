$(document).ready(function() {
    // Fungsi untuk mengurutkan secara natural
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "natural-asc": function(a, b) {
            return naturalSort(a, b);
        },
        "natural-desc": function(a, b) {
            return naturalSort(a, b) * -1;
        }
    });

    // Fungsi natural sort
    function naturalSort(a, b) {
        var re = /(\d+)|(\D+)/g, aMatch = String(a).match(re), bMatch = String(b).match(re);
        while (aMatch.length && bMatch.length) {
            var aSeg = aMatch.shift(), bSeg = bMatch.shift();
            var aNum = parseInt(aSeg, 10), bNum = parseInt(bSeg, 10);
            if (isNaN(aNum) || isNaN(bNum)) {
                if (aSeg > bSeg) return 1;
                if (aSeg < bSeg) return -1;
            } else {
                if (aNum > bNum) return 1;
                if (aNum < bNum) return -1;
            }
        }
        return aMatch.length - bMatch.length;
    }

    function initializeDataTable(selector, label) {
        let exportColumns = [0, 1, 2, 3, 4]; // Default columns

        // Menyesuaikan jumlah kolom berdasarkan selector
        if (selector === '#matriksKeputusan') {
            exportColumns = [0, 1, 2, 3, 4, 5];
        } else if (selector === '#jarakSolusiIdeal' || selector === '#nilaiPreferensi') {
            exportColumns = [0, 1, 2];
        } else if (selector === '#rankingAset') {
            exportColumns = [0, 1, 2, 3];
        }

        $(selector).DataTable({
            dom: `<"card-header border-bottom p-1"<"head-label ${label}-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>`,
            order: [[0, 'asc']],
            columnDefs: [
                { type: 'natural', targets: 0 } 
            ],
            displayLength: 5,
            lengthMenu: [5, 7, 10, 25],
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-2',
                    text: `${feather.icons['share'].toSvg({ class: 'font-small-4 me-50' })}Export`,
                    buttons: [
                        {
                            extend: 'print',
                            text: `${feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' })}Print`,
                            className: 'dropdown-item',
                            exportOptions: { columns: exportColumns },
                            title: label.replace(/([A-Z])/g, ' $1').trim()
                        },
                        {
                            extend: 'csv',
                            text: `${feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' })}Csv`,
                            className: 'dropdown-item',
                            exportOptions: { columns: exportColumns },
                            title: label.replace(/([A-Z])/g, ' $1').trim()
                        },
                        {
                            extend: 'excel',
                            text: `${feather.icons['file'].toSvg({ class: 'font-small-4 me-50' })}Excel`,
                            className: 'dropdown-item',
                            exportOptions: { columns: exportColumns },
                            title: label.replace(/([A-Z])/g, ' $1').trim()
                        },
                        {
                            extend: 'pdf',
                            text: `${feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' })}Pdf`,
                            className: 'dropdown-item',
                            exportOptions: { columns: exportColumns },
                            title: label.replace(/([A-Z])/g, ' $1').trim()
                        },
                        {
                            extend: 'copy',
                            text: `${feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' })}Copy`,
                            className: 'dropdown-item',
                            exportOptions: { columns: exportColumns },
                            title: label.replace(/([A-Z])/g, ' $1').trim()
                        }
                    ],
                    init: function(api, node) {
                        $(node).removeClass('btn-secondary');
                        $(node).parent().removeClass('btn-group');
                        setTimeout(function() {
                            $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                        }, 50);
                    }
                }
            ],
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });

        $(`div.${label}-label`).html(`<h3 class="mb-0">${label.replace(/([A-Z])/g, ' $1').trim()}</h3>`);
    }

    initializeDataTable('#matriksKeputusan', 'MatriksKeputusan');
    initializeDataTable('#matriksNormalisasi', 'MatriksNormalisasi');
    initializeDataTable('#matriksTerbobot', 'MatriksTerbobot');
    initializeDataTable('#solusiIdeal', 'SolusiIdeal');
    initializeDataTable('#jarakSolusiIdeal', 'JarakSolusiIdeal');
    initializeDataTable('#nilaiPreferensi', 'NilaiPreferensi');
    initializeDataTable('#rankingAset', 'RankingAset');
});