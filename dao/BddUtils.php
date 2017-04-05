<?php
/**
 * Created by Gwenaelle Ferre
 * User: lepretre
 * Date: 04/04/2017
 * Time: 15:23
 */


/**
 * Connection à une base de données
 * @return mysqli
 */
function getConnection(){

    try{
        // accés à la base de données principale
        // EN CAS DE MAINTENANCE DE LA BDD : NE PAS DECOMMENTER CETTE LIGNE
        // $cnx = new mysqli("mysql5-23.bdb", "capbox001", "3Ty3FG0O", "capbox001");

        // accès à la base de données test
        $cnx = new mysqli("localhost", "root", "", "capboxtest");

        //echo('Connection à la base de données : Succés.');
    }catch(Exception $ex){
        echo($ex->getCode().' '.getMessage());
    }

    return $cnx;
}

/**
 * Fermeture d'une connection à une base de données
 * @param $cnx
 */
function closeConnection($cnx){
    try{
        mysqli_close($cnx);

        //echo(' --- Fermeture de la connection à la base de données : Succés.');
    }catch(Exception $ex){
        echo($ex->getCode().' '.$ex->getMessage());
    }

}