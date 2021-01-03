<?php

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

class AjaxTarget
{
    /*=============================================
       EDIT Target
       =============================================*/
    public $idTarget;

    public function ajaxEditTargets()
    {
        $item = "id";
        $value = $this->idTarget;
        $answer = controllerTarget::ctrShowTargets($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Target
=============================================*/

if (isset($_POST["idTarget"])) {
    $editTarget = new AjaxTarget ();
    $editTarget->idTarget = $_POST["idTarget"];
    $editTarget->ajaxEditTargets();
}


