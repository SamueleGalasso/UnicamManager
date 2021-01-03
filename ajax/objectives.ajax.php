<?php

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

class AjaxObjectives
{
    /*=============================================
       EDIT Objective
       =============================================*/
    public $idObjective;

    public function ajaxEditObjectives()
    {
        $item = "id";
        $value = $this->idObjective;
        $answer = controllerObjectives::ctrShowObjectives($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Objectives
=============================================*/

if (isset($_POST["idObjective"])) {

    $editObjective = new AjaxObjectives ();
    $editObjective->idObjective = $_POST["idObjective"];
    $editObjective->ajaxEditObjectives();

}

