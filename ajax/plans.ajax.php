<?php

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

class AjaxPlans
{
    /*=============================================
    EDIT PLANS
    =============================================*/
    public $idPlan;

    public function ajaxEditPlan()
    {
        $item = "id";
        $valor = $this->idPlan;
        $answer = ControllerPlans::ctrShowPlans($item, $valor);
        echo json_encode($answer);
    }
}

/*=============================================
EDIT PLANS
=============================================*/
if (isset($_POST["idPlan"])) {
    $plan = new AjaxPlans();
    $plan->idPlan = $_POST["idPlan"];
    $plan->ajaxEditPlan();
}
