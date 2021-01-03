/*=============================================
EDIT Area
=============================================*/

$(".tables").on("click", ".btnEditArea", function () {
    var idArea = $(this).attr("idArea");
    var datum = new FormData();
    datum.append("idArea", idArea);
    $.ajax({
        url: "ajax/areas.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (answer) {
            console.log(answer);
            $("#idArea").val(answer["id"]);
            $("#editName").val(answer["name"]);
            $("#editResponsabile").val(answer["idResponsabile"]);
        }
    })
})

/*=============================================
DELETE Area
=============================================*/
$(".tables").on("click", ".btnDeleteArea", function () {
    var idArea = $(this).attr("idArea");
    swal({
        title: 'Sei sicuro di voler eliminare questa Area?',
        text: "Se non sei sicuro puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Si, elimina Area!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=areas&idArea=" + idArea;
        }
    })
})