$('.dipendente-infoTable').DataTable({
    "ajax": "ajax/datatable-dipendente-info.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true
});