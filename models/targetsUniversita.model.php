<?php

require_once "connection.php";


class TargetUniversitaModel
{
    /*=============================================
	SHOWING targets
	=============================================*/

    static public function mdlShowTargetsUniversita($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY idObjectiveUniversita");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    EDITING Target
    =============================================*/
    static public function mdlEditTargetUniversita($data)
    {
        $stmt = Connection::connect()->prepare("UPDATE targetsuniversita SET name = :name, idObjectiveUniversita = :idObiettivo, description = :description, weight = :weight WHERE id = :id");
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":idObiettivo", $data["idObiettivo"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }


    /*=============================================
	CREATE Target
	=============================================*/

    static public function createTargetUniversita($data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO targetsuniversita (name, idObjectiveUniversita, weight, description) VALUES (:name, :idObjectiveUniversita, :weight, :description)");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":idObjectiveUniversita", $data["idObiettivo"], PDO::PARAM_INT);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }


    /*=============================================
	DELETING Target
	=============================================*/

    static public function mdlDeleteTargetUniversita($table, $data)
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
        calcola la percentuale di completamento
        =============================================*/
    public static function mdlUpdateObjectiveCompletion($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND(SUM((indicatorsuniversita.completion*indicatorsuniversita.weight/100)*targetsuniversita.weight/100), 0)FROM indicatorsuniversita,targetsuniversita WHERE indicatorsuniversita.idTarget = targetsuniversita.id AND targetsuniversita.idObjectiveUniversita = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {

            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    /*=============================================
        calcola in modo dinamico la somma dei pesi dei target relativi ad un obiettivo
        =============================================*/
    public static function mdlCheckWeight($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM targetsuniversita WHERE idObjectiveUniversita = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {

            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlBudgetTargetUniversita($obj, $idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND((SELECT ROUND(plans.budget*objectivesuniversita.weight/100, 0) FROM plans,objectivesuniversita WHERE plans.id = :idPlan AND objectivesuniversita.id = :idObjectiveUniversita)*targetsuniversita.weight/100, 0) FROM targetsuniversita WHERE targetsuniversita.id = :idTarget");
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $obj["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":idObjectiveUniversita", $obj["id"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return 0;
        }
    }

    public static function mdlShowTargetsUniversitaByObj($idObj)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM targetsuniversita WHERE idObjectiveUniversita = :idObj");
        $stmt->bindParam(":idObj", $idObj, PDO::PARAM_INT);
        if ($stmt->execute())
            return $stmt->fetchAll();
        return [];
    }
}
