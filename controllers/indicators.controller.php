<?php

class ControllerIndicators
{
    /*=============================================
   SHOW INDICATORS
   =============================================*/
    public static function ctrShowIndicatorsByTarget($idTarget)
    {
        return IndicatorsModel::mdlShowIndicatorsByTarget($idTarget);
    }

    static public function ctrShowIndicators($item, $value)
    {
        $table = "indicators";
        $answer = IndicatorsModel::mdlShowIndicators($table, $item, $value);
        return $answer;
    }

    /*=============================================
       check weight sum
       =============================================*/
    private static function ctrCheckWeight($idTarget)
    {
        return IndicatorsModel::mdlCheckWeight($idTarget);
    }

    /*=============================================
       calculate dynamically the premialita
       =============================================*/
    static public function ctrTargetPremialita($idTarget, $idDipendente, $obj)
    {
        return IndicatorsModel::mdlTargetPremialita($idTarget, $idDipendente, $obj)[0] ?: 0;
    }

    /*=============================================
    CALCOLA IN MODO DINAMICO LA PERCENTUALE DI COMPLETAMENTO
    =============================================*/
    static public function ctrTargetCompletion($idTarget)
    {
        return IndicatorsModel::mdlTargetCompletion($idTarget);
    }

    /*=============================================
      CREATE INDICATOR
      =============================================*/
    static public function ctrCreateIndicator()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newTarget"])) {
                if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newName"]) &&
                    preg_match('/^[0-9]+$/', $_POST["newWeight"])
                ) {
                    $table = "indicators";
                    $totalWeight = intval(ControllerIndicators::ctrCheckWeight($_POST["newTarget"])[0]);
                    $actualWeight = $totalWeight + intval($_POST["newWeight"]);
                    if (!is_null($_SESSION["idArea"])) {
                        $targets = array_map(function ($target) {
                            return $target["id"];
                        }, ControllerTarget::ctrShowTargetsByArea($_SESSION["idArea"]));
                        if (!in_array($_POST["newTarget"], $targets)) {
                            echo '<script>
					swal({
						  type: "error",
						  title: "Target non valido!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "indicators";
							}
						})
			  	</script>';
                            return;
                        }
                    }
                    if ($actualWeight <= 100) {
                        $data = array("idTarget" => $_POST["newTarget"],
                            "name" => $_POST["newName"],
                            "description" => $_POST["newDescription"],
                            "weight" => $_POST["newWeight"]);
                        $answer = IndicatorsModel::mdlAddIndicator($table, $data);
                        if ($answer == "ok") {
                            echo '<script>
						swal({
							  type: "success",
							  title: "Indicatore salvato correttamente!",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "indicators";
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
							window.location = "indicators";
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
							window.location = "indicators";
							}
						})
			  	</script>';
                }
            } else {
                echo '<script>

					swal({
						  type: "error",
						  title: "Target non selezionato!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
							if (result.value) {
							window.location = "indicators";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
    DELETE indicator
    =============================================*/
    static public function ctrDeleteIndicator()
    {
        if (isset($_GET["idIndicator"])) {
            $table = "indicators";
            $datum = $_GET["idIndicator"];
            $answer = IndicatorsModel::mdlDeleteIndicator($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Indicatore eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "indicators";
								}
							})
				</script>';
            }
        }
    }

    /*=============================================
     EDIT Indicator
    =============================================*/
    public function ctrEditIndicator()
    {
        if (isset($_POST["editName"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editDescription"]) &&
                preg_match('/^[0-9]+$/', $_POST["editWeight"])) {
                $table = "indicators";
                $totalWeight = intval(ControllerIndicators::ctrCheckWeight($_POST["editTargets"])[0]);
                $indicator = ControllerIndicators::ctrShowIndicators("id", $_POST["idIndicator"]);
                if ($_POST["editTargets"] == $indicator["idTarget"]) {
                    $totalWeight -= intval($indicator["weight"]);
                    $actualWeight = $totalWeight + intval($_POST["editWeight"]);
                } else {
                    $actualWeight = $totalWeight + intval($_POST["editWeight"]);
                }
                if ($actualWeight <= 100) {
                    $data = array("idTarget" => $_POST["editTargets"],
                        "description" => $_POST["editDescription"],
                        "weight" => $_POST["editWeight"],
                        "name" => $_POST["editName"],
                        "completion" => $_POST["editCompletion"],
                        "id" => $_POST["idIndicator"]);
                    $answer = IndicatorsModel::mdlEditIndicator($table, $data);
                    if ($answer == "ok") {
                        echo '<script>
						swal({
							  type: "success",
							  title: "Indicatore aggiornato con successo",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "indicators";
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
							window.location = "indicators";
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
							window.location = "indicators";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
       SHOW INDICATORS filtered by idArea
       =============================================*/
    static public function ctrShowIndicatorsByArea($idArea)
    {
        return IndicatorsModel::mdlShowIndicatorsByArea($idArea);
    }
}