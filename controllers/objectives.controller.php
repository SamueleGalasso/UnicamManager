<?php

class ControllerObjectives
{
    /*=============================================
    SHOW objectives
    =============================================*/
    static public function ctrShowObjectives($item, $value)
    {
        $table = "objectives";
        return ObjectivesModel::mdlShowObjectives($table, $item, $value);
    }

    static public function ctrShowObjectivesByPlan($idPlan)
    {
        return ObjectivesModel::mdlShowObjectivesByPlan($idPlan);
    }

    /*=============================================
    CREATE Objective
    =============================================*/
    static public function ctrCreateObjective()
    {
        if (isset($_POST["newTitle"])) {
            if (isset($_POST["newObjectiveUniversita"])) {
                if (isset($_POST["newArea"])) {
                    if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newTitle"]) &&
                        preg_match('/^[0-9]+$/', $_POST["newWeight"])
                    ) {
                        if (is_null($_SESSION["idArea"]) || $_SESSION["idArea"] == $_POST["newArea"]) {
                            $table = "objectives";
                            $idPlan = $_POST["objectiveIdPlan"];
                            $idArea = $_POST["newArea"];
                            $percentage = $_POST["newWeight"];
                            $totalWeight = intval(ControllerObjectives::ctrWeightSum($idPlan, $idArea)[0]);
                            $actualWeight = $totalWeight + intval($percentage);
                            if ($actualWeight <= 100) {
                                $data = array(
                                    "idArea" => $_POST["newArea"],
                                    "description" => $_POST["newDescription"],
                                    "idPlan" => $idPlan,
                                    "weight" => $percentage,
                                    "title" => $_POST["newTitle"],
                                    "idsObjectiveUniversita" => $_POST["newObjectiveUniversita"]
                                );
                                $answer = ObjectivesModel::mdlAddObjective($table, $data);
                                if ($answer == "ok") {
                                    echo '<script>
						swal({
							  type: "success",
							  title: "Azione salvata correttamente!",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "objectives";
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
							window.location = "objectives";
							}
						})
			  	</script>';
                            }
                        } else {
                            echo '<script>
					swal({
						  type: "error",
						  title: "Area selezionata non valida!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectives";
							}
						})
			  	</script>';
                        }
                    } else {
                        echo '<script>
					swal({
						  type: "error",
						  title: "Qualcosa è andato storto, chiudi per riprovare!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectives";
							}
						})
			  	</script>';
                    }
                } else {
                    echo '<script>
					swal({
						  type: "error",
						  title: "Area non selezionata!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectives";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Obiettivo non selezionato!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectives";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
    EDIT Objectives
    =============================================*/

    static public function ctrEditObjective()
    {
        if (isset($_POST["editDescription"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editDescription"]) &&
                preg_match('/^[0-9]+$/', $_POST["editWeight"]) &&
                preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editTitle"])) {
                if (is_null($_SESSION["idArea"]) || $_SESSION["idArea"] == $_POST["editArea"]) {
                    $table = "objectives";
                    $weight = $_POST["editWeight"];
                    $obj = ControllerObjectives::ctrShowObjectives("id", $_POST["idObjective"]);
                    $totalWeight = intval(ControllerObjectives::ctrWeightSum($_POST["editPlan"], $_POST["editArea"])[0]);
                    if ($_POST["editPlan"] == $obj["idPlan"] && $_POST["editArea"] == $obj["idArea"]) {
                        $totalWeight -= intval($obj["weight"]);
                        $actualWeight = $totalWeight + intval($weight);
                    } else {
                        $actualWeight = $totalWeight + intval($weight);
                    }
                    if (!isset($_POST["editObjectiveUniversita"])) {
                        ?>
                        <script>
                            swal({
                                type: "error",
                                title: "Devi selezionare un obiettivo!",
                                showConfirmButton: true,
                                confirmButtonText: "Chiudi"
                            }).then(function (result) {
                                if (result.value) {
                                    window.location = "objectives?id=<?php echo $_POST['idObjective']; ?>";
                                }
                            })
                        </script>
                        <?php
                        return;
                    }
                    if ($actualWeight <= 100) {
                        $data = array(
                            "idArea" => $_POST["editArea"],
                            "idPlan" => $_POST["editPlan"],
                            "idObjUni" => $_POST["editObjectiveUniversita"],
                            "description" => $_POST["editDescription"],
                            "weight" => $weight,
                            "title" => $_POST["editTitle"],
                            "id" => $_POST["idObjective"]);
                        $answer = ObjectivesModel::mdlEditObjective($table, $data);
                        if ($answer == "ok") {
                            ?>
                            <script>
                                swal({
                                    type: "success",
                                    title: "Obiettivo aggiornato con successo",
                                    showConfirmButton: true,
                                    confirmButtonText: "Chiudi"
                                }).then(function (result) {
                                    if (result.value) {
                                        window.location = "objectives?id=<?php echo $data['id']; ?>";
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
                                title: "La somma dei pesi non può superare 100!",
                                showConfirmButton: true,
                                confirmButtonText: "Chiudi"
                            }).then(function (result) {
                                if (result.value) {
                                    window.location = "objectives?id=<?php echo $_POST['idObjective']; ?>";
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
                            title: "Area selezionata non valida",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "objectives?id=<?php echo $_POST['idObjective']; ?>";
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
                        title: "Oops qualocosa è andato storto. Riprova.",
                        showConfirmButton: true,
                        confirmButtonText: "Chiudi"
                    }).then(function (result) {
                        if (result.value) {
                            window.location = "objectives?id=<?php echo $_POST['idObjective']; ?>";
                        }
                    })
                </script>
                <?php
            }
        }
    }

    /*=============================================
    DELETE Objective
    =============================================*/
    static public function ctrDeleteObjective()
    {
        if (isset($_GET["idObjective"])) {
            $table = "objectives";
            $datum = $_GET["idObjective"];
            $answer = ObjectivesModel::mdlDeleteObjective($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Obiettivo eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "objectives";
								}
							})
				</script>';
            }
        }
    }

    /*=============================================
       CALCOLA e controlla la somma dei pesi deglle azioni organizzative
       =============================================*/
    private static function ctrCheckWeight($idObjective)
    {
        return ObjectivesModel::mdlCheckWeight($idObjective);
    }

    /*=============================================
       mostra le azioni filtrate per area
       =============================================*/
    public static function ctrShowObjectivesByArea($idArea)
    {
        return ObjectivesModel::mdlShowObjectivesByArea($idArea);
    }

    /*=============================================
       conta il totale delle azioni
       =============================================*/
    public static function ctrTotalObjectives()
    {
        return ObjectivesModel::ctrTotalObjectives();
    }

    /*=============================================
    Mostra il budget assegnato all'area idArea per il piano idPlan
    =============================================*/
    public static function ctrShowBudget($idPlan, $idArea)
    {
        return ObjectivesModel::mdlShowBudget($idPlan, $idArea);
    }

    /*=============================================
   Somma i pesi delle azioni organizzative per idPlan e idArea
   =============================================*/
    public static function ctrWeightSum($idPlan, $idArea)
    {
        return ObjectivesModel::mdlWeightSum($idPlan, $idArea);
    }

    /*=============================================
   Mostra le partecipazioni di una azione organizzativa con un obiettivo
   =============================================*/
    public static function ctrShowParticipations($idObjective)
    {
        return ObjectivesModel::mdlShowParticipations($idObjective);
    }

    public static function ctrBudgetObjective($idPlan, $idArea, $idObj)
    {
        return ObjectivesModel::mdlShowBudgetObjective($idPlan, $idArea, $idObj)[0] ?: 0;
    }
}