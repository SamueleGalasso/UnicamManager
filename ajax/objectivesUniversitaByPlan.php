<?php
require_once __DIR__ . "/../controllers/objectivesUniversita.controller.php";
require_once __DIR__ . "/../models/objectivesUniversita.model.php";

class ObjUniAjax
{
    /*=============================================
   Funzione utilizzata per recuperare tutti gli obiettivi università
    filtrati per Piano Annuale
   =============================================*/
    public static function getObjUniByPlan($idPlan, $selectedIds = [])
    {
        echo array_reduce(ControllerObjectivesUniversita::ctrShowObjectivesUniversita("idPlan", $idPlan), function ($acc, $row) use ($selectedIds) {
            if (in_array($row["id"], $selectedIds))
                return $acc . "<option selected value='$row[id]'>$row[title]</option>";
            return $acc . "<option value='$row[id]'>$row[title]</option>";
        }, "") ?: "";
    }
}

if (isset($_POST["idPlan"])) ObjUniAjax::getObjUniByPlan($_POST["idPlan"]);

