<?php


require_once "connection.php";

class PlansModel
{
    /*=============================================
    CREATE PLAN
    =============================================*/

    static public function mdlAddPlan($table, $data)
    {
        $db = Connection::connect();
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO $table(title, description, budget, date) VALUES (:title, :description, :budget, :date)");
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":budget", $data["budget"], PDO::PARAM_STR);
        $stmt->bindParam(":date", $data["date"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            $id = $db->lastInsertId();
            $values = implode(",", array_map(function ($row) {
                return "(:idPlan, $row[area], $row[budget])";
            }, $data["areas"]));
            $stmt = $db->prepare("INSERT INTO participationareas (idPlan, idArea, budget) VALUES $values");
            $stmt->bindParam(":idPlan", $id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                $db->rollBack();
                return 'error';
            }
            $db->commit();
            return 'ok';
        } else {
            $db->rollBack();
            return 'error';
        }
    }

    /*=============================================
    SHOW plan
    =============================================*/

    static public function mdlShowPlans($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    EDIT PLAN
    =============================================*/

    static public function mdlEditPlan($table, $data)
    {
        $idPlan = $data["id"];
        $db = Connection::connect();
        $oldAreas = array_map(function ($participationarea) {
            return $participationarea["idArea"];
        }, ControllerPlans::ctrShowParticipants($idPlan)) ?: [];
        $previousBudget = ControllerPlans::ctrShowPlans("id", $idPlan)["budget"];
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE $table SET title = :title, description= :description, budget = :budget WHERE id = :id");
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":budget", $data["budget"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $newAreas = $data["idAreas"] ?: [];
            $mancanti = array_diff($oldAreas, $newAreas);
            $nuovi = array_diff($newAreas, $oldAreas);
            if (count($nuovi) > 0) {
                $str = implode(",", array_map(function ($row) {
                    return "($row, :idPlan)";
                }, $nuovi));
                $stmt = $db->prepare("INSERT INTO participationareas (idArea, idPlan) VALUES $str");
                $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }
            if (count($mancanti) > 0) {
                $ids = "(" . implode(",", $mancanti) . ")";
                $stmt = $db->prepare("DELETE FROM participationareas WHERE idArea IN $ids AND idPlan = :idPlan");
                $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }
            if ($previousBudget != $data["budget"]) {
                $stmt = $db->prepare("UPDATE participationareas SET budget = 0 WHERE idPlan = :idPlan");
                $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
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
    DELETE PLAN
    =============================================*/

    static public function mdlDeletePlan($table, $data)
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
        calcola in modo dinamico il totale dei budget di tutti i piani
        =============================================*/
    public static function mdlTotalBudget()
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(plans.budget) FROM plans");
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlShowParticipants($idPlan)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM participationareas WHERE participationareas.idPlan = :idPlan");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    public static function mdlShowParticipant($id)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM participationareas WHERE participationareas.id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function updateBudget($idParticipationEdit, $editBudget)
    {
        $statement = Connection::connect()->prepare("UPDATE participationareas SET budget = :budget WHERE id = :id");
        $statement->bindParam("id", $idParticipationEdit, PDO::PARAM_INT);
        $statement->bindParam("budget", $editBudget, PDO::PARAM_INT);
        if ($statement->execute()) {
            return "ok";
        }
        return "error";
    }

    public static function mdlShowParticipantByArea($idPlan, $idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM participationareas WHERE participationareas.idPlan = :idPlan AND participationareas.idArea = :idArea");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function mdlShowAreasByPlan($idPlan)
    {
        $stmt = Connection::connect()->prepare("SELECT DISTINCT areas.* FROM participationareas, areas WHERE participationareas.idPlan = :idPlan AND participationareas.idArea = areas.id");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute())
            return $stmt->fetchAll();
        return [];
    }
}