<?php

require_once "connection.php";


class TargetModel
{
    /*=============================================
	SHOWING targets
	=============================================*/

    static public function mdlShowTargets($table, $item, $value)
    {
        if ($item != null) {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY idObjective");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    static public function mdlShowTargetsByObj($idObj)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM targets where idObjective = :idObjective");
        $stmt->bindParam("idObjective", $idObj, PDO::PARAM_INT);;
        return $stmt->execute() ? $stmt->fetchAll() : [];
    }

    /*=============================================
	SHOWING participants
	=============================================*/

    static public function mdlShowParticipants($table, $item, $value)
    {
        if ($item != null) {
            $stmt = (new Connection)->connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = Connection::connect()->prepare("SELECT * FROM $table");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
        aggiorna il contributo dei dipendenti
        =============================================*/
    static public function updateContributo($id, $contributo)
    {
        $statement = (new Connection)->connect()->prepare("UPDATE participation SET contributo = :contributo WHERE id = :id");
        $statement->bindParam("id", $id, PDO::PARAM_INT);
        $statement->bindParam("contributo", $contributo, PDO::PARAM_INT);
        if ($statement->execute()) {
            return "ok";
        }
        return "error";
    }

    /*=============================================
	CREATE Target
	=============================================*/

    static public function createTarget($data)
    {
        $db = Connection::connect();
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO targets (name, description, weight, idObjective) VALUES (:name, :description, :weight, :idObjective)");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":idObjective", $data["idObiettivo"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            $idTarget = $db->lastInsertId();
            $str = "";
            foreach ($data["idUtenti"] as $index => $value) {
                $str .= "($value, :idTarget)";
                if ($index != count($data["idUtenti"]) - 1) $str .= ",";
            }
            $stmt = $db->prepare("INSERT INTO participation (idDipendente, idTarget) VALUES $str");
            $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $db->commit();
                return "ok";
            } else {
                $db->rollBack();
                return "error";
            }
        } else {
            $db->rollBack();
            return "error";
        }
    }

    /*=============================================
        edit target
        =============================================*/
    static public function updateTarget($data)
    {
        $idTarget = $data["id"];
        $oldParticipants = array_map(function ($participant) {
            return $participant["idDipendente"];
        }, ControllerTarget::ctrShowParticipants("idTarget", $idTarget)) ?: [];
        $db = (new Connection)->connect();
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE targets set name = :name, description = :description, weight = :weight, idObjective = :idObjective WHERE id = :id");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $stmt->bindParam(":weight", $data["weight"], PDO::PARAM_INT);
        $stmt->bindParam(":idObjective", $data["idObiettivo"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            $newParticipants = $data["idUtenti"] ?: [];
            $mancanti = array_diff($oldParticipants, $newParticipants);
            $nuovi = array_diff($newParticipants, $oldParticipants);
            if (count($nuovi) > 0) {
                $str = implode(",", array_map(function ($row) {
                    return "($row, :idTarget)";
                }, $nuovi));
                $stmt = $db->prepare("INSERT INTO participation (idDipendente, idTarget) VALUES $str");
                $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    $db->rollBack();
                    return "error";
                }
            }
            if (count($mancanti) > 0) {
                $ids = "(" . implode(",", $mancanti) . ")";
                $stmt = $db->prepare("DELETE FROM participation WHERE idDipendente IN $ids AND idTarget = :idTarget");
                $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
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
	DELETING Target
	=============================================*/

    static public function mdlDeleteTarget($table, $data)
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
        $stmt = Connection::connect()->prepare("SELECT ROUND(SUM((indicators.completion*indicators.weight/100)*targets.weight/100), 0)FROM indicators,targets WHERE indicators.idTarget = targets.id AND targets.idObjective = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    /*=============================================
        calcola in modo dinamico la somma dei pesi dei target relativi ad un azione organizzativa
        =============================================*/
    public static function mdlCheckWeight($idObjective)
    {
        $stmt = Connection::connect()->prepare("SELECT SUM(weight) FROM targets WHERE idObjective = :idObjective");
        $stmt->bindParam(":idObjective", $idObjective, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlShowTargetsByArea($idArea)
    {
        $stmt = Connection::connect()->prepare("SELECT targets.* FROM targets, objectives WHERE targets.idObjective = objectives.id AND objectives.idArea = :idArea");
        $stmt->bindParam(":idArea", $idArea, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public static function mdlTotalParticipants()
    {
        $stmt = Connection::connect()->prepare("SELECT COUNT(*) FROM participation");
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlTotalTargets()
    {
        $stmt = Connection::connect()->prepare("SELECT COUNT(*) FROM targets");
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return "error";
        }
    }

    public static function mdlBudgetTarget($obj, $idTarget)
    {
        $stmt = Connection::connect()->prepare("SELECT ROUND((SELECT ROUND( participationareas.budget*objectives.weight/100 ,0) FROM participationareas,objectives WHERE participationareas.idPlan = :idPlan  AND participationareas.idArea= :idArea  AND objectives.id = :idObjective)*targets.weight/100,0) FROM targets WHERE targets.id = :idTarget");
        $stmt->bindParam(":idObjective", $obj["id"], PDO::PARAM_INT);
        $stmt->bindParam(":idPlan", $obj["idPlan"], PDO::PARAM_INT);
        $stmt->bindParam(":idArea", $obj["idArea"], PDO::PARAM_INT);
        $stmt->bindParam(":idTarget", $idTarget, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch();
        } else {
            return 0;
        }

    }

    public static function mdlShowTargetsByDipendente($idDipendente)
    {
        $stmt = Connection::connect()->prepare("SELECT targets.* FROM targets, participation WHERE targets.id = participation.idTarget AND participation.idDipendente = :idDipendente");
        $stmt->bindParam(":idDipendente", $idDipendente, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }
}
