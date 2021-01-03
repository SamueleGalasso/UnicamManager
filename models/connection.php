<?php

class Connection
{
    public static function connect()
    {
        $link = new PDO("mysql:host=localhost:3306;dbname=unicam_manager", "root", "");
        $link->exec("set names utf8");
        return $link;
    }
}