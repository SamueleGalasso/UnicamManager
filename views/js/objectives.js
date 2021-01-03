/*=============================================
Objectives Table dynamic load
=============================================*/
$('.objectivesTable').DataTable({
    "ajax": "ajax/datatable-objectives.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true
});

/*=============================================
view objective details
=============================================*/

$(".objectivesTable").on("click", ".btnViewObjective", function () {
    const idObjective = $(this).attr("idObjective");
    console.log(idObjective);
    window.location = "objectives?id=" + idObjective;
})

/*=============================================
DELETE OBJECTIVE
=============================================*/

$(".objectivesTable").on("click", ".btnDeleteObjective", function () {
    const idObjective = $(this).attr("idObjective");
    swal({
        title: 'Sei sicuro di voler eliminare questa azione organizzativa?',
        text: "Se non lo sei puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancella',
        confirmButtonText: 'Si, elimina azione!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=objectives&idObjective=" + idObjective;
        }
    })
})