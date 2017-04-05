<?php
require("business/groupeAvoir.php");

class Avoir {
	
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
	var $remise;
	var $acompte;
	var $validation;
	var $groupes = array();
	var $totauxTva = array();
	var $tableName;
	
	function Avoir() {
		$this->tableName = "avoir";
		$this->remise = "0.00";
		$this->acompte = "0.00";
	}
	
	function findById($id) {
		$sql = "select _ID, REFERENCE, ID_SOCIETE, FACTURE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE, VALIDATION from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql);
		$this->id = mysql_result($query, 0, "_ID");
		$this->reference = mysql_result($query, 0, "REFERENCE");
		$this->idSociete = mysql_result($query, 0, "ID_SOCIETE");
		$this->idFacture = mysql_result($query, 0, "FACTURE");
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
		$sql = "select _ID from groupe_avoir where AVOIR = " . $this->id;
		$query = mysql_query($sql);
		while ($idGroupe = mysql_fetch_array($query)) {
			$groupe = new GroupeAvoir();
			$groupe->findById($idGroupe["_ID"]);
			$this->groupes[$idGroupe["_ID"]] = $groupe;
		}
	}
	
	function addGroupe() {
		$groupe = new GroupeAvoir();
		$groupe->idAvoir = $this->id;
		return $groupe;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (REFERENCE, ID_SOCIETE, FACTURE, ID_SOCIETE_CLIENT, TITRE, DATE_EMISSION, DATE_VALIDITE, ID_SOCIETE_CONTACT, COMMENTAIRE, REMISE, ACOMPTE) " 
				. "values ('" . $this->reference . "', '" . $this->idSociete . "', '" . $this->idFacture . "', '" . $this->idSocieteClient . "', '" . str_replace("'", "''", $this->titre) . "', '" . $this->dateEmission . "', '" . $this->dateValidite . "', '" . $this->idSocieteContact . "', '" . str_replace("'", "''", $this->commentaire) . "', '" . $this->remise . "', '" . $this->acompte . "')";
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
		return $this->getTTCPrice() - $this->acompte;
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
		$sql = "select _ID from avoir where DESTINATAIRE = '" . $destinataire . "' and EMETTEUR = '" . $emetteur . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$avoirTab = array();
		while ($aAvoirId = mysql_fetch_array($query)) {
			$avoir = new Avoir();
			$avoir->findById($aAvoirId['_ID']);
			$avoirTab[$avoir->id] = $avoir;
		}
		return $avoirTab;
	}
	
	static function findByFacture($idFacture) {
		$sql = "select _ID from avoir where FACTURE = '" . $idFacture . "'";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$avoirTab = array();
		while ($aAvoirId = mysql_fetch_array($query)) {
			$avoir = new Avoir();
			$avoir->findById($aAvoirId['_ID']);
			$avoirTab[$avoir->id] = $avoir;
		}
		return $avoirTab;
	}
	
	static function getCAForThisPeriod($idSociete, $beginDate, $endDate, $typeMontant) {
       	$select = mysql_query(
       		" SELECT _ID FROM avoir" .  
       		" WHERE ID_SOCIETE = " . $idSociete . 
       		" AND FACTURE is null" .
       		" AND DATE_EMISSION >= '" . $beginDate . "'" .
       		" AND DATE_EMISSION <= '" . $endDate . "'"
       	);

       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$avoir = new Avoir();
			$avoir->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $avoir->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Avoir::calculTvaPrice($avoir);
				$ca = $ca + $avoir->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
       		// echo "avoir : " . $avoir->id . " - " . $avoir->getTTCPrice() . "\n";
		}
		
		return $ca;
	}
	
	static function getAvoirQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $validateOnly) {
		$sqlQuery = " SELECT _ID FROM avoir WHERE ID_SOCIETE = " . $idSociete .
		       		" AND DATE_EMISSION >= '" . $dateDebPeriodeSql . "'" .
       				" AND DATE_EMISSION <= '" . $dateFinPeriodeSql . "'" .
       				" AND (FACTURE is NULL OR FACTURE = '')";
		if ($validateOnly) {
			$sqlQuery = $sqlQuery . " AND VALIDATION = '1'";
		}
		
		return $sqlQuery;
	}
	
	static function getNbAvoir($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Avoir::getAvoirQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
		return mysql_num_rows($select);
	}
	
	static function getNbAvoirValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$select = mysql_query(Avoir::getAvoirQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
		return mysql_num_rows($select);
	}
	
	static function getAvoirClos($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) {
		$tauxReussite = 0;
		$nbAvoir = Avoir::getNbAvoir($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql);
		if ($nbAvoir > 0) {
			$tauxReussite = Avoir::getNbAvoirValidate($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql) / $nbAvoir * 100;
		}
		return number_format($tauxReussite, 2, ",", " ");;
	}
	
	static function getMontantTotalAvoir($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Avoir::getAvoirQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, false));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$avoir = new Avoir();
			$avoir->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $avoir->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Avoir::calculTvaPrice($avoir);
				$ca = $ca + $avoir->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function getMontantTotalAvoirValidee($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$select = mysql_query(Avoir::getAvoirQuery($idSociete, $dateDebPeriodeSql, $dateFinPeriodeSql, true));
		
       	$ca = 0;
		while ($result = mysql_fetch_array($select)) {
			$avoir = new Avoir();
			$avoir->findById($result['_ID']);
			if ($typeMontant == Profil::$TYPE_MONTANT_HT) {
       			$ca = $ca + $avoir->getHTPrice();
			} else if ($typeMontant == Profil::$TYPE_MONTANT_TTC) {
				Avoir::calculTvaPrice($avoir);
				$ca = $ca + $avoir->getTTCPrice();
			} else {
				$ca = $ca - 1;
			}
		}
		
		return $ca;
//		return number_format($ca, 2, ",", " ");
	}
	
	static function calculTvaPrice($avoir) {
		$allTva = Tva::findAll();
		foreach ($allTva as $tva) {
			$avoir->getTvaPrice($tva->id);
		}
	}
	
}
?>