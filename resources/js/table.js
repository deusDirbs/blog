$(document).ready( function () {
    $('#selectedColumn').DataTable({
        "aaSorting": [],
        columnDefs: [{
            orderable: false,
            targets: 3
        }]
    });
    $('.dataTables_length').addClass('bs-select');
} );
