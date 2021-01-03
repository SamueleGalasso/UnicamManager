<?php

class ControllerObjectivesUniversita
{
    /*=============================================
    SHOW objectives
    =============================================*/
    static public function ctrShowObjectivesUniversita($item, $value)
    {
        $table = "objectivesuniversita";
        $answer = ObjectivesUniversitaModel::mdlShowObjectivesUniversita($table, $item, $value);
        return $answer;
    }

    /*=============================================
       Show obj uni
       =============================================*/
    static public function ctrShowObjUni($item, $value)
    {
        $answer = ObjectivesUniversitaModel::mdlShowObjUni($item, $value);
        return $answer;
    }

    /*=============================================
      Show Obiettivi Universita filtrati per Azione Organizzativa
       =============================================*/
    static public function ctrShowObjUniByObjective($idObjective)
    {
        return ObjectivesUniversitaModel::mdlShowObjUniByObjective($idObjective);
    }

    /*=============================================
    CREATE Objective
    =============================================*/
    static public function ctrCreateObjectiveUniversita()
    {
        if (isset($_POST["newTitle"])) {
            if (isset($_POST["newPlan"])) {
                if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newTitle"]) &&
                    preg_match('/^[0-9]+$/', $_POST["newWeight"])
                ) {
                    $table = "objectivesuniversita";
                    $currentPlan = ControllerPlans::ctrShowPlans("id", $_POST["newPlan"]);
                    $percentage = $_POST["newWeight"];
                    $totalWeight = intval(ControllerObjectivesUniversita::ctrCheckWeight($currentPlan["id"])[0]);
                    $actualWeight = $totalWeight + intval($percentage);
                    if ($actualWeight <= 100) {
                        $data = array("idPlan" => $_POST["newPlan"],
                            "description" => $_POST["newDescription"],
                            "weight" => $percentage,
                            "title" => $_POST["newTitle"]);
                        $answer = ObjectivesUniversitaModel::mdlAddObjectiveUniversita($table, $data);
                        if ($answer == "ok") {
                            echo '<script>
						swal({
							  type: "success",
							  title: "Obiettivo salvato correttamente!",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "objectivesUniversita";
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
							window.location = "objectivesUniversita";
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
							window.location = "objectivesUniversita";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Piano non selezionato!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectivesUniversita";
							}
						})
			  	</script>';
            }
        }
    }

    /*============================================
    EDIT Objectives
    =============================================*/
    static public function ctrEditObjectiveUniversita()
    {
        if (isset($_POST["editDescription"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editDescription"]) &&
                preg_match('/^[0-9]+$/', $_POST["editWeight"]) &&
                preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editTitle"])) {
                $weight = $_POST["editWeight"];
                $table = "objectivesuniversita";
                $currentPlan = ControllerPlans::ctrShowPlans("id", $_POST["editPlan"]);
                $obj = ControllerObjectivesUniversita::ctrShowObjectivesUniversita("id", $_POST["idObjectiveUniversita"])[0];
                $totalWeight = intval(ControllerObjectivesUniversita::ctrCheckWeight($currentPlan["id"])[0]);
                if ($_POST["editPlan"] == $obj["idPlan"]) {
                    $totalWeight -= intval($obj["weight"]);
                    $actualWeight = $totalWeight + intval($weight);
                } else {
                    $actualWeight = $totalWeight + intval($weight);
                }
                if ($actualWeight <= 100) {
                    $data = array("idPlan" => $_POST["editPlan"],
                        "description" => $_POST["editDescription"],
                        "weight" => $weight,
                        "title" => $_POST["editTitle"],
                        "id" => $_POST["idObjectiveUniversita"]);
                    $answer = ObjectivesUniversitaModel::mdlEditObjectiveUniversita($table, $data);
                    if ($answer == "ok") {
                        echo '<script>
						swal({
							  type: "success",
							  title: "Obiettivo aggiornato con successo",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										  window.location = "objectivesUniversita";
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
							window.location = "objectivesUniversita";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>
					swal({
						  type: "error",
						  title: "Ops qualcosa è andato storto... chiudi per riprovare",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "objectivesUniversita";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
    DELETE Objective
    =============================================*/
    static public function ctrDeleteObjectiveUniversita()
    {
        if (isset($_GET["idObjective"])) {
            $table = "objectivesuniversita";
            $datum = $_GET["idObjective"];
            $answer = ObjectivesUniversitaModel::mdlDeleteObjectiveUniversita($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Obiettivo eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "objectivesUniversita";
								}
							})
				</script>';
            }
        }
    }

    /*=============================================
       calcola la somma dei pesi
       =============================================*/
    private static function ctrCheckWeight($id)
    {
        return ObjectivesUniversitaModel::mdlCheckWeight($id);
    }

    public static function ctrBudgetObjectiveUniversita($idPlan, $idObj)
    {
        return ObjectivesUniversitaModel::mdlBudgetObjectiveUniversita($idPlan, $idObj)[0] ?: 0;
    }
}