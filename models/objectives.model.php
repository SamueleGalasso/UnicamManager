<?php

require_once 'connection.php';

class ObjectivesModel
{

    /*=============================================
    SHOWING objective
    =============================================*/

    static public function mdlShowObjectives($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY idPlan");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    ADDING objective
    =============================================*/
    static public function mdlAddObjective($table, $data)
    {
        $db = Connection::connect();
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO $table(idArea, idPlan, description, weight, title) 
                                    VALUES (:idArea, :idPlan, :description, :weight, :title)");
        $stmt->bindParam(":idPlan", $data["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $data["idArea"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            $idObjective = $db->lastInsertId();
            $ids = implode(",", array_map(function ($row) {
                return "($row, :idObjective)";
            }, $data["idsObjectiveUniversita"]));
            $stmt = $db->prepare("INSERT INTO participationobjectives (idObjectiveUniversita, idObjective) VALUES $ids");
            $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                $db->rollBack();
                return "error";
            }
            $db->commit();
            return "ok";
        } else {
            $db->rollBack();
            return "error";
        }
    }

    /*=============================================
    EDITING Objective
    =============================================*/
    static public function mdlEditObjective($table, $data)
    {
        $old = ControllerObjectives::ctrShowObjectives("id", $data["id"]);
        $db = Connection::connect();
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE $table SET description = :description, weight = :weight, title = :title, idPlan = :idPlan, idArea = :idArea WHERE id = :id");
        $stmt->bindParam(":idArea", $data["idArea"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_STR);
        $stmt->bindParam(":idPlan", $data["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            if ($old["idPlan"] != $data["idPlan"]) {
                $stmt = $db->prepare("DELETE FROM participationobjectives WHERE idObjective = :idObjective");
                $stmt->bindParam(":idObjective", $data["id"], PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }

            $oldAreas = array_map(function ($row) {
                return $row["idObjectiveUniversita"];
            }, ObjectivesUniversitaModel::mdlShowObjectivesUniversita("participationobjectives", "idObjective", $data["id"]));
            $newAreas = $data["idObjUni"] ?: [];
            $mancanti = array_diff($oldAreas, $newAreas);
            $nuovi = array_diff($newAreas, $oldAreas);
            if (count($nuovi) > 0) {
                $str = implode(",", array_map(function ($row) {
                    return "($row, :idObjective)";
                }, $nuovi));
                $stmt = $db->prepare("INSERT INTO participationobjectives (idObjectiveUniversita, idObjective) VALUES $str");
                $stmt->bindParam(":idObjective", $data["id"], PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }
            if (count($mancanti) > 0) {
                $ids = "(" . implode(",", $mancanti) . ")";
                $stmt = $db->prepare("DELETE FROM participationobjectives WHERE idObjectiveUniversita IN $ids AND idObjective = :idObjective");
                $stmt->bindParam(":idObjective", $data["id"], PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }

            $db->commit();
            return "ok";
        } else {
            $db->rollBack();
            return "error";
        }
    }

    /*=============================================
    DELETING objective
    =============================================*/

    static public function mdlDeleteObjective($table, $data)
    {
        $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(":id", $data, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
        calcola in modo dinamico il peso delle azioni organizzative relative ad un obiettivo
        =============================================*/
    public static function mdlCheckWeight($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM objectives WHERE idObjectiveUniversita = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    /*=============================================
        mostra le azioni filtrate per area amministrativa
        =============================================*/
    public static function mdlShowObjectivesByArea($idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM objectives WHERE idArea = :idArea");
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*=============================================
        conta il numero totale di azioni
        =============================================*/
    public static function ctrTotalObjectives()
    {
        $stmt = Connection::connect()->prepare("SELECT COUNT(*) FROM objectives");
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlShowBudget($idPlan, $idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT budget FROM participationareas WHERE idPlan = :idPlan AND idArea = :idArea");
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlWeightSum($idPlan, $idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(objectives.weight) FROM objectives WHERE objectives.idArea = :idArea AND objectives.idPlan = :idPlan");
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlShowParticipations($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM participationobjectives WHERE idObjective = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return "error";
        }
    }

    public static function mdlShowBudgetObjective($idPlan, $idArea, $idObj)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND( participationareas.budget*objectives.weight/100 ,0) FROM participationareas,objectives WHERE participationareas.idPlan = :idPlan  AND participationareas.idArea= :idArea  AND objectives.id = :idObjective");
        $stmt->bindParam(":idObjective", $idObj, PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return 0;
        }
    }

    public static function mdlShowObjectivesByPlan($idPlan)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM objectives WHERE idPlan = :idPlan");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute())
            return $stmt->fetchAll();
        return [];
    }


}