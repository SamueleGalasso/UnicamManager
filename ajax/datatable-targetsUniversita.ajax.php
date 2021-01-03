<?php

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

require_once "../controllers/targetsUniversita.controller.php";
require_once "../models/targetsUniversita.model.php";

require_once "../controllers/indicatorsUniversita.controller.php";
require_once "../models/indicatorsUniversita.model.php";


class TargetsUniversitaTable
{
    /*=============================================
      SHOW targets TABLE
      =============================================*/
    public function showTargetsUniversitaTable()
    {
        $item = null;
        $value = null;
        $targets = ControllerTargetUniversita::ctrShowTargetsUniversita($item, $value);
        if (count($targets) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
        $jsonData = '{
			"data":[';

        for ($i = 0; $i < count($targets); $i++) {
            /*=============================================
            We bring the objective
            =============================================*/
            $item = "id";
            $value = $targets[$i]["idObjectiveUniversita"];
            $objective = ControllerObjectivesUniversita::ctrShowObjectivesUniversita($item, $value)[0];
            $plan = ControllerPlans::ctrShowPlans("id", $objective["idPlan"]);
            $budget = ControllerTargetUniversita::ctrBudgetTargetUniversita($objective, $targets[$i]["id"]);
            /*=============================================
           ACTION BUTTONS
           =============================================*/
            $completion = ControllerIndicatorsUniversita::ctrTargetUniversitaCompletion($targets[$i]["id"])[0] ?: 0;
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $completion . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button style='width: 38px' class='btn btn-warning btnEditTargetUniversita' idTarget='" . $targets[$i]["id"] . "' data-toggle='modal' data-target='#modalEditTargetUniversita'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteTargetUniversita' idTarget='" . $targets[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";


            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $plan["title"] . '",
						"' . $objective["title"] . '",
						"' . $targets[$i]["name"] . '",
						"' . $targets[$i]["weight"] . ' %",
						"' . $budget . ' €",
						"' . $bar . '",
						"' . $buttons . '"
					],';
        }

        $jsonData = substr($jsonData, 0, -1);
        $jsonData .= '] 

			}';

        echo $jsonData;
    }
}

/*=============================================
ACTIVATE targets TABLE
=============================================*/
$activateTargets = new TargetsUniversitaTable();
$activateTargets->showTargetsUniversitaTable();