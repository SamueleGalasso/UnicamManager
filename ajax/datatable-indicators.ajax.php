<?php

require_once "../controllers/indicators.controller.php";
require_once "../models/indicators.model.php";

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";


class IndicatorsTable
{
    /*=============================================
      SHOW indicators TABLE
      =============================================*/
    public function showIndicatorsTable()
    {
        session_start();
        $item = null;
        $value = null;
        if (is_null($_SESSION["idArea"]))
            $indicators = ControllerIndicators::ctrShowIndicators($item, $value);
        else
            $indicators = ControllerIndicators::ctrShowIndicatorsByArea($_SESSION["idArea"]);
        if (count($indicators) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }

        $jsonData = '{
			"data":[';
        for ($i = 0; $i < count($indicators); $i++) {
            /*=============================================
            We bring the area
            =============================================*/
            $item = "id";
            $value = $indicators[$i]["idTarget"];
            $targets = ControllerTarget::ctrShowTargets($item, $value);
            $objective = ControllerObjectives::ctrShowObjectives("id", $targets["idObjective"]);
            $plan = ControllerPlans::ctrShowPlans("id", $objective["idPlan"]);
            $completion = $indicators[$i]["completion"];
            /*=============================================
            ACTION BUTTONS
            =============================================*/
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $completion . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditIndicator' idIndicator='" . $indicators[$i]["id"] . "' data-toggle='modal' data-target='#modalEditIndicator'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteIndicator' idIndicator='" . $indicators[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $plan["title"] . '",
						"' . $objective["title"] . '",
						"' . $targets["name"] . '",
						"' . $indicators[$i]["name"] . '",
						"' . $indicators[$i]["weight"] . ' %",
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
ACTIVATE indicators TABLE
=============================================*/
$activateIndicators = new IndicatorsTable();
$activateIndicators->showIndicatorsTable();
