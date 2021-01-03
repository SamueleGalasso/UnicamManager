<?php

class ControllerAreas
{
    /*=============================================
    CREATE Area
    =============================================*/

    static public function ctrCreateArea()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newResponsabile"])) {
                if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newName"])) {
                    $table = "areas";
                    $data = array("name" => $_POST["newName"],
                        "idResponsabile" => $_POST["newResponsabile"]);
                    $answer = ModelAreas::mdlAddArea($table, $data);
                    if ($answer == "ok") {
                        echo '<script>
					swal({
						  type: "success",
						  title: "Area salvata con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
									if (result.value) {
									window.location = "areas";
									}
								})
					</script>';
                    }
                } else {
                    echo '<script>
					swal({
						  type: "error",
						  title: "Non sono ammessi spazi vuoti o caratteri speciali!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "areas";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Responsabile non selezionato!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "areas";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
    SHOW Areas
    =============================================*/
    static public function ctrShowAreas($item, $value)
    {
        $table = "areas";
        return ModelAreas::mdlShowAreas($table, $item, $value);
    }


    /*=============================================
	EDIT Area
	=============================================*/
    static public function ctrEditArea()
    {
        if (isset($_POST["editName"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editName"])) {
                $table = "areas";
                $data = array("id" => $_POST["idArea"],
                    "editResponsabile" => $_POST["editResponsabile"],
                    "name" => $_POST["editName"]);
                print_r(var_dump($data), true);
                $answer = ModelAreas::mdlEditArea($table, $data);
                if ($answer == "ok") {
                    echo '<script>
					swal({
						  type: "success",
						  title: "Area aggiornata con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {
									window.location = "areas";
									}
								})
					</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Non sono ammessi spazi vuoti o caratteri speciali!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							window.location = "areas";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
	DELETE Area
	=============================================*/
    static public function ctrDeleteArea()
    {
        if (isset($_GET["idArea"])) {
            $table = "areas";
            $data = array("id" => $_GET["idArea"]);
            $answer = ModelAreas::mdlDeleteArea($table, $data);
            if ($answer == "ok") {
                echo '<script>
					swal({
						  type: "success",
						  title: "Area eliminata con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
									if (result.value) {
									window.location = "areas";
									}
								})
					</script>';
            }
        }
    }
}