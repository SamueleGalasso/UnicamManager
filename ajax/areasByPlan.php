<?php
require_once __DIR__ . "/../controllers/plans.controller.php";
require_once __DIR__ . "/../models/plans.model.php";


if (session_status() === PHP_SESSION_NONE) session_start();

class AreaAjax
{
    /*=============================================
    Funziona utilizzata per filtrare le aree selezionabili
    in base al piano annuale selezionato a cui sono associate
   =============================================*/
    public static function areasByPlan($idPlan, $idArea = null)
    {
        $areas = ControllerPlans::ctrShowAreasByPlan($idPlan);
        if (is_null($_SESSION["idArea"])) {
            echo array_reduce(
                $areas,
                function ($acc, $row) use ($idArea) {
                    if (!is_null($idArea) && $row["id"] === $idArea) {
                        return $acc . "<option selected value='$row[id]'>$row[name]</option>";
                    }
                    return $acc . "<option value='$row[id]'>$row[name]</option>";
                }, ""
            ) ?: "";
        } else {
            foreach ($areas as $key => $value) {
                if ($_SESSION["idArea"] == $value["id"]) {
                    $a = $value;
                    break;
                }
            }
            if ($a) {
                echo '<option selected value="' . $a["id"] . '">' . $a["name"] . '</option>';
            }
        }
    }
}

if (isset($_POST["idPlan"]))
    AreaAjax::areasByPlan($_POST["idPlan"]);