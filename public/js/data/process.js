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
        $(selector).DataTable({
            dom: `<"card-header border-bottom p-1"<"head-label ${label}-label">><"d-flex justify-content-between align-items-center m-1 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between m-1 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>`,
            order: [[0, 'asc']],
            columnDefs: [
                { type: 'natural', targets: 0 } 
            ],
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

    initializeDataTable('#matriksKeputusan', 'MatriksKeputusan');
    initializeDataTable('#matriksNormalisasi', 'MatriksNormalisasi');
    initializeDataTable('#matriksTerbobot', 'MatriksTerbobot');
    initializeDataTable('#solusiIdeal', 'SolusiIdeal');
    initializeDataTable('#jarakSolusiIdeal', 'JarakSolusiIdeal');
    initializeDataTable('#nilaiPreferensi', 'NilaiPreferensi');
    initializeDataTable('#rankingAset', 'RankingAset');
});