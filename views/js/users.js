/*=============================================
UPLOADING USER PICTURE
=============================================*/

$('#checkbox-value').text($('#checkbox1').val());
$("#checkbox1").on('change', function () {
    if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
    } else {
        $(this).attr('value', 'false');
    }
    $('#checkbox-value').text($('#checkbox1').val());
});
$(".newPics").change(function () {
    var newImage = this.files[0];
    /*===============================================
    =            validating image format            =
    ===============================================*/
    if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png") {
        $(".newPics").val("");
        swal({
            type: "error",
            title: "Error uploading image",
            text: "Image has to be JPEG or PNG!",
            showConfirmButton: true,
            confirmButtonText: "Close"
        });
    } else if (newImage["size"] > 2000000) {
        $(".newPics").val("");
        swal({
            type: "error",
            title: "Error uploading image",
            text: "Image too big. It has to be less than 2Mb!",
            showConfirmButton: true,
            confirmButtonText: "Close"
        });
    } else {
        var imgData = new FileReader;
        imgData.readAsDataURL(newImage);
        $(imgData).on("load", function (event) {
            var routeImg = event.target.result;
            $(".preview").attr("src", routeImg);
        });
    }
})


/*=============================================
EDITING USER PICTURE
=============================================*/
$(document).on("click", ".btnEditUser", function () {
    var idUser = $(this).attr("idUser");
    var data = new FormData();
    data.append("idUser", idUser);
    $.ajax({
        url: "ajax/users.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (answer) {
            console.log(answer);
            $("#EditName").val(answer["name"]);
            $("#EditUser").val(answer["user"]);
            $("#EditProfile").val(answer["profile"]);
            $("#currentPasswd").val(answer["password"]);
            $("#editArea").val(answer["idArea"]);
            $("#responsabile").val(answer["responsabile"]);
            $("#currentPicture").val(answer["photo"]);
            if (answer["photo"] != '') {
                $('.preview').attr('src', answer["photo"]);
            }
        }
    });
});

/*=============================================
MAKE RESPONSIBLE USER
=============================================*/
$(document).on("click", ".btnResponsible", function () {
    var userId = $(this).attr("userId");
    var userResponsible = $(this).attr("userResponsible");
    var datum = new FormData();
    datum.append("responsibleId", userId);
    datum.append("responsibleUser", userResponsible);
    $.ajax({
        url: "ajax/users.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        success: function (answer) {
            if (window.matchMedia("(max-width:767px)").matches) {
                swal({
                    title: "Lo status dell'utente è stato cambiato!",
                    type: "success",
                    confirmButtonText: "Close"
                }).then(function (result) {
                    if (result.value) {
                        window.location = "users";
                    }
                })
            }
        }
    })
    if (userResponsible == 0) {
        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('Non Responsabile');
        $(this).attr('userResponsible', 1);
    } else {
        $(this).addClass('btn-success');
        $(this).removeClass('btn-danger');
        $(this).html('Responsabile');
        $(this).attr('userResponsible', 0);
    }
});

/*=============================================
ACTIVATE USER
=============================================*/
$(document).on("click", ".btnActivate", function () {
    var userId = $(this).attr("userId");
    var userStatus = $(this).attr("userStatus");
    var datum = new FormData();
    datum.append("activateId", userId);
    datum.append("activateUser", userStatus);
    $.ajax({
        url: "ajax/users.ajax.php",
        method: "POST",
        data: datum,
        cache: false,
        contentType: false,
        processData: false,
        success: function (answer) {
            if (window.matchMedia("(max-width:767px)").matches) {
                swal({
                    title: "Lo status dell'utente è stato cambiato!",
                    type: "success",
                    confirmButtonText: "Close"
                }).then(function (result) {
                    if (result.value) {
                        window.location = "users";
                    }
                })
            }
        }
    })
    if (userStatus == 0) {

        $(this).removeClass('btn-success');
        $(this).addClass('btn-danger');
        $(this).html('Inattivo');
        $(this).attr('userStatus', 1);
    } else {
        $(this).addClass('btn-success');
        $(this).removeClass('btn-danger');
        $(this).html('Attivo');
        $(this).attr('userStatus', 0);
    }
});


/*=============================================
VALIDATE IF USER ALREADY EXISTS
=============================================*/
$("#newUser").change(function () {
    $(".alert").remove();
    var user = $(this).val();
    var data = new FormData();
    data.append("validateUser", user);
    $.ajax({
        url: "ajax/users.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (answer) {
            if (answer) {
                $("#newUser").parent().after('<div class="alert alert-warning">This user is already taken</div>');
                $("#newUser").val('');
            }
        }
    });
});

/*=============================================
DELETE USER
=============================================*/

$(document).on("click", ".btnDeleteUser", function () {
    var userId = $(this).attr("userId");
    var userPhoto = $(this).attr("userPhoto");
    var username = $(this).attr("username");
    swal({
        title: 'Sicuro di voler eliminare questo utente?',
        text: "Se non sei sicuro puoi cancellare l'azione!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Si, cancella utente'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?route=users&userId=" + userId + "&username=" + username + "&userPhoto=" + userPhoto;
        }
    })
});



