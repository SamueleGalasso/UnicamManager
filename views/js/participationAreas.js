/*=============================================
EDIT Contributo
=============================================*/
function showParticipationAreasEditModal(id) {
    const datum = new FormData();
    datum.append("id", id);
    console.log(id);
    $.ajax({
        url: "ajax/participantsAreas.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (result) {
            console.log(result);
            $('#editId').val(result[0]["id"]);
            $('#editIdPlan').val(result[0]["idPlan"]);
            $('#editBudget').val(result[0]["budget"]);
            $('#modalEditBudget').modal('show');
        }
    })
}