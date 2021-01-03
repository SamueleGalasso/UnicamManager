<?php

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

require_once "../controllers/areas.controller.php";
require_once "../models/areas.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

require_once "../controllers/targetsUniversita.controller.php";
require_once "../models/targetsUniversita.model.php";


class ObjectivesUniversitaTable
{
    /*=============================================
      SHOW objectives TABLE
      =============================================*/
    public function showObjectivesTableUniversita()
    {
        $item = null;
        $value = null;
        $objectives = ControllerObjectivesUniversita::ctrShowObjectivesUniversita($item, $value);
        if (count($objectives) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }

        $jsonData = '{
			"data":[';
        for ($i = 0; $i < count($objectives); $i++) {
            /*=============================================
            We bring the plan and completion %
            =============================================*/
            $item = "id";
            $value = $objectives[$i]["idPlan"];
            $plan = ControllerPlans::ctrShowPlans($item, $value);
            $completion = ControllerTargetUniversita::ctrUpdateObjectiveCompletion($objectives[$i]["id"])[0] ?: 0;
            $budget = ControllerObjectivesUniversita::ctrBudgetObjectiveUniversita($plan["id"], $objectives[$i]["id"]);
            /*=============================================
            ACTION BUTTONS
            =============================================*/
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $completion . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditObjectiveUniversita' idObjective='" . $objectives[$i]["id"] . "' data-toggle='modal' data-target='#modalEditObjectiveUniversita'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteObjectiveUniversita' idObjective='" . $objectives[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $plan["title"] . '",
						"' . $objectives[$i]["title"] . '",
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
$activateObjectives = new ObjectivesUniversitaTable();
$activateObjectives->showObjectivesTableUniversita();