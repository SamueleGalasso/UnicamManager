<?php

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

require_once "../controllers/areas.controller.php";
require_once "../models/areas.model.php";

require_once "../controllers/indicators.controller.php";
require_once "../models/indicators.model.php";

class DipendenteInfoTable
{
    /*=============================================
      SHOW dipendente TABLE
      =============================================*/
    public function showDipendenteTable()
    {
        session_start();
        $item = null;
        $value = null;
        $targets = ControllerTarget::ctrShowTargetsByDipendente($_SESSION["id"]);
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
            $area = ControllerAreas::ctrShowAreas("id", $objective["idArea"]);
            /*=============================================
           ACTION BUTTONS
           =============================================*/
            $completion = ControllerIndicators::ctrTargetCompletion($targets[$i]["id"])[0] ?: 0;
            $premialita = ControllerIndicators::ctrTargetPremialita($targets[$i]["id"], $_SESSION["id"], $objective);
            if ($completion == null) {
                $completion = 0;
            }
            $jsonData .= '[
						"' . ($i + 1) . '",
						"' . $targets[$i]["name"] . '",
						"' . $area["name"] . '",
						"' . $objective["title"] . '",
						"' . $targets[$i]["description"] . '",
						"' . $premialita . ' €",
						"' . $completion . ' %"
					],';
        }
        $jsonData = substr($jsonData, 0, -1);
        $jsonData .= '] 
			}';
        echo $jsonData;
    }
}

/*=============================================
ACTIVATE dipendente TABLE
=============================================*/
$activateDipendente = new DipendenteInfoTable();
$activateDipendente->showDipendenteTable();