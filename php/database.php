<?php
/**
 * Contient les fonctions pour accéder à la base de données
 */
require_once "config.php";

function  getConnexion(){
    static $myDb = null;
    if($myDb === null){
        try{
            $myDb = new PDO(
            "mysql:host=". DB_HOST. ";dbname=". DB_NAME. ";charset=utf8",
            DB_USER, DB_PASSWORD
            );
            $myDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myDb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(PDOException $e){
            die("Erreur :" .$e->getMessage());
        }
    }
    return $myDb;
}