<?php

class ControllerPlans
{
    /*============================================
   CREATE Plan
   =============================================*/
    static public function ctrCreatePlan()
    {
        if (isset($_POST['newTitle'])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newTitle"])) {
                $table = 'plans';
                $areas = array_map(function ($area) {
                    return ["area" => $area, "budget" => $_POST["area-" . $area]];
                }, $_POST["newAreasList"]);
                $data = array('title' => $_POST["newTitle"],
                    'description' => $_POST["newDescription"],
                    'budget' => $_POST["newBudget"],
                    'date' => $_POST["newDate"],
                    'areas' => $areas
                );
                $budgetSum = array_reduce($data["areas"], function ($sum, $area) {
                    $sum += $area["budget"];
                    return $sum;
                }, 0);
                if ($budgetSum > $data["budget"]) {
                    ?>
                    <script>
                        swal({
                            type: "error",
                            title: "Il budget assegnato alle aree è superiore al budget del piano.",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "plans";
                            }
                        });
                    </script>
                    <?php
                    return "error";
                }
                $answer = PlansModel::mdlAddPlan($table, $data);
                if ($answer == 'ok') {
                    ?>
                    <script>
                        swal({
                            type: "success",
                            title: "Il Piano Annuale è stato salvato con successo! ",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "plans";
                            }
                        });

                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    swal({
                        type: "error",
                        title: "Non sono ammessi caratteri speciali o form vuoti",
                        showConfirmButton: true,
                        confirmButtonText: "Chiudi"
                    }).then(function (result) {
                        if (result.value) {
                            window.location = "plans";
                        }
                    });
                </script>
                <?php
            }
        }
    }

    /*=============================================
    SHOW PLANS
    =============================================*/
    static public function ctrShowPlans($item, $value)
    {
        $table = "plans";
        $answer = PlansModel::mdlShowPlans($table, $item, $value);
        return $answer;
    }

    /*=============================================
    EDIT Plan
    =============================================*/

    static public function ctrEditPlan()
    {
        if (isset($_POST["editTitle"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["editTitle"])) {
                $table = "plans";
                $data = array(
                    "title" => $_POST["editTitle"],
                    "description" => $_POST["editDescription"],
                    "budget" => $_POST["editBudget"],
                    "idAreas" => isset($_POST["newAreasList"]) ? $_POST["newAreasList"] : [],
                    "id" => $_POST["idPlan"]);
                $answer = PlansModel::mdlEditPlan($table, $data);
                if ($answer == "ok") {
                    ?>
                    <script>
                        swal({
                            type: "success",
                            title: "Il Piano è stato salvato correttamente! ",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "plans";
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
                        title: "Non sono ammessi caratteri speciali o form vuoti",
                        showConfirmButton: true,
                        confirmButtonText: "Chiudi"
                    }).then(function (result) {
                        if (result.value) {
                            window.location = "plans";
                        }
                    })
                </script>
                <?php
            }
        }
    }

    /*=============================================
    DELETE PLAN
    =============================================*/

    static public function ctrDeletePlan()
    {
        if (isset($_GET["idPlan"])) {
            $table = "plans";
            $data = $_GET["idPlan"];
            $answer = PlansModel::mdlDeletePlan($table, $data);
            if ($answer == "ok") {
                echo '<script>
					swal({
						  type: "success",
						  title: "Il Piano Annuale è stato eliminato con successo!",
						  showConfirmButton: true,
						  confirmButtonText: "Chiudi"
						  }).then(function(result){
									if (result.value) {
									window.location = "plans";
									}
								})
					</script>';
            }
        }
    }

    /*=============================================
       CALCOLA IN MODO DINAMICO il totale dei soldi investiti nei piani annuali
       =============================================*/
    public static function ctrTotalBudget()
    {
        return PlansModel::mdlTotalBudget();
    }

    /*=============================================
       Mostra le partecipazioni tra piano ed aree
       =============================================*/
    public static function ctrShowParticipants($idPlan)
    {
        return PlansModel::mdlShowParticipants($idPlan);
    }

    /*=============================================
       Mostra una partecipazione tra piano ed aree
       filtrata per id
     =============================================*/
    public static function ctrShowParticipant($id)
    {
        return PlansModel::mdlShowParticipant($id);
    }

    /*=============================================
       Metodo per aggiornare il budget dell'area
       associata ad un piano
     =============================================*/
    public static function ctrUpdateBudget()
    {
        if (isset($_POST["idParticipationEdit"])) {
            $idParticipationAreas = $_POST["idParticipationEdit"];
            $idPlan = $_POST['idPlanParticipationEdit'];
            if (isset($_POST["editBudget"])) {
                $array = ControllerPlans::ctrShowParticipants($idPlan);
                foreach ($array as $key => $row) {
                    if ($row["id"] === $idParticipationAreas) {
                        unset($array[$key]);
                        break;
                    }
                }
                $budget = ControllerPlans::ctrShowPlans("id", $idPlan)["budget"];
                $sum = array_reduce($array, function ($acc, $row) {
                    $sum = $acc + $row["budget"];
                    return $sum;
                }, 0);
                if ($sum + $_POST["editBudget"] > $budget) {
                    ?>
                    <script>
                        swal({
                            type: "error",
                            title: "Budget specificato è maggiore del budget del piano!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "plans?id=<?php echo $idPlan?>";
                            }
                        })
                    </script>
                    <?php
                    return;
                }
                $answer = PlansModel::updateBudget($idParticipationAreas, $_POST["editBudget"]);
                if ($answer == "ok") {
                    ?>
                    <script>
                        swal({
                            type: "success",
                            title: "Budget salvato con successo!",
                            showConfirmButton: true,
                            confirmButtonText: "Chiudi"
                        }).then(function (result) {
                            if (result.value) {
                                window.location = "plans?id=<?php echo $idPlan?>";
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
                                window.location = "plans?id=<?php echo $idPlan?>";
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
                            window.location = "plans?id=<?php echo $idPlan?>";
                        }
                    })
                </script>
                <?php
            }
        }
    }

    /*=============================================
      Mostra le partecipazioni ad un piano filtrate per idArea
      =============================================*/
    public static function ctrShowParticipantByArea($idPlan, $idArea)
    {
        return PlansModel::mdlShowParticipantByArea($idPlan, $idArea);
    }

    /*=============================================
      Mostra le aree partecipanti ad un piano filtrate per idPlan
     =============================================*/
    public static function ctrShowAreasByPlan($idPlan)
    {
        return PlansModel::mdlShowAreasByPlan($idPlan);
    }
}