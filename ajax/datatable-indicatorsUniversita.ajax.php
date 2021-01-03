<?php

require_once "../controllers/indicatorsUniversita.controller.php";
require_once "../models/indicatorsUniversita.model.php";

require_once "../controllers/targetsUniversita.controller.php";
require_once "../models/targetsUniversita.model.php";

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";


class IndicatorsUniversitaTable
{
    /*=============================================
      SHOW indicators TABLE
      =============================================*/
    public function showIndicatorsUniversitaTable()
    {
        $item = null;
        $value = null;
        $indicators = ControllerIndicatorsUniversita::ctrShowIndicatorsUniversita($item, $value);
        if (count($indicators) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }
        $jsonData = '{
			"data":[';
        for ($i = 0; $i < count($indicators); $i++) {
            /*=============================================
            We bring the target
            =============================================*/
            $item = "id";
            $value = $indicators[$i]["idTarget"];
            $target = ControllerTargetUniversita::ctrShowTargetsUniversita($item, $value);
            $objective = ControllerObjectivesUniversita::ctrShowObjUni("id", $target["idObjectiveUniversita"]);
            $plan = ControllerPlans::ctrShowPlans("id", $objective["idPlan"]);
            $completion = $indicators[$i]["completion"];
            /*=============================================
            ACTION BUTTONS
            ============================================*/
            $bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuemin='0' aria-valuemax='100' style='width:" . $indicators[$i]['completion'] . "%'> $completion %</div></div>";
            $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditIndicatorUniversita' idIndicator='" . $indicators[$i]["id"] . "' data-toggle='modal' data-target='#modalEditIndicatorUniversita'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteIndicatorUniversita' idIndicator='" . $indicators[$i]["id"] . "'><i class='fa fa-times'></i></button></div>";
            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $plan["title"] . '",
						"' . $objective["title"] . '",
						"' . $target["name"] . '",
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
$activateIndicators = new IndicatorsUniversitaTable();
$activateIndicators->showIndicatorsUniversitaTable();
