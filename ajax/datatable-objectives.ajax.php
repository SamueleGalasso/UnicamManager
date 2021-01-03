<?php

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

require_once "../controllers/areas.controller.php";
require_once "../models/areas.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";


class ObjectivesTable
{
    /*=============================================
      SHOW objectives TABLE
      =============================================*/
    public function showObjectivesTable()
    {
        session_start();
        $item = null;
        $value = null;
        if ($_SESSION["profile"] == "Responsabile Area") {
            $objectives = ControllerObjectives::ctrShowObjectivesByArea($_SESSION["idArea"]);
        } else {
            $objectives = ControllerObjectives::ctrShowObjectives($item, $value);
        }
        if (count($objectives) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
        $jsonData = '{
			"data":[';
        for ($i = 0; $i < count($objectives); $i++) {
            /*=============================================
            We bring the area
            =============================================*/
            $item = "id";
            $value = $objectives[$i]["idArea"];
            $area = ControllerAreas::ctrShowAreas($item, $value);
            $plan = ControllerPlans::ctrShowPlans("id", $objectives[$i]["idPlan"]);
            $budget = ControllerObjectives::ctrBudgetObjective($plan["id"], $area["id"], $objectives[$i]["id"]);
            /*=============================================
            We bring the obj
            =============================================*/
            $completion = ControllerTarget::ctrUpdateObjectiveCompletion($objectives[$i]["id"])[0] ?: 0;
            /*=============================================
            ACTION BUTTONS
            =============================================*/
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $completion . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button class='btn btn-primary btnViewObjective'  style='width: 38px' idObjective='" . $objectives[$i]["id"] . "'><i class='fa fa-info'></i></button><button class='btn btn-danger btnDeleteObjective' idObjective='" . $objectives[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $plan["title"] . '",
						"' . $objectives[$i]["title"] . '",
						"' . $area["name"] . '",
						"' . $objectives[$i]["description"] . '",
						"' . $objectives[$i]["weight"] . ' %",
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
ACTIVATE objectives TABLE
=============================================*/
$activateObjectives = new ObjectivesTable();
$activateObjectives->showObjectivesTable();