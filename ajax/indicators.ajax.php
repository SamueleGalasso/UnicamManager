<?php

require_once "../controllers/indicators.controller.php";
require_once "../models/indicators.model.php";

class AjaxIndicators
{
    /*=============================================
       EDIT indicators
       =============================================*/
    public $idIndicator;

    public function ajaxEditIndicator()
    {
        $item = "id";
        $value = $this->idIndicator;
        $answer = ControllerIndicators::ctrShowIndicators($item, $value);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT Indicator
=============================================*/

if (isset($_POST["idIndicator"])) {

    $editIndicator = new AjaxIndicators ();
    $editIndicator->idIndicator = $_POST["idIndicator"];
    $editIndicator->ajaxEditIndicator();

}
