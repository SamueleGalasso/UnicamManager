<?php

class ControllerTarget
{
    /*=============================================
       aggiorna la percentuale di completamento
       =============================================*/
    static public function ctrUpdateObjectiveCompletion($idObjective)
    {
        return TargetModel::mdlUpdateObjectiveCompletion($idObjective);
    }


    /*=============================================
	SHOW targets
	=============================================*/

    static public function ctrShowTargets($item, $value)
    {
        $table = "targets";
        $answer = TargetModel::mdlShowTargets($table, $item, $value);
        return $answer;
    }

    static public function ctrShowTargetsByObj($idObj)
    {
        return TargetModel::mdlShowTargetsByObj($idObj);
    }

    /*=============================================
	SHOW participants
	=============================================*/

    static public function ctrShowParticipants($item, $value)
    {
        $table = "participation";
        $answer = TargetModel::mdlShowParticipants($table, $item, $value);
        return $answer;
    }

    /*=============================================
       aggiorna il contributo dei dipendenti
       =============================================*/
    static public function ctrUpdateContributo()
    {
        if (isset($_POST["idParticipationEdit"])) {
            if (isset($_POST["editContributo"])) {
                $answer = TargetModel::updateContributo($_POST["idParticipationEdit"], $_POST["editContributo"]);
                if ($answer == "ok") {
                    ?>
                    <script>
                        swal({
                            type: "success",
                            title: "Contributo salvato con successo!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "targets?id=<?php echo $_POST['idTargetParticipationEdit']?>";
                            }
                        })
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        swal({
                            type: "error",
                            title: "Errore!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "targets?id=<?php echo $_POST['idTargetParticipationEdit']?>";
                            }
                        })
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    swal({
                        type: "error",
                        title: "Errore!",
                        showConfirmButton: true,
                        confirmButtonText: "Chiudi"
                    }).then(function (result) {
                        if (result.value) {
                            window.location = "targets?id=<?php echo $_POST['idTargetParticipationEdit']?>";
                        }
                    })
                </script>
                <?php
            }
        }
    }

    /*=============================================
       Crea il target
       =============================================*/
    static public function ctrCreateTarget()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newObjective"])) {
                $idObiettivo = $_POST["newObjective"];
                $objective = ControllerObjectives::ctrShowObjectives("id", $idObiettivo);
                if (!$objective) {
                    echo '<script>
					swal({
						  type: "error",
						  title: "Obiettivo inesistente!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "create-targets";
							}
						})
			  	</script>';
                    return;
                }
                if (!(is_null($_SESSION["idArea"]) || $_SESSION["idArea"] == $objective["idArea"])) {
                    echo '<script>
					swal({
						  type: "error",
						  title: "Azione selezionata non valida!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "create-targets";
							}
						})
			  	</script>';
                    return;
                }
                $percentage = $_POST["newWeight"];
                $totalWeight = intval(ControllerTarget::ctrCheckWeight($idObiettivo)[0]);
                $actualWeight = $totalWeight + intval($percentage);
                if ($actualWeight <= 100) {
                    $data = array("name" => $_POST["newName"],
                        "idObiettivo" => $idObiettivo,
                        "idUtenti" => isset($_POST["newUsersList"]) ? $_POST["newUsersList"] : [],
                        "weight" => $percentage,
                        "description" => $_POST["newDescription"]);
                    $answer = TargetModel::createTarget($data);
                    if ($answer == "ok") {
                        echo '<script>
					swal({
						  type: "success",
						  title: "Target salvato con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
									if (result.value) {
									window.location = "targets";
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
							window.location = "targets";
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
							window.location = "targets";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Non è stata selezionata nessuna Azione!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "create-targets";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
       Edit Target
       =============================================*/
    static public function ctrUpdateTarget()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newObjective"])) {
                $idObiettivo = $_POST["newObjective"];
                $objective = ControllerObjectives::ctrShowObjectives("id", $idObiettivo);
                if (!$objective) {
                    ?>
                    <script>
                        swal({
                            type: "error",
                            title: "Azione inesistente!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "targets?id=<?php echo $_POST['id']; ?>";
                            }
                        })
                    </script>
                    <?php
                    return;
                }
                if (!(is_null($_SESSION["idArea"]) || $_SESSION["idArea"] == $objective["idArea"])) {
                    ?>
                    <script>
                        swal({
                            type: "error",
                            title: "Azione inesistente!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "targets?id=<?php echo $_POST['id']; ?>";
                            }
                        })
                    </script>
                    <?php
                    return;
                }
                $target = ControllerTarget::ctrShowTargets("id", $_GET["id"]);
                $percentage = $_POST["newWeight"];
                $totalWeight = intval(ControllerTarget::ctrCheckWeight($idObiettivo)[0]);
                if ($_POST["newObjective"] == $target["idObjective"]) {
                    $totalWeight -= intval($target["weight"]);
                    $actualWeight = $totalWeight + intval($percentage);
                } else {
                    $actualWeight = $totalWeight + intval($percentage);
                }
                if ($actualWeight <= 100) {
                    $data = array(
                        "id" => $_POST["id"],
                        "name" => $_POST["newName"],
                        "idObiettivo" => $idObiettivo,
                        "idUtenti" => $_POST["newUsersList"],
                        "weight" => $percentage,
                        "description" => $_POST["newDescription"]);
                    $answer = TargetModel::updateTarget($data);
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
                                    window.location = "targets?id=<?php echo $_POST['id']; ?>";
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
                                    window.location = "targets?id=<?php echo $_POST['id']; ?>";
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
							window.location = "targets";
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
                            window.location = "targets?id=<?php echo $_POST['id']; ?>";
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
    static public function ctrDeleteTarget()
    {
        if (isset($_GET["idTarget"])) {
            $table = "targets";
            $datum = $_GET["idTarget"];
            $answer = TargetModel::mdlDeleteTarget($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Target eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "targets";
								}
							})
				</script>';
            }
        }
    }

    /*=============================================
       calcola in modo dinamico il peso dei target relativi ad un obiettivo
       =============================================*/
    private static function ctrCheckWeight($idObiettivo)
    {
        return TargetModel::mdlCheckWeight($idObiettivo);
    }

    /*=============================================
       mostra i target filtrati per area
       =============================================*/
    static public function ctrShowTargetsByArea($idArea)
    {
        return TargetModel::mdlShowTargetsByArea($idArea);
    }

    static public function ctrShowTargetsByDipendente($idDipendente)
    {
        return TargetModel::mdlShowTargetsByDipendente($idDipendente);

    }

    /*=============================================
       CALCOLA IN MODO DINAMICO il numero dei dipendenti coinvolti in target
       =============================================*/
    public static function ctrTotalParticipants()
    {
        return TargetModel::mdlTotalParticipants();
    }

    /*=============================================
       CALCOLA IN MODO DINAMICO il numero di target presenti nel db
       =============================================*/
    public static function ctrTotalTargets()
    {
        return TargetModel::mdlTotalTargets();
    }

    public static function ctrBudgetTarget($obj, $idTarget)
    {
        return TargetModel::mdlBudgetTarget($obj, $idTarget)[0] ?: 0;
    }
}
