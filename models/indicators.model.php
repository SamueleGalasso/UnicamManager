<?php

require_once 'connection.php';

class IndicatorsModel
{
    /*=============================================
    calcola in modo dinamico la percentuale di completamento
    =============================================*/
    static public function mdlTargetCompletion($idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND (SUM(completion*weight/100), 0) FROM indicators WHERE idTarget = :idTarget");
        $stmt->bindParam("idTarget", $idTarget, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /*=============================================
        calcola in modo dinamico la premialità
        =============================================*/
    static public function mdlTargetPremialita($idTarget, $idDipendente, $obj)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND (((SELECT SUM(completion*weight/100) FROM indicators WHERE idTarget = :idTarget)*
               (SELECT ROUND((SELECT ROUND( participationareas.budget*objectives.weight/100 ,0) FROM participationareas,objectives 
               WHERE participationareas.idPlan = :idPlan  AND participationareas.idArea= :idArea  AND objectives.id = :idObjective)*targets.weight/100,0) FROM targets WHERE targets.id = :idTarget)
                   /100*contributo/100),0) FROM targets, participation
      WHERE targets.id = participation.idTarget AND targets.id = :idTarget AND participation.idDipendente = :idDipendente");
        $stmt->bindParam("idTarget", $idTarget, PDO::PARAM_INT);
        $stmt->bindParam("idDipendente", $idDipendente, PDO::PARAM_INT);
        $stmt->bindParam(":idObjective", $obj["id"], PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $obj["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $obj["idArea"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return 0;
        }
    }

    /*=============================================
    SHOWING indicators
    =============================================*/

    static public function mdlShowIndicators($table, $item, $value)
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
    static public function mdlAddIndicator($table, $data)
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
    public static function mdlDeleteIndicator($table, $data)
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
    public static function mdlEditIndicator($table, $data)
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
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM indicators WHERE idTarget = :idTarget");
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    /*=============================================
        mostra gli indicatori filtrati per area amministrativa
        =============================================*/
    public static function mdlShowIndicatorsByArea($idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT indicators.* FROM indicators,targets,objectives WHERE indicators.idTarget = targets.id AND targets.idObjective = objectives.id AND objectives.idArea = :idArea");
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public static function mdlShowIndicatorsByTarget($idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM indicators WHERE idTarget = :idTarget");
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

}
