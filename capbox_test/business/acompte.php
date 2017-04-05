<?php
class Acompte {
	static $TYPE_ACOMPTE_BASIC = "BAS";
	static $TYPE_ACOMPTE_POURCENTAGE = "POU";
	static $TYPE_ACOMPTE_AVANCEMENT = "AVA";
	
	var $id;
	var $reference;
	var $idSociete;
	var $idFacture;
	var $idSocieteClient;
	var $titre;
	var $dateEmission;
	var $dateValidite;
	var $idSocieteContact;
	var $commentaire;
	var $validation;
	var $pourcent;
	var $totalTTC;
	var $tableName;
	
	function Acompte() {
		$this->tableName = "acompte";
		$this->pourcent = "0.00";
		$this->totalTTC = "0.00";
	}
	
	function findById($idRef) {
		$sql = "select * from " . $this->tableName . " where _ID = '" . $idRef . "'";
		$query = mysql_query($sql);
		$this->id = mysql_result($query, 0, "_ID");
		$this->reference = mysql_result($query, 0, "REFERENCE");
		$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
		$this->idFacture = mysql_result($query, 0, "FACTURE");
		$this->titre = mysql_result($query, 0, "TITRE");
		$this->dateEmission = mysql_result($query, 0, "DATE_EMISSION");
		$this->dateValidite = mysql_result($query, 0, "DATE_VALIDITE");
		$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
		$this->validation = mysql_result($query, 0, "VALIDATION");
		$this->pourcent = mysql_result($query, 0, "POURCENT");
		$this->totalTTC = mysql_result($query, 0, "TOTAL_TTC");
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (REFERENCE, ID_SOCIETE, FACTURE, TITRE, DATE_EMISSION, DATE_VALIDITE, COMMENTAIRE, POURCENT, TOTAL_TTC) " 
				. "values ('" . $this->reference . "', '" . $this->idSociete . "', '" . $this->idFacture . "',  '" . str_replace("'", "''", $this->titre) . "', '" . $this->dateEmission . "', '" . $this->dateValidite . "', '" . str_replace("'", "''", $this->commentaire) . "', '" . $this->pourcent . "', '" . $this->totalTTC . "')";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set REFERENCE = '" . $this->reference . "', DATE_EMISSION = '" . $this->dateEmission . "', DATE_VALIDITE = '" . $this->dateValidite . "', TITRE = '" . str_replace("'", "''", $this->titre) . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "', POURCENT = '" . $this->pourcent . "', TOTAL_TTC = '" . $this->totalTTC . "' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function validate() {
		$sql = "update " . $this->tableName . " set DATE_VALIDITE = NOW(), VALIDATION = '1' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function getPourcentFormat() {
		return number_format($this->pourcent, 2, ",", " ");
	}

	function getMontant() {
		return $this->totalTTC;
	}

	function getMontantFormat() {
		return number_format($this->totalTTC, 2, ",", " ");
	}

	static function findByFacture($idFacture) {
		$sql = "select _ID from acompte where FACTURE = '" . $idFacture . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$acompteTab = array();
		while ($aAcompteId = mysql_fetch_array($query)) {
			$acompte = new Acompte();
			$acompte->findById($aAcompteId['_ID']);
			$acompteTab[$acompte->id] = $acompte;
		}
		return $acompteTab;
	}
	
}
?>