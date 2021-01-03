
/*=============================================
view plan details
=============================================*/

$(".tables").on("click", ".btnViewPlan", function () {
    const idPlan = $(this).attr("idPlan");
    window.location = "plans?id=" + idPlan;
})

/*=============================================
DELETE PLAN
=============================================*/
$(".tables").on("click", ".btnDeletePlan", function () {
    var idPlan = $(this).attr("idPlan");
    swal({
        title: 'Sei sicuro di voler eliminare questo Piano?',
        text: "Se non sei sicuro puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Si, elimina Piano!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=plans&idPlan=" + idPlan;
        }
    })
})
