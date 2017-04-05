<?php
require("business/profil.php");
require("business/societe.php");
require("business/societeClient.php");
require("business/utilisateur.php");

class SocieteContact {
	
	var $id;
	var $idSociete;
	var $codeProfil;
	var $login;
	var $civilite;
	var $nom;
	var $prenom;
	var $initiale;
	var $telFix;
	var $telMob;
	var $email;
	var $fonction;
	var $commentaire;
	var $societe;
	var $tableName;
	
	function SocieteContact() {
		$this->tableName = "societe_contact";
	}
	
	function findByLogin($login) {
		$sql = "select _ID, ID_SOCIETE, CODE_PROFIL, LOGIN, CIVILITE, NOM, PRENOM, INITIALE, TEL_FIX, TEL_MOB, EMAIL, FONCTION, COMMENTAIRE from " . $this->tableName . " where LOGIN = '" . $login . "'";
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) == 1) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->codeProfil = mysql_result($query, 0, "CODE_PROFIL");
			$this->login = mysql_result($query, 0, "LOGIN");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->initiale = mysql_result($query, 0, "INITIALE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
		}
	}
	
	function findById($id) {
		$sql = "select _ID, ID_SOCIETE, CODE_PROFIL, LOGIN, CIVILITE, NOM, PRENOM, INITIALE, TEL_FIX, TEL_MOB, EMAIL, FONCTION, COMMENTAIRE from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql) or die(mysql_error());
		$this->id = mysql_result($query, 0, "_ID");
		$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
		$this->codeProfil = mysql_result($query, 0, "CODE_PROFIL");
		$this->login = mysql_result($query, 0, "LOGIN");
		$this->civilite = mysql_result($query, 0, "CIVILITE");
		$this->nom = mysql_result($query, 0, "NOM");
		$this->prenom = mysql_result($query, 0, "PRENOM");
		$this->initiale = mysql_result($query, 0, "INITIALE");
		$this->telFix = mysql_result($query, 0, "TEL_FIX");
		$this->telMob = mysql_result($query, 0, "TEL_MOB");
		$this->email = mysql_result($query, 0, "EMAIL");
		$this->fonction = mysql_result($query, 0, "FONCTION");
		$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
		
		$this->societe = new Societe();
		$this->societe->findById($this->idSociete);
	}
	
	function findResponsableSociete($idSociete) {
		$sql = "select soco.* from " . $this->tableName . " soco, utilisateur uti where uti.CODE_ROLE = '" . Role::$CODE_ENTREPRENEUR . "' AND uti.LOGIN = soco.LOGIN AND soco.ID_SOCIETE = " . $idSociete;
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) > 0) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->codeProfil = mysql_result($query, 0, "CODE_PROFIL");
			$this->login = mysql_result($query, 0, "LOGIN");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->initiale = mysql_result($query, 0, "INITIALE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
		}
	}
	
	function findProspectSocieteContact($idSociete) {
		$sql = "select soco.* from " . $this->tableName . " soco where soco.ID_SOCIETE = " . $idSociete . " AND soco.CODE_PROFIL = '" . Profil::$CODE_PROSPECT . "'";
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) > 0) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->codeProfil = mysql_result($query, 0, "CODE_PROFIL");
			$this->login = mysql_result($query, 0, "LOGIN");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->initiale = mysql_result($query, 0, "INITIALE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
		}
	}
	
	function findByEmail($email) {
		$sql = "select soco.* from " . $this->tableName . " soco where EMAIL = " . $email;
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) > 0) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->codeProfil = mysql_result($query, 0, "CODE_PROFIL");
			$this->login = mysql_result($query, 0, "LOGIN");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->initiale = mysql_result($query, 0, "INITIALE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
		}
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (ID_SOCIETE, CODE_PROFIL, LOGIN, CIVILITE, NOM, PRENOM, INITIALE, TEL_FIX, TEL_MOB, EMAIL, FONCTION, COMMENTAIRE) " 
				. "values ('" . $this->idSociete . "', '" . $this->codeProfil . "', '" . $this->login . "', '" . str_replace("'", "''", $this->civilite) . "', '" . str_replace("'", "''", $this->nom) . "', '" . str_replace("'", "''", $this->prenom) . "', '" . str_replace("'", "''", $this->initiale) . "', '" . str_replace("'", "''", $this->telFix) . "', '" . str_replace("'", "''", $this->telMob) . "', '" . str_replace("'", "''", $this->email) . "', '" . str_replace("'", "''", $this->fonction) . "', '" . str_replace("'", "''", $this->commentaire) . "')";
		mysql_query($sql) or die(mysql_error());
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set ID_SOCIETE = '" . $this->idSociete . "', CODE_PROFIL = '" . $this->codeProfil . "', LOGIN = '" . $this->login . "', CIVILITE = '" . str_replace("'", "''", $this->civilite) . "', NOM = '" . str_replace("'", "''", $this->nom) . "', PRENOM = '" . str_replace("'", "''", $this->prenom) . "', INITIALE = '" . str_replace("'", "''", $this->initiale) . "', TEL_FIX = '" . str_replace("'", "''", $this->telFix) . "', TEL_MOB = '" . str_replace("'", "''", $this->telMob) . "', EMAIL = '" . str_replace("'", "''", $this->email) . "', FONCTION = '" . str_replace("'", "''", $this->fonction) . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "' where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function getUtilisateur() {
		$utili = new Utilisateur();
		$sql = "select utili.* from " . $utili->tableName . " utili where utili.LOGIN = '" . $this->login . "'";
		$query = mysql_query($sql) or die(mysql_error());
		$utili->login = mysql_result($query, 0, "LOGIN");
		$utili->password = mysql_result($query, 0, "PASSWORD");
		$utili->codeRole = mysql_result($query, 0, "CODE_ROLE");
		
		return $utili;
	}
	
}
?>