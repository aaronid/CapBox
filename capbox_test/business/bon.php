<?php
require("business/ligneBon.php");

class Bon {
	
	var $id;
	var $reference;
	var $idSociete;
	var $idSocieteClient;
	var $titre;
	var $dateEmission;
	var $dateValidite;
	var $idSocieteContact;
	var $commentaire;
	var $remise;
	var $validation;
	var $lignes = array();
	var $totauxTva = array();
	var $tableName;
	
	function Bon() {
		$this->tableName = "bon";
		$this->remise = "0.00";
	}
	
	function findById($id) {
		$sql = "select _ID, REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, VALIDATION from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$this->id = mysql_result($query, 0, "_ID");
		$this->reference = mysql_result($query, 0, "REFERENCE");
		$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
		$this->idSocieteClient = mysql_result($query, 0, "ID_SOCIETE_CLIENT");
		$this->titre = mysql_result($query, 0, "TITRE");
		$this->dateEmission = mysql_result($query, 0, "DATE_EMISSION");
		$this->dateValidite = mysql_result($query, 0, "DATE_VALIDITE");
		$this->idSocieteContact = mysql_result($query, 0, "ID_SOCIETE_CONTACT");
		$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
		$this->remise = mysql_result($query, 0, "REMISE");
		$this->validation = mysql_result($query, 0, "VALIDATION");
		
		$this->findLignes();
	}
	
	function findLignes() {
		$sql = "select _ID from ligne_bon where BON = " . $this->id;
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idLigne = mysql_fetch_array($query)) {
			$ligne = new LigneBon();
			$ligne->findById($idLigne["_ID"]);
			$this->lignes[$idLigne["_ID"]] = $ligne;
		}
	}
	
	function addLigne() {
		$ligne = new LigneBon();
		$ligne->idBon = $this->id;
		return $ligne;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE) " 
				. "values ('" . $this->reference . "', '" . $this->idSociete . "', '" . $this->idSocieteClient . "', '" . str_replace("'", "''", $this->titre) . "', '" . $this->dateEmission . "', '" . $this->dateValidite . "', '" . $this->idSocieteContact . "', '" . str_replace("'", "''", $this->commentaire) . "', '" . $this->remise . "')";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set REFERENCE = '" . $this->reference . "', ID_SOCIETE_CLIENT = '" . $this->idSocieteClient . "', DATE_EMISSION = '" . $this->dateEmission . "', DATE_VALIDITE = '" . $this->dateValidite . "', TITRE = '" . str_replace("'", "''", $this->titre) . "', ID_SOCIETE_CONTACT = '" . $this->idSocieteContact . "', REMISE = '" . $this->remise . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "', VALIDATION = '' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function delete() {
		foreach ($this->lignes as $ligne) {
			$ligne->delete();
		}
		$sql = "delete from " . $this->tableName . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function validate() {
		$sql = "update " . $this->tableName . " set DATE_VALIDITE = NOW(), VALIDATION = '1' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function getHTPrice() {
		$htPrice = 0;
		foreach ($this->lignes as $ligne) {
			$htPrice = $htPrice + $ligne->getHTPrice();
		}
		return $htPrice;
	}
	
	function getTotalRemise() {
		return $this->getHTPrice() * ($this->remise / 100);
	}
	
	function getHTPriceRemise() {
		return $this->getHTPrice() * (1 - $this->remise / 100);
	}
	
	function getTvaPrice($tauxTva) {
		$tvaPrice = 0;
		foreach ($this->lignes as $ligne) {
			if (floatval($ligne->tauxTva) == $tauxTva) {
				$tvaPrice = $tvaPrice + $ligne->getTvaPrice();
			}
		}
		$tvaPrice = $tvaPrice * (1 - $this->remise / 100);
		$this->totauxTva[$tauxTva] = $tvaPrice;
		return $tvaPrice;
	}
	
	function getTTCPrice() {
		$ttcPrice = $this->getHTPriceRemise();
		foreach ($this->totauxTva as $totalTva) {
			$ttcPrice = $ttcPrice + $totalTva;
		}
		return $ttcPrice;
	}

	function getHTPriceFormat() {
		return number_format($this->getHTPrice(), 2, ",", " ");
	}

	function getTotalRemiseFormat() {
		return number_format($this->getTotalRemise(), 2, ",", " ");
	}

	function getHTPriceRemiseFormat() {
		return number_format($this->getHTPriceRemise(), 2, ",", " ");
	}

	function getTvaPriceFormat($tauxTva) {
		return number_format($this->getTvaPrice($tauxTva), 2, ",", " ");
	}

	function getTTCPriceFormat() {
		return number_format($this->getTTCPrice(), 2, ",", " ");
	}

	function getRemiseFormat() {
		return number_format($this->remise, 2, ",", " ");
	}

	static function findByDestinataireEmetteur($destinataire, $emetteur) {
		$sql = "select _ID from bon where ID_SOCIETE_CLIENT = '" . $destinataire . "' and ID_SOCIETE = '" . $emetteur . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$bonTab = array();
		while ($aBonId = mysql_fetch_array($query)) {
			$bon = new Bon();
			$bon->findById($aBonId['_ID']);
			$bonTab[$bon->id] = $bon;
		}
		return $bonTab;
	}
	
	static function getBonQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $validateOnly) {
		$sqlQuery = " SELECT _ID FROM bon WHERE ID_SOCIETE = " . $idSociete .
		       		" AND DATE_EMISSION >= '" . $dateDebPeriodeSql . "'" .
       				" AND DATE_EMISSION <= '" . $dateFinPeriodeSql . "'";
		if ($validateOnly) {
			$sqlQuery = $sqlQuery . " AND VALIDATION = '1'";
		}
		
		return $sqlQuery;
	}
	
	static function getNbBon($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Bon::getBonQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
		return mysql_num_rows($select);
	}
	
	static function getNbBonValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Bon::getBonQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
		return mysql_num_rows($select);
	}
	
	static function getBonClos($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$tauxReussite = 0;
		$nbBon = Bon::getNbBon($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql);
		if ($nbBon > 0) {
			$tauxReussite = Bon::getNbBonValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) / $nbBon * 100;
		}
		return number_format($tauxReussite, 2, ",", " ");;
	}
	
	static function getMontantTotalBon($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Bon::getBonQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$bon = new Bon();
			$bon->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $bon->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Bon::calculTvaPrice($bon);
				$ca = $ca + $bon->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function getMontantTotalBonValidee($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Bon::getBonQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$bon = new Bon();
			$bon->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $bon->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Bon::calculTvaPrice($bon);
				$ca = $ca + $bon->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function calculTvaPrice($bon) {
		$allTva = Tva::findAll();
		foreach ($allTva as $tva) {
			$bon->getTvaPrice($tva->id);
		}
	}
	
}
?>