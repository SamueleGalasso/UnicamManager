/*=============================================
TARGETS Table dynamic load
=============================================*/
$('.targetsUniversitaTable').DataTable({
    "ajax": "ajax/datatable-targetsUniversita.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true
});


/*=============================================
DELETE target
=============================================*/

$(".targetsUniversitaTable").on("click", ".btnDeleteTargetUniversita", function () {
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
            window.location = "index.php?route=targetsUniversita&idTarget=" + idTarget;
        }
    })
})

/*=============================================
EDIT target
=============================================*/

$(".targetsUniversitaTable").on("click", ".btnEditTargetUniversita", function () {
    var idTarget = $(this).attr("idTarget");
    var datum = new FormData();
    datum.append("idTarget", idTarget);
    $.ajax({
        url: "ajax/targetsUniversita.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (answer) {
            $("#editName").val(answer["name"]);
            $("#editDescription").val(answer["description"]);
            $("#editWeight").val(answer["weight"]);
            $("#editObjective").val(answer["idObjectiveUniversita"]);
            $("#id").val(answer["id"]);
        }
    })
})

