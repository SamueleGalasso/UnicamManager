<?php

require_once "../controllers/areas.controller.php";
require_once "../models/areas.model.php";

class AjaxArea
{
    /*=============================================
    EDIT Area
    =============================================*/
    public $idArea;

    public function ajaxEditArea()
    {
        $item = "id";
        $value = $this->idArea;
        $answer = ControllerAreas::ctrShowAreas($item, $value);
        echo json_encode($answer);
    }
}
/*=============================================
EDIT Area
=============================================*/
if (isset($_POST["idArea"])) {
    $Area = new AjaxArea();
    $Area->idArea = $_POST["idArea"];
    $Area->ajaxEditArea();
}