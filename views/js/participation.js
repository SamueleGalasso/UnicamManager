/*=============================================
EDIT Contributo
=============================================*/
function showParticipationEditModal(id) {
    const datum = new FormData();
    datum.append("id", id);
    $.ajax({
        url: "ajax/participants.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (result) {
            console.log(result);
            $('#editPremialita').val(result[0]["premialita"]);
            $('#editId').val(result[0]["id"]);
            $('#editIdTarget').val(result[0]["idTarget"]);
            $('#editContributo').val(result[0]["contributo"]);
            $('#modalEditContributo').modal('show');
        }
    })
}