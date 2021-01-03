<?php

class ControllerIndicatorsUniversita
{
    /*=============================================
   SHOW INDICATORS
   =============================================*/
    static public function ctrShowIndicatorsUniversita($item, $value)
    {
        $table = "indicatorsuniversita";
        $answer = IndicatorsUniversitaModel::mdlShowIndicatorsUniversita($table, $item, $value);
        return $answer;
    }

    static public function ctrShowIndicatorsUniversitaByTarget($idTarget)
    {
        return IndicatorsUniversitaModel::mdlShowIndicatorsUniversitaByTarget($idTarget);
    }

    /*=============================================
       CALCOLA e controlla la somma dei pesi degli indicatori
       =============================================*/
    private static function ctrCheckWeight($idTarget)
    {
        return IndicatorsUniversitaModel::mdlCheckWeight($idTarget);
    }


    /*=============================================
    CALCOLA IN MODO DINAMICO LA PERCENTUALE DI COMPLETAMENTO
    =============================================*/
    static public function ctrTargetUniversitaCompletion($idTarget)
    {
        return IndicatorsUniversitaModel::mdlTargetUniversitaCompletion($idTarget);
    }

    /*=============================================
      CREATE INDICATOR
      =============================================*/
    static public function ctrCreateIndicatorUniversita()
    {
        if (isset($_POST["newName"])) {
            if (isset($_POST["newTarget"])) {
                if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newName"]) &&
                    preg_match('/^[0-9]+$/', $_POST["newWeight"])
                ) {
                    $table = "indicatorsuniversita";
                    $actualWeight = intval(ControllerIndicatorsUniversita::ctrCheckWeight($_POST["newTarget"])[0]);
                    $totalWeight = $actualWeight + intval($_POST["newWeight"]);
                    if ($totalWeight <= 100) {
                        $data = array("idTarget" => $_POST["newTarget"],
                            "name" => $_POST["newName"],
                            "description" => $_POST["newDescription"],
                            "weight" => $_POST["newWeight"]);
                        $answer = IndicatorsUniversitaModel::mdlAddIndicatorUniversita($table, $data);
                        if ($answer == "ok") {
                            echo '<script>
						swal({
							  type: "success",
							  title: "Indicatore salvato correttamente!",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "indicatorsUniversita";
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
							window.location = "indicatorsUniversita";
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
							window.location = "indicatorsUniversita";
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
							window.location = "indicatorsUniversita";
							}
						})
			  	</script>';
            }
        }
    }

    /*=============================================
    DELETE indicator
    =============================================*/
    static public function ctrDeleteIndicatorUniversita()
    {
        if (isset($_GET["idIndicator"])) {
            $table = "indicatorsuniversita";
            $datum = $_GET["idIndicator"];
            $answer = IndicatorsUniversitaModel::mdlDeleteIndicatorUniversita($table, $datum);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Indicatore eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
								if (result.value) {
								window.location = "indicatorsUniversita";
								}
							})
				</script>';
            }
        }
    }

    /*=============================================
     EDIT Indicator
    =============================================*/
    public function ctrEditIndicatorUniversita()
    {
        if (isset($_POST["editName"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editDescription"]) &&
                preg_match('/^[0-9]+$/', $_POST["editWeight"])) {
                $table = "indicatorsuniversita";
                $totalWeight = intval(ControllerIndicatorsUniversita::ctrCheckWeight($_POST["editTargets"])[0]);
                $indicator = ControllerIndicatorsUniversita::ctrShowIndicatorsUniversita("id", $_POST["idIndicator"]);
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
                    $answer = IndicatorsUniversitaModel::mdlEditIndicatorUniversita($table, $data);
                    if ($answer == "ok") {
                        echo '<script>
						swal({
							  type: "success",
							  title: "Indicatore aggiornato con successo",
							  showConfirmButton: true,
							  confirmButtonText: "Chiudi"
							  }).then(function(result){
										if (result.value) {
										window.location = "indicatorsUniversita";
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
							window.location = "indicatorsUniversita";
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
							window.location = "indicatorsUniversita";
							}
						})
			  	</script>';
            }
        }
    }
}