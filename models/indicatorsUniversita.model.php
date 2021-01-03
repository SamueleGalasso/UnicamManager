<?php

require_once 'connection.php';

class IndicatorsUniversitaModel
{
    /*=============================================
    calcola in modo dinamico la percentuale di completamento
    =============================================*/
    static public function mdlTargetUniversitaCompletion($idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND (SUM(completion*weight/100), 0) FROM indicatorsuniversita WHERE idTarget = :idTarget");
        $stmt->bindParam("idTarget", $idTarget, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*=============================================
    SHOWING indicators
    =============================================*/

    static public function mdlShowIndicatorsUniversita($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY idTarget");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    ADDING indicator
    =============================================*/
    static public function mdlAddIndicatorUniversita($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $table(idTarget, name, weight, description) VALUES (:idTarget, :name, :weight, :description)");
        $stmt->bindParam(":idTarget", $data["idTarget"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    DELETING indicator
    =============================================*/
    public static function mdlDeleteIndicatorUniversita($table, $data)
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
    EDITING indicator
    =============================================*/
    public static function mdlEditIndicatorUniversita($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table SET idTarget = :idTarget, description = :description, weight = :weight, name = :name, completion = :completion  WHERE id = :id");
        $stmt->bindParam(":idTarget", $data["idTarget"], PDO::PARAM_INT);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":completion", $data["completion"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
        calcola in modo dinamico il peso degli indicatori relativi ad un target
        =============================================*/
    public static function mdlCheckWeight($idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM indicatorsuniversita WHERE idTarget = :idTarget");
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlShowIndicatorsUniversitaByTarget($idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM indicatorsuniversita WHERE idTarget = :idTarget");
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        if ($stmt->execute())
            return $stmt->fetchAll();
        return [];
    }

}
