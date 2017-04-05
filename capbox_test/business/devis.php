<?php
require("business/groupeDevis.php");

class Devis {
	
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
	var $acompte;
	var $validation;
	var $groupes = array();
	var $totauxTva = array();
	var $tableName;
	
	function Devis() {
		$this->tableName = "devis";
		$this->remise = "0.00";
		$this->acompte = "0.00";
		$this->validation = 0;
	}
	
	function findById($id) {
		$sql = "select _ID, REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE, VALIDATION from " . $this->tableName . " where _ID = " . $id;
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
		$this->acompte = mysql_result($query, 0, "ACOMPTE");
		$this->validation = mysql_result($query, 0, "VALIDATION");
		
		$this->findGroupes();
	}
	
	function findGroupes() {
		$sql = "select _ID from groupe_devis where DEVIS = " . $this->id;
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idGroupe = mysql_fetch_array($query)) {
			$groupe = new GroupeDevis();
			$groupe->findById($idGroupe["_ID"]);
			$this->groupes[$idGroupe["_ID"]] = $groupe;
		}
	}
	
	function addGroupe() {
		$groupe = new GroupeDevis();
		$groupe->idDevis = $this->id;
		return $groupe;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE, VALIDATION) " 
				. "values ('" . $this->reference . "', '" . $this->idSociete . "', '" . $this->idSocieteClient . "', '" . str_replace("'", "''", $this->titre) . "', '" . $this->dateEmission . "', '" . $this->dateValidite . "', '" . $this->idSocieteContact . "', '" . str_replace("'", "''", $this->commentaire) . "', '" . $this->remise . "', '" . $this->acompte . "', " . $this->validation . ")";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set REFERENCE = '" . $this->reference . "', ID_SOCIETE_CLIENT = '" . $this->idSocieteClient . "', DATE_EMISSION = '" . $this->dateEmission . "', DATE_VALIDITE = '" . $this->dateValidite . "', TITRE = '" . str_replace("'", "''", $this->titre) . "', ID_SOCIETE_CONTACT = '" . $this->idSocieteContact . "', REMISE = '" . $this->remise . "', ACOMPTE = '" . $this->acompte . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "', VALIDATION = " . $this->validation . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function delete() {
		foreach ($this->groupes as $groupe) {
			$groupe->delete();
		}
		$sql = "delete from " . $this->tableName . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function validate() {
		$sql = "update " . $this->tableName . " set VALIDATION = '1' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function transformToFacture() {
		$newFacture = new Facture();
		$newFacture->refDevis = $this->reference;
		$newFacture->idSocieteContact = $this->idSocieteContact;
		$newFacture->titre = $this->titre;
		$newFacture->idSociete = $this->idSociete;
		$newFacture->idSocieteClient = $this->idSocieteClient;
		$newFacture->commentaire = $this->commentaire;
		$newFacture->remise = $this->remise;
		foreach (Tva::findAll() as $tva) {
			if ($tva->isActif) {
				$this->getTvaPrice($tva->id);
			}
		}
		
		if (!empty($this->acompte) && $this->acompte != 0) {
			$newFacture->acompte = $this->getAcomptePriceTTC();
		}
		
		foreach ($this->groupes as $groupe) {
			$newGroupeFacture = $groupe->transformToGroupeFacture();
			$newFacture->groupes[$newGroupeFacture->id] = $newGroupeFacture;
		}
		
		return $newFacture;
	}
	
	function getHTPrice() {
		$htPrice = 0;
		foreach ($this->groupes as $groupe) {
			$htPrice = $htPrice + $groupe->getHTPrice();
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
		foreach ($this->groupes as $groupe) {
			$tvaPrice = $tvaPrice + $groupe->getTvaPrice($tauxTva);
		}
		$tvaPrice = $tvaPrice * (1 - ($this->remise / 100));
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

	function getAcomptePriceTTC() {
		return $this->getTTCPrice() * $this->acompte / 100;
	}

	function getTotalMarge() {
		$totalMarge = 0;
		foreach ($this->groupes as $groupe) {
			$totalMarge = $totalMarge + $groupe->getMargeEuro();
		}
		return $totalMarge;
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

	function getAcomptePriceTTCFormat() {
		return number_format($this->getAcomptePriceTTC(), 2, ",", " ");
	}

	function getAcompteFormat() {
		return number_format($this->acompte, 2, ",", " ");
	}

	function getRemiseFormat() {
		return number_format($this->remise, 2, ",", " ");
	}

	function getTotalMargeFormat() {
		return number_format($this->getTotalMarge(), 2, ",", " ");
	}

	static function findByDestinataireEmetteur($destinataire, $emetteur) {
		$sql = "select _ID from devis where ID_SOCIETE_CLIENT = '" . $destinataire . "' and ID_SOCIETE = '" . $emetteur . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$devisTab = array();
		while ($aDevisId = mysql_fetch_array($query)) {
			$devis = new Devis();
			$devis->findById($aDevisId['_ID']);
			$devisTab[$devis->id] = $devis;
		}
		return $devisTab;
	}
	
	static function getDevisQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $validateOnly) {
		$sqlQuery = " SELECT _ID FROM devis WHERE ID_SOCIETE = " . $idSociete .
		       		" AND DATE_EMISSION >= '" . $dateDebPeriodeSql . "'" .
       				" AND DATE_EMISSION <= '" . $dateFinPeriodeSql . "'";
		if ($validateOnly) {
			$sqlQuery = $sqlQuery . " AND VALIDATION = '1'";
		}
		
		return $sqlQuery;
	}
	
	static function getNbDevis($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Devis::getDevisQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
		return mysql_num_rows($select);
	}
	
	static function getNbDevisValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Devis::getDevisQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
		return mysql_num_rows($select);
	}
	
	static function getTauxReussite($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$tauxReussite = 0;
		$nbDevis = Devis::getNbDevis($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql);
		if ($nbDevis > 0) {
			$tauxReussite = Devis::getNbDevisValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) /$nbDevis  * 100;
		}
		return number_format($tauxReussite, 2, ",", " ");;
	}
	
	static function getMontantTotalDevis($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Devis::getDevisQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$devis = new Devis();
			$devis->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $devis->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Devis::calculTvaPrice($devis);
				$ca = $ca + $devis->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function getMontantTotalDevisValidee($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Devis::getDevisQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$devis = new Devis();
			$devis->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $devis->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Devis::calculTvaPrice($devis);
				$ca = $ca + $devis->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function calculTvaPrice($devis) {
		$allTva = Tva::findAll();
		foreach ($allTva as $tva) {
			$devis->getTvaPrice($tva->id);
		}
	}
	
}
?>