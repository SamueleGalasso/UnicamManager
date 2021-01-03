<?php

require_once "connection.php";

class ModelAreas
{
    /*=============================================
    CREATE area
    =============================================*/
    static public function mdlAddArea($table, $data)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $table(name, idResponsabile) VALUES (:name, :idResponsabile)");
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":idResponsabile", $data["idResponsabile"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    SHOW area
    =============================================*/

    static public function mdlShowAreas($table, $item, $value)
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
	EDIT Area
	=============================================*/

    static public function mdlEditArea($table, $data)
    {
        $stmt = Connection::connect()->prepare("UPDATE $table SET name = :name, idResponsabile = :idResponsabile WHERE id = :id");
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindParam(":idResponsabile", $data["editResponsabile"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
	DELETE Area
	=============================================*/

    static public function mdlDeleteArea($table, $data)
    {
        $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

}