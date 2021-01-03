<?php

require_once "../controllers/indicatorsUniversita.controller.php";
require_once "../models/indicatorsUniversita.model.php";

class AjaxIndicatorsUniversita
{
    /*=============================================
       EDIT indicators
       =============================================*/
    public $idIndicator;

    public function ajaxEditIndicatorUniversita()
    {
        $item = "id";
        $value = $this->idIndicator;
        $answer = ControllerIndicatorsUniversita::ctrShowIndicatorsUniversita($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Indicator
=============================================*/

if (isset($_POST["idIndicator"])) {

    $editIndicator = new AjaxIndicatorsUniversita ();
    $editIndicator->idIndicator = $_POST["idIndicator"];
    $editIndicator->ajaxEditIndicatorUniversita();

}
