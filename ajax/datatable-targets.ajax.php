<?php

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

require_once "../controllers/indicators.controller.php";
require_once "../models/indicators.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

class TargetsTable
{
    /*=============================================
      SHOW targets TABLE
      =============================================*/
    public function showTargetsTable()
    {
        session_start();
        $item = null;
        $value = null;
        if (is_null($_SESSION["idArea"])) $targets = ControllerTarget::ctrShowTargets($item, $value);
        else $targets = ControllerTarget::ctrShowTargetsByArea($_SESSION["idArea"]);
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
            $value = $targets[$i]["idObjective"];
            $objective = ControllerObjectives::ctrShowObjectives($item, $value);
            $plan = ControllerPlans::ctrShowPlans("id", $objective["idPlan"]);
            $completion = ControllerIndicators::ctrTargetCompletion($targets[$i]["id"])[0];
            $budget = ControllerTarget::ctrBudgetTarget($objective, $targets[$i]["id"]);
            /*=============================================
           ACTION BUTTONS
           =============================================*/
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $completion . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button style='width: 38px' class='btn btn-primary btnViewTarget' idTarget='" . $targets[$i]["id"] . "'><i class='fa fa-info'></i></button><button class='btn btn-danger btnDeleteTarget' idTarget='" . $targets[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";

            if ($completion == null) {
                $completion = 0;
            }
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
$activateTargets = new TargetsTable();
$activateTargets->showTargetsTable();