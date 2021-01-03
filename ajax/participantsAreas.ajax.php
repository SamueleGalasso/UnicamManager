<?php

require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

class AjaxParticipantsAreas
{
    public $id;

    public function partipationAreaDetail()
    {
        $participation = ControllerPlans::ctrShowParticipant($this->id);
        echo json_encode($participation);
    }
}

if (isset($_POST["id"])) {
    $a = new AjaxParticipantsAreas();
    $a->id = $_POST["id"];
    $a->partipationAreaDetail();
}