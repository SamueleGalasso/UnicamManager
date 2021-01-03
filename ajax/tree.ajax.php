<?php
require_once "../controllers/plans.controller.php";
require_once "../models/plans.model.php";

require_once "../controllers/objectivesUniversita.controller.php";
require_once "../models/objectivesUniversita.model.php";

require_once "../controllers/objectives.controller.php";
require_once "../models/objectives.model.php";

require_once "../controllers/targetsUniversita.controller.php";
require_once "../models/targetsUniversita.model.php";

require_once "../controllers/targets.controller.php";
require_once "../models/targets.model.php";

require_once "../controllers/indicatorsUniversita.controller.php";
require_once "../models/indicatorsUniversita.model.php";

require_once "../controllers/indicators.controller.php";
require_once "../models/indicators.model.php";

class TreeAjax
{

    public static function getPlans()
    {
        return [
            "text" => "Piani Annuali",
            "parent" => "#",
            "data" => ["url" => "plans"],
            "children" => array_map(function ($e) {
                return [
                    "id" => $e["id"],
                    "text" => $e["title"],
                    "data" => ["url" => "plans?id=$e[id]"],
                    "children" => [
                        ["text" => "Azioni Organizzative", "data" => ["url" => "objectives"], "children" => true, "depth" => 0],
                        ["text" => "Obiettivi", "data" => ["url" => "objectivesUniversita"], "children" => true, "depth" => 1]
                    ]
                ];
            }, ControllerPlans::ctrShowPlans(null, null))];
    }

    public static function getObjectivesUniversitaByPlan($idPlan)
    {
        return array_map(function ($e) use ($idPlan) {
            return [
                "id" => $e["id"],
                "text" => $e["title"],
                "data" => ["url" => "objectivesUniversita"],
                "children" => [["text" => "Target Università", "data" => ["url" => "targetsUniversita"], "children" => true, "depth" => 2]]
            ];
        }, ControllerObjectivesUniversita::ctrShowObjectivesUniversita("idPlan", $idPlan));
    }

    public static function getObjectivesByPlan($idPlan)
    {
        return array_map(function ($e) use ($idPlan) {
            return [
                "id" => $e["id"],
                "text" => $e["title"],
                "data" => ["url" => "objectives?id=$e[id]"],
                "children" => [["text" => "Target", "data" => ["url" => "targets"], "children" => true, "depth" => 3]]
            ];
        }, ControllerObjectives::ctrShowObjectivesByPlan($idPlan));
    }

    public static function getTargetsUniversitaByObj($idObj)
    {
        return array_map(function ($e) use ($idObj) {
            return [
                "id" => $e["id"],
                "text" => $e["name"],
                "data" => ["url" => "targetsUniversita"],
                "children" => [["text" => "Indicatori Università", "data" => ["url" => "indicatorsUniversita"], "children" => true, "depth" => 4]]
            ];
        }, ControllerTargetUniversita::ctrShowTargetsUniversitaByObj($idObj));
    }

    public static function getTargetsByObj($idObj)
    {
        return array_map(function ($e) use ($idObj) {
            return [
                "id" => $e["id"],
                "text" => $e["name"],
                "data" => ["url" => "targets?id=$e[id]"],
                "children" => [["text" => "Indicatori", "data" => ["url" => "indicators"], "children" => true, "depth" => 5]]
            ];
        }, ControllerTarget::ctrShowTargetsByObj($idObj));
    }

    public static function getIndicatorUniversitaByTarget($idTarget)
    {
        return array_map(function ($e) use ($idTarget) {
            return ["id" => $e["id"], "text" => $e["name"], "data" => ["url" => "indicatorsUniversita"]];
        }, ControllerIndicatorsUniversita::ctrShowIndicatorsUniversitaByTarget($idTarget));
    }

    public static function getIndicatorByTarget($idTarget)
    {
        return array_map(function ($e) use ($idTarget) {
            return ["id" => $e["id"], "text" => $e["name"], "data" => ["url" => "indicators"]];
        }, ControllerIndicators::ctrShowIndicatorsByTarget($idTarget));
    }

}

if (isset($_GET["list"])) {
    echo json_encode(TreeAjax::getPlans());
    return;
}
if (isset($_GET["idPlanObj"])) {
    echo json_encode(TreeAjax::getObjectivesUniversitaByPlan($_GET["idPlanObj"]));
    return;
}
if (isset($_GET["idPlan"])) {
    echo json_encode(TreeAjax::getObjectivesByPlan($_GET["idPlan"]));
    return;
}

if (isset($_GET["idObjUni"])) {
    echo json_encode(TreeAjax::getTargetsUniversitaByObj($_GET["idObjUni"]));
    return;
}

if (isset($_GET["idObj"])) {
    echo json_encode(TreeAjax::getTargetsByObj($_GET["idObj"]));
    return;
}

if (isset($_GET["idTargetUni"])) {
    echo json_encode(TreeAjax::getIndicatorUniversitaByTarget($_GET["idTargetUni"]));
    return;
}
if (isset($_GET["idTarget"])) {
    echo json_encode(TreeAjax::getIndicatorByTarget($_GET["idTarget"]));
    return;
}