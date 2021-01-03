<?php

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

class AjaxParticipants
{
    public $id;

    public function partipationDetail()
    {
        $participation = ControllerTarget::ctrShowParticipants("id", $this->id);
        echo json_encode($participation);
    }
}

if (isset($_POST["id"])) {
    $a = new AjaxParticipants();
    $a->id = $_POST["id"];
    $a->partipationDetail();
}