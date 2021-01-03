<?php

require_once 'connection.php';

class ObjectivesUniversitaModel
{
    /*=============================================
    SHOWING objective
    =============================================*/
    static public function mdlShowObjectivesUniversita($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY idPlan");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    static public function mdlShowObjUni($item, $value)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM objectivesuniversita WHERE $item = :$item");
        $stmt->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function mdlShowObjUniByObjective($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT objectivesuniversita.* FROM participationobjectives, objectivesuniversita WHERE idObjective = :idObjective AND idObjectiveUniversita = objectivesuniversita.id");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute())
            return $stmt->fetchAll();
        return [];
    }

    /*=============================================
    ADDING objective
    =============================================*/
    static public function mdlAddObjectiveUniversita($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $table(idPlan, description, weight, title) VALUES (:idPlan, :description, :weight, :title)");
        $stmt->bindParam(":idPlan", $data["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    EDITING Objective
    =============================================*/
    static public function mdlEditObjectiveUniversita($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table SET idPlan = :idPlan, description = :description, weight = :weight, title = :title WHERE id = :id");
        $stmt->bindParam(":idPlan", $data["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":title", $data["title"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    DELETING objective
    =============================================*/

    static public function mdlDeleteObjectiveUniversita($table, $data)
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
        calcola in modo dinamico il peso degli obiettivi relativi ad un piano annuale
        =============================================*/
    public static function mdlCheckWeight($idPlan)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM objectivesuniversita WHERE idPlan = :idPlan");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlBudgetObjectiveUniversita($idPlan, $idObjectiveUniversita)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND(plans.budget*objectivesuniversita.weight/100, 0) FROM plans,objectivesuniversita WHERE plans.id = :idPlan AND objectivesuniversita.id = :idObjectiveUniversita");
        $stmt->bindParam(":idPlan", $idPlan, PDO::PARAM_INT);
        $stmt->bindParam(":idObjectiveUniversita", $idObjectiveUniversita, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return 0;
        }
    }
}