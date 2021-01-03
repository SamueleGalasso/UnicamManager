/*=============================================
TARGETS Table dynamic load
=============================================*/
$('.targetsTable').DataTable({
    "ajax": "ajax/datatable-targets.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true
});

/*=============================================
DELETE target
=============================================*/

$(".targetsTable").on("click", ".btnDeleteTarget", function () {
    const idTarget = $(this).attr("idTarget");
    swal({
        title: 'Sei sicuro di voler eliminare questo target?',
        text: "Se non lo sei puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancella',
        confirmButtonText: 'Si, elimina Target!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=targets&idTarget=" + idTarget;
        }
    })
})

/*=============================================
view target details
=============================================*/

$(".targetsTable").on("click", ".btnViewTarget", function () {
    const idTarget = $(this).attr("idTarget");
    window.location = "targets?id=" + idTarget;
})

