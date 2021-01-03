<?php
require_once "../controllers/targetsUniversita.controller.php";
require_once "../models/targetsUniversita.model.php";

class AjaxTargetUniversita
{
    /*=============================================
       EDIT Target Universita
       =============================================*/
    public $idTarget;

    public function ajaxEditTargetsUniversita()
    {
        $item = "id";
        $value = $this->idTarget;
        $answer = ControllerTargetUniversita::ctrShowTargetsUniversita($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Target
=============================================*/

if (isset($_POST["idTarget"])) {
    $editTarget = new AjaxTargetUniversita ();
    $editTarget->idTarget = $_POST["idTarget"];
    $editTarget->ajaxEditTargetsUniversita();
}

