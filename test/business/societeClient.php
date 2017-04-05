<?php
require("business/societeClientProspect.php");

class SocieteClient {
	
	var $id;
	var $idSociete;
	var $refClient;
	var $civilite;
	var $nom;
	var $prenom;
	var $entreprise;
	var $adresse1;
	var $adresse2;
	var $adresse3;
	var $codePostal;
	var $ville;
	var $telFix;
	var $telMob;
	var $fax;
	var $email;
	var $type;
	var $fonction;
	var $inactif;
	var $commentaire;
	var $societe;
	var $clientsProspect = array();
	var $tableName;
	
	function SocieteClient() {
		$this->tableName = "societe_client";
	}
	
	function findByLogin($id) {
		$sql = "select * from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) == 1) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->refClient = mysql_result($query, 0, "REF_CLIENT");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->entreprise = mysql_result($query, 0, "ENTREPRISE");
			$this->adresse1 = mysql_result($query, 0, "ADRESSE1");
			$this->adresse2 = mysql_result($query, 0, "ADRESSE2");
			$this->adresse3 = mysql_result($query, 0, "ADRESSE3");
			$this->codePostal = mysql_result($query, 0, "CODE_POSTAL");
			$this->ville = mysql_result($query, 0, "VILLE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->fax = mysql_result($query, 0, "FAX");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->type = mysql_result($query, 0, "TYPE");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->inactif = mysql_result($query, 0, "INACTIF");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
			
			$this->findProspect();
		}
	}
	
	function findByRefClientIdSociete($aRefClient, $anIdSociete) {
		$sql = "select * from " . $this->tableName . " where ID_SOCIETE = " . $anIdSociete . " and REF_CLIENT = '" . str_replace("'", "''", $aRefClient) . "'";
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) == 1) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
			$this->refClient = mysql_result($query, 0, "REF_CLIENT");
			$this->civilite = mysql_result($query, 0, "CIVILITE");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->prenom = mysql_result($query, 0, "PRENOM");
			$this->entreprise = mysql_result($query, 0, "ENTREPRISE");
			$this->adresse1 = mysql_result($query, 0, "ADRESSE1");
			$this->adresse2 = mysql_result($query, 0, "ADRESSE2");
			$this->adresse3 = mysql_result($query, 0, "ADRESSE3");
			$this->codePostal = mysql_result($query, 0, "CODE_POSTAL");
			$this->ville = mysql_result($query, 0, "VILLE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->fax = mysql_result($query, 0, "FAX");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->type = mysql_result($query, 0, "TYPE");
			$this->fonction = mysql_result($query, 0, "FONCTION");
			$this->inactif = mysql_result($query, 0, "INACTIF");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
			
			$this->societe = new Societe();
			$this->societe->findById($this->idSociete);
			
			$this->findProspect();
		}
	}
	
	function findProspect() {
		$sql = "select _ID from societe_client_prospect where ID_SOCIETE_CLIENT = " . $this->id . " order by _ID";
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idClientProspect = mysql_fetch_array($query)) {
			$clientProspect = new SocieteClientProspect();
			$clientProspect->findByLogin($idClientProspect["_ID"]);
			$this->clientsProspect[$idClientProspect["_ID"]] = $clientProspect;
		}
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (ID_SOCIETE, REF_CLIENT, CIVILITE, NOM, PRENOM, ENTREPRISE, ADRESSE1, ADRESSE2, ADRESSE3, CODE_POSTAL, VILLE, TEL_FIX, TEL_MOB, FAX, EMAIL, TYPE, FONCTION, INACTIF, COMMENTAIRE) " 
				. "values (" . $this->idSociete . ", '" . str_replace("'", "''", $this->refClient) . "', '" . $this->civilite . "', '" . str_replace("'", "''", $this->nom) . "', '" . str_replace("'", "''", $this->prenom) . "', '" . str_replace("'", "''", $this->entreprise) . "', '" . str_replace("'", "''", $this->adresse1) . "', '" . str_replace("'", "''", $this->adresse2) . "', '" . str_replace("'", "''", $this->adresse3) . "', '" . str_replace("'", "''", $this->codePostal) . "', '" . str_replace("'", "''", $this->ville) . "', '" . str_replace("'", "''", $this->telFix) . "', '" . str_replace("'", "''", $this->telMob) . "', '" . str_replace("'", "''", $this->fax) . "', '" . str_replace("'", "''", $this->email) . "', '" . str_replace("'", "''", $this->type) . "', '" . str_replace("'", "''", $this->fonction) . "', '" . str_replace("'", "''", $this->inactif) . "', '" . str_replace("'", "''", $this->commentaire) . "')";
		mysql_query($sql) or die(mysql_error());
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set REF_CLIENT = '" . str_replace("'", "''", $this->refClient) . "', CIVILITE = '" . $this->civilite . "', NOM = '" . str_replace("'", "''", $this->nom) . "', PRENOM = '" . str_replace("'", "''", $this->prenom) . "', ENTREPRISE = '" . str_replace("'", "''", $this->entreprise) . "', ADRESSE1 = '" . str_replace("'", "''", $this->adresse1) . "', ADRESSE2 = '" . str_replace("'", "''", $this->adresse2) . "', ADRESSE3 = '" . str_replace("'", "''", $this->adresse3) . "', CODE_POSTAL = '" . str_replace("'", "''", $this->codePostal) . "', VILLE = '" . str_replace("'", "''", $this->ville) . "', TEL_FIX = '" . str_replace("'", "''", $this->telFix) . "', TEL_MOB = '" . str_replace("'", "''", $this->telMob) . "', FAX = '" . str_replace("'", "''", $this->fax) . "', EMAIL = '" . str_replace("'", "''", $this->email) . "', TYPE = '" . str_replace("'", "''", $this->type) . "', FONCTION = '" . str_replace("'", "''", $this->fonction) . "', INACTIF = '" . str_replace("'", "''", $this->inactif) . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "' where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	static function getSocieteClientQuery($idSociete, $profil) {
		$sqlQuery = " SELECT _ID FROM societe_client WHERE ID_SOCIETE = " . $idSociete .
		       		" AND TYPE = '" . $profil . "'";
		
		return $sqlQuery;
	}
	
	static function getNbClient($idSociete) {
		$select = mysql_query(SocieteClient::getSocieteClientQuery($idSociete, '1'));
		
		return mysql_num_rows($select);
	}
	
	static function getNbFournisseur($idSociete) {
		$select = mysql_query(SocieteClient::getSocieteClientQuery($idSociete, '2'));
		
		return mysql_num_rows($select);
	}
	
	static function getNbProspect($idSociete) {
		$select = mysql_query(SocieteClient::getSocieteClientQuery($idSociete, '3'));
		
		return mysql_num_rows($select);
	}
	
}
?>