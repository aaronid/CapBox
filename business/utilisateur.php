<?php
require("business/role.php");
require("dao/BddUtils.php");

class Utilisateur {
	
	var $login;
	var $password;
	var $codeRole;
	var $role;
	var $tableName;
	
	function Utilisateur() {
		$this->tableName = "utilisateur";
	}

    /**
     * GESTION BASE DE DONNEES - TABLE UTILISATEUR
     * Sélectionner un utilisateur par son login et son mot de passe
     * @param $login
     * @param $password
     * @return null|object
     */
	function findByLogin($login, $password) {

	    try{
            $cnx = getConnection();
            $sql = "select LOGIN, PASSWORD, CODE_ROLE from "
                . $this->tableName
                . " where LOGIN = '" . $login
                . "' and PASSWORD = '" . md5($password) . "'";
            $query = mysqli_query($cnx,$sql);

            if (mysqli_num_rows($query) == 1) {
                $utilisateur = mysqli_fetch_object($query);
            }
        }catch(Exception $ex){
	        $ex->getCode().' '.$ex->getMessage();
        }
        closeConnection($cnx);
        return $utilisateur;

	}

    /**
     * GESTION BASE DE DONNEES - TABLE UTILISATEUR
     * Insertion d'un nouvel utilisateur (login, password et codeRole
     */
	function insert() {
		$sql = "insert into " . $this->tableName . " (LOGIN, PASSWORD, CODE_ROLE) " 
				. "values ('" . $this->login . "', '" . md5($this->password) . "', '" . $this->codeRole . "')";

        $cnx = getConnection();
		mysqli_query($cnx,$sql);
        closeConnection($cnx);
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set PASSWORD = '" . md5($this->password) . "', CODE_ROLE = '" . $this->codeRole . "' where LOGIN = '" . $this->login . "'";
        $cnx = getConnection();
        mysqli_query($cnx,$sql);
        closeConnection($cnx);
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where LOGIN = '" . $this->login . "'";
        $cnx = getConnection();
        mysqli_query($cnx,$sql);
        closeConnection($cnx);
	}

	
}
