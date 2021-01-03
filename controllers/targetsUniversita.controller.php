<?php

class ControllerTargetUniversita
{
    /*=============================================
   aggiorna la percentuale di completamento
   =============================================*/
    static public function ctrUpdateObjectiveCompletion($idObjective)
    {
        return TargetUniversitaModel::mdlUpdateObjectiveCompletion($idObjective);
    }

    /*=============================================
       CALCOLA IN MODO DINAMICO il peso di targets relativi ad un obiettivo
       =============================================*/
    static public function ctrCheckWeight($idObjective)
    {
        return TargetUniversitaModel::mdlCheckWeight($idObjective);
    }

    /*=============================================
	SHOW targets
	=============================================*/
    static public function ctrShowTargetsUniversita($item, $value)
    {
        $table = "targetsuniversita";
        $answer = TargetUniversitaModel::mdlShowTargetsUniversita($table, $item, $value);
        return $answer;
    }

    /*=============================================
	SHOW targets
	=============================================*/
    static public function ctrShowTargetsUniversitaByObj($idObj)
    {
        return TargetUniversitaModel::mdlShowTargetsUniversitaByObj($idObj);
    }

    /*=============================================
       Crea target
       =============================================*/
    static public function ctrCreateTargetUniversita()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newObjective"])) {
                $idObiettivo = $_POST["newObjective"];
                $objective = ControllerObjectivesUniversita::ctrShowObjectivesUniversita("id", $idObiettivo)[0];
                $percentage = $_POST["newWeight"];
                $totalWeight = intval(ControllerTargetUniversita::ctrCheckWeight($idObiettivo)[0]);
                $actualWeight = $totalWeight + intval($percentage);
                if ($actualWeight <= 100) {
                    $data = array("name" => $_POST["newName"],
                        "idObiettivo" => $idObiettivo,
                        "weight" => $percentage,
                        "description" => $_POST["newDescription"]);
                    $answer = TargetUniversitaModel::createTargetUniversita($data);
                    if ($answer == "ok") {
                        echo '<script>
					swal({
						  type: "success",
						  title: "Target salvato con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
									if (result.value) {
									window.location = "targetsUniversita";
									}
								})

					</script>';
                    } else {
                        echo '<script>
					swal({
						  type: "error",
						  title: "Non sono ammessi spazi vuoti o caratteri speciali!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "targetsUniversita";
							}
						})
			  	</script>';
                    }
                } else {
                    echo '<script>
					swal({
						  type: "error",
						  title: "La somma dei pesi non può superare 100!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "targetsUniversita";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Non è stato selezionato nessun obiettivo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "targetsUniversita";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
       edit target
       =============================================*/
    static public function ctrEditTargetUniversita()
    {
        if (isset($_POST["editName"])) {
            if (isset($_POST["editObjective"])) {
                $idObiettivo = $_POST["editObjective"];
                $objective = ControllerObjectivesUniversita::ctrShowObjectivesUniversita("id", $idObiettivo)[0];
                $percentage = $_POST["editWeight"];
                $target = ControllerTargetUniversita::ctrShowTargetsUniversita("id", $_POST["id"]);
                $totalWeight = intval(ControllerTargetUniversita::ctrCheckWeight($idObiettivo)[0]);
                if ($idObiettivo == $target["idObjectiveUniversita"]) {
                    $totalWeight -= intval($target["weight"]);
                    $actualWeight = $totalWeight + intval($percentage);
                } else {
                    $actualWeight = $totalWeight + intval($percentage);
                }
                if ($actualWeight <= 100) {
                    $data = array(
                        "id" => $_POST["id"],
                        "name" => $_POST["editName"],
                        "idObiettivo" => $idObiettivo,
                        "weight" => $percentage,
                        "description" => $_POST["editDescription"]);
                    $answer = TargetUniversitaModel::mdlEditTargetUniversita($data);
                    if ($answer == "ok") {
                        ?>
                        <script>
                            swal({
                                type: "success",
                                title: "Target salvato con successo!",
                                showConfirmButton: true,
                                confirmButtonText: "Chiudi"
                            }).then(function (result) {
                                if (result.value) {
                                    window.location = "targetsUniversita";
                                }
                            })
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            swal({
                                type: "error",
                                title: "Non sono ammessi spazi vuoti o caratteri speciali!",
                                showConfirmButton: true,
                                confirmButtonText: "Chiudi"
                            }).then(function (result) {
                                if (result.value) {
                                    window.location = "targetsUniversita";
                                }
                            })
                        </script>
                        <?php
                    }
                } else {
                    echo '<script>
					swal({
						  type: "error",
						  title: "La somma dei pesi non può superare 100!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "targetsUniversita";
							}
						})
			  	</script>';
                }

            } else {
                ?>
                <script>
                    swal({
                        type: "error",
                        title: "Non è stato selezionato nessun obiettivo!",
                        showConfirmButton: true,
                        confirmButtonText: "Chiudi"
                    }).then(function (result) {
                        if (result.value) {
                            window.location = "targetsUniversita";
                        }
                    })
                </script>
                <?php
            }
        }
    }

    /*=============================================
	DELETE Target
	=============================================*/
    static public function ctrDeleteTargetUniversita()
    {
        if (isset($_GET["idTarget"])) {
            $table = "targetsuniversita";
            $datum = $_GET["idTarget"];
            $answer = TargetUniversitaModel::mdlDeleteTargetUniversita($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Target eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "targetsUniversita";
								}
							})
				</script>';
            }
        }
    }

    static public function ctrBudgetTargetUniversita($obj, $idTarget)
    {
        return TargetUniversitaModel::mdlBudgetTargetUniversita($obj, $idTarget)[0] ?: 0;
    }
}
