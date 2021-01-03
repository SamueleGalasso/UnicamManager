<?php

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

class AjaxObjectivesUniversita
{
    /*=============================================
       EDIT Objective
       =============================================*/

    public $idObjective;

    public function ajaxEditObjectivesUniversita()
    {
        $item = "id";
        $value = $this->idObjective;
        $answer = ControllerObjectivesUniversita::ctrShowObjUni($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Objectives
=============================================*/
if (isset($_POST["idObjective"])) {

    $editObjective = new AjaxObjectivesUniversita ();
    $editObjective->idObjective = $_POST["idObjective"];
    $editObjective->ajaxEditObjectivesUniversita();

}
