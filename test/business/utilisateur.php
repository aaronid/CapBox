<?php
require("business/role.php");

class Utilisateur {
	
	var $login;
	var $password;
	var $codeRole;
	var $role;
	var $tableName;
	
	function Utilisateur() {
		$this->tableName = "utilisateur";
	}
	
	function findByLogin($login, $password) {
		$sql = "select LOGIN, PASSWORD, CODE_ROLE from " . $this->tableName . " where LOGIN = '" . $login . "' and PASSWORD = '" . md5($password) . "'";
		$query = mysql_query($sql);
		if (mysql_num_rows($query) == 1) {
			$this->login = mysql_result($query, 0, "LOGIN");
			$this->password = mysql_result($query, 0, "PASSWORD");
			$this->codeRole = mysql_result($query, 0, "CODE_ROLE");
			
			$this->role = new Role();
			$this->role->findByCode($this->codeRole);
		}
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (LOGIN, PASSWORD, CODE_ROLE) " 
				. "values ('" . $this->login . "', '" . md5($this->password) . "', '" . $this->codeRole . "')";
		mysql_query($sql);
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set PASSWORD = '" . md5($this->password) . "', CODE_ROLE = '" . $this->codeRole . "' where LOGIN = '" . $this->login . "'";
		$query = mysql_query($sql);
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where LOGIN = '" . $this->login . "'";
		$query = mysql_query($sql);
	}
	
}
?>