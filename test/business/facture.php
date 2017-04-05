<?php
require("business/groupeFacture.php");
require("business/acompte.php");
require("business/avoir.php");

class Facture {
	
	var $id;
	var $idDevis;
	var $refDevis;
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
//	var $avoirs = array();
	var $tableName;
	
	function Facture() {
		$this->tableName = "facture";
		$this->remise = "0.00";
		$this->acompte = "0.00";
	}
	
	function findById($id) {
		$sql = "select _ID, DEVIS, REF_DEVIS, REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE, VALIDATION from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql);
		$this->id = mysql_result($query, 0, "_ID");
		$this->idDevis = mysql_result($query, 0, "DEVIS");
		$this->refDevis = mysql_result($query, 0, "REF_DEVIS");
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
		// $this->findAvoirs();
	}
	
	function findGroupes() {
		$sql = "select _ID from groupe_facture where FACTURE = " . $this->id;
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idGroupe = mysql_fetch_array($query)) {
			$groupe = new GroupeFacture();
			$groupe->findById($idGroupe["_ID"]);
			$this->groupes[$idGroupe["_ID"]] = $groupe;
		}
	}
	
	function findAvoirs() {
		$sql = "select _ID from avoir where FACTURE = " . $this->id;
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idAvoir = mysql_fetch_array($query)) {
			$avoir = new AvoirFacture();
			$avoir->findById($idAvoir["_ID"]);
			$this->avoirs[$idAvoir["_ID"]] = $avoir;
		}
	}
	
	function addGroupe() {
		$groupe = new GroupeFacture();
		$groupe->idFacture = $this->id;
		return $groupe;
	}
	
	function addAcompte($refAcompte, $pourcent, $totalTtcFacture) {
		$acompte = new Acompte();
		$acompte->idFacture = $this->id;
		$acompte->dateEmission = $this->dateEmission;
		$acompte->reference = $refAcompte;
		$acompte->idSociete = $this->idSociete;
		$acompte->titre = $this->titre;
		$acompte->commentaire = $this->commentaire;
		$acompte->pourcent = $pourcent;
		$acompte->totalTTC = ($totalTtcFacture * $pourcent / 100);
		$acompte->insert();
		return $acompte;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (DEVIS, REF_DEVIS, REFERENCE, ID_SOCIETE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE) " 
				. "values ('" . $this->idDevis . "', '" . $this->refDevis . "', '" . $this->reference . "', '" . $this->idSociete . "', '" . $this->idSocieteClient . "', '" . str_replace("'", "''", $this->titre) . "', '" . $this->dateEmission . "', '" . $this->dateValidite . "', '" . $this->idSocieteContact . "', '" . str_replace("'", "''", $this->commentaire) . "', '" . $this->remise . "', '" . $this->acompte . "')";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set REFERENCE = '" . $this->reference . "', ID_SOCIETE_CLIENT = '" . $this->idSocieteClient . "', DATE_EMISSION = '" . $this->dateEmission . "', DATE_VALIDITE = '" . $this->dateValidite . "', TITRE = '" . str_replace("'", "''", $this->titre) . "', ID_SOCIETE_CONTACT = '" . $this->idSocieteContact . "', REMISE = '" . $this->remise . "', ACOMPTE = '" . $this->acompte . "', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . "' where _ID = '" . $this->id . "'";
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
		$sql = "update " . $this->tableName . " set DATE_VALIDITE = NOW(), VALIDATION = '1' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
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

	function getResteAPayerTTC() {
		return $this->getTTCPrice() - $this->getTotalAcompte();
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

	function getAcompteFormat() {
		return number_format($this->acompte, 2, ",", " ");
	}

	function getRemiseFormat() {
		return number_format($this->remise, 2, ",", " ");
	}

	function getResteAPayerTTCFormat() {
		return number_format($this->getResteAPayerTTC(), 2, ",", " ");
	}

	function getTotalMargeFormat() {
		return number_format($this->getTotalMarge(), 2, ",", " ");
	}

	static function findByDestinataireEmetteur($destinataire, $emetteur) {
		$sql = "select _ID from facture where ID_SOCIETE_CLIENT = '" . $destinataire . "' and ID_SOCIETE = '" . $emetteur . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$factureTab = array();
		while ($aFactureId = mysql_fetch_array($query)) {
			$facture = new Facture();
			$facture->findById($aFactureId['_ID']);
			$factureTab[$facture->id] = $facture;
		}
		return $factureTab;
	}
	
	function getTotalAvoirHT() {
		$htPrice = 0;
		if (!empty($this->id)) {
			$avoirTab = Avoir::findByFacture($this->id);
			foreach ($avoirTab as $avoir) {
				$htPrice = $htPrice + $avoir->getHTPrice();
			}
		}
		return $htPrice;
	}
	
	function getTotalAvoir() {
		$ttcPrice = 0;
		if (!empty($this->id)) {
			$avoirTab = Avoir::findByFacture($this->id);
			foreach ($avoirTab as $avoir) {
				$ttcPrice = $ttcPrice + $avoir->getTTCPrice();
			}
		}
		return $ttcPrice;
	}
	
	function getTotalAvoirFormat() {
		return number_format($this->getTotalAvoir(), 2, ",", " ");
	}
	
	function getTotalAcompte() {
		return $this->getTotalAcompteIgnore(-1);
	}
	
	function getTotalAcompteIgnore($idAcompteIgnore) {
		$ttcPrice = 0;
		if (!empty($this->id)) {
			$acompteTab = Acompte::findByFacture($this->id);
			foreach ($acompteTab as $acompte) {
				if ($idAcompteIgnore != $acompte->id) {
					$ttcPrice = $ttcPrice + $acompte->getMontant();
				}
			}
		}
		return $ttcPrice;
	}
	
	function getTotalAcompteFormat() {
		return $this->getTotalAcompteFormatIgnore(-1);
	}
	
	function getTotalAcompteFormatIgnore($idAcompteIgnore) {
		return number_format($this->getTotalAcompteIgnore($idAcompteIgnore), 2, ",", " ");
	}
	
	static function getCACurrentYear($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getCurrentYearDateMinStr(), getCurrentYearDateMaxStr(), $typeMontant);
	}

	static function getCALastYear($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getLastYearDateMinStr(), getLastYearDateMaxStr(), $typeMontant);
	}
	
	static function getCACurrentYearCurrentMonth($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getCurrentYearCurrentMonthMinStr(), getCurrentYearCurrentMonthMaxStr(), $typeMontant);
	}
	
	static function getCACurrentYearLastMonth($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getCurrentYearLastMonthMinStr(), getCurrentYearLastMonthMaxStr(), $typeMontant);
	}
	
	static function getCACurrentYearLast2Month($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getCurrentYearLast2MonthMinStr(), getCurrentYearLast2MonthMaxStr(), $typeMontant);
	}
	
	static function getCALastYearCurrentMonth($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getLastYearCurrentMonthMinStr(), getLastYearCurrentMonthMaxStr(), $typeMontant);
	}
	
	static function getCALastYearLastMonth($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getLastYearLastMonthMinStr(), getLastYearLastMonthMaxStr(), $typeMontant);
	}
	
	static function getCALastYearLast2Month($idSociete, $typeMontant) {
		return Facture::getCAForThisPeriodStr($idSociete, getLastYearLast2MonthMinStr(), getLastYearLast2MonthMaxStr(), $typeMontant);
	}
	
	static function getCAForThisPeriod($idSociete, $beginDate, $endDate, $typeMontant) {
       	$select = mysql_query(
       		" SELECT _ID FROM facture" . 
       		" WHERE ID_SOCIETE = " . $idSociete . 
       		" AND DATE_EMISSION >= '" . $beginDate . "'" .
       		" AND DATE_EMISSION <= '" . $endDate . "'"
       	);

       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$facture = new Facture();
			$facture->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $facture->getHTPrice() - $facture->getTotalAvoirHT();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Facture::calculTvaPrice($facture);
				$ca = $ca + $facture->getTTCPrice() - $facture->getTotalAvoir();
			} else {
				$ca = $ca - 1;
			}
       		// echo "facture : " . $facture->id . " - " . $facture->getTTCPrice() . " - " . $facture->getTotalAvoir() . "\n";
		}
		$ca = $ca + Avoir::getCAForThisPeriod($idSociete, $beginDate, $endDate, $typeMontant);
		
		return $ca;
	}
	
	static function getCAForThisPeriodStr($idSociete, $beginDate, $endDate, $typeMontant) {
		$ca = Facture::getCAForThisPeriod($idSociete, $beginDate, $endDate, $typeMontant);
		return $ca;
		//return number_format($ca, 2, ",", " ");
	}
	
	static function calculFormule($idSociete, $typeMontant) {
		$curentCA = Facture::getCAForThisPeriod($idSociete, getCurrentYearDateMinStr(), getCurrentYearDateMaxStr(), $typeMontant);
		$lastCA = Facture::getCAForThisPeriod($idSociete, getLastYearDateMinStr(), getLastYearDateMaxStr(), $typeMontant);
		
		$resultForm = ($curentCA - $lastCA) / $lastCA * 100;

		return number_format($resultForm, 2, ",", " ");
	}
	
	static function getFactureQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $validateOnly) {
		$sqlQuery = " SELECT _ID FROM facture WHERE ID_SOCIETE = " . $idSociete .
		       		" AND DATE_EMISSION >= '" . $dateDebPeriodeSql . "'" .
       				" AND DATE_EMISSION <= '" . $dateFinPeriodeSql . "'";
		if ($validateOnly) {
			$sqlQuery = $sqlQuery . " AND VALIDATION = '1'";
		}
		
		return $sqlQuery;
	}
	
	static function getNbFacture($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Facture::getFactureQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
		return mysql_num_rows($select);
	}
	
	static function getNbFactureValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Facture::getFactureQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
		return mysql_num_rows($select);
	}
	
	static function getFactureClose($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$tauxReussite = 0;
		$nbFacture = Facture::getNbFacture($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql);
		if ($nbFacture > 0) {
			$tauxReussite = Facture::getNbFactureValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) / $nbFacture * 100;
		}
		return number_format($tauxReussite, 2, ",", " ");
	}
	
	static function getMontantTotalFacture($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Facture::getFactureQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$facture = new Facture();
			$facture->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
				$ca = $ca + $facture->getHTPrice() - $facture->getTotalAvoirHT();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Facture::calculTvaPrice($facture);
				$ca = $ca + $facture->getTTCPrice() - $facture->getTotalAvoir();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function getMontantTotalFactureValidee($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Facture::getFactureQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$facture = new Facture();
			$facture->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
				$ca = $ca + $facture->getHTPrice() - $facture->getTotalAvoirHT();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Facture::calculTvaPrice($facture);
				$ca = $ca + $facture->getTTCPrice() - $facture->getTotalAvoir();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}

	static function calculTvaPrice($facture) {
		$allTva = Tva::findAll();
		foreach ($allTva as $tva) {
			$facture->getTvaPrice($tva->id);
		}
	}
	
}
?>