/*=============================================
Objectives Table dynamic load
=============================================*/
$('.objectivesUniversitaTable').DataTable({
    "ajax": "ajax/datatable-objectivesUniversita.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true
});

/*=============================================
EDIT objective
=============================================*/

$(".objectivesUniversitaTable").on("click", ".btnEditObjectiveUniversita", function () {
    var idObjective = $(this).attr("idObjective");
    var datum = new FormData();
    datum.append("idObjective", idObjective);
    $.ajax({
        url: "ajax/objectivesUniversita.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (answer) {
            console.log(answer);
            $("#editTitleUniversita").val(answer["title"]);
            $("#editDescriptionUniversita").val(answer["description"]);
            $("#editWeightUniversita").val(answer["weight"]);
            $("#editPlansUniversita").val(answer["idPlan"]);
            $("#idObjectiveUniversita ").val(answer["id"]);
        }
    })
})

/*=============================================
DELETE OBJECTIVE
=============================================*/

$(".objectivesUniversitaTable").on("click", ".btnDeleteObjectiveUniversita", function () {
    const idObjective = $(this).attr("idObjective");
    swal({
        title: 'Sei sicuro di voler eliminare questo obiettivo?',
        text: "Se non lo sei puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancella',
        confirmButtonText: 'Si, elimina obiettivo!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=objectivesUniversita&idObjective=" + idObjective;
        }
    })
})