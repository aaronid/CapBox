<?php
class Societe {
	
	var $id;
	var $nom;
	var $logo;
	var $adresse1;
	var $adresse2;
	var $codePostal;
	var $ville;
	var $telFix;
	var $telMob;
	var $fax;
	var $email;
	var $siteWeb;
	var $siret;
	var $ape;
	var $rcs;
	var $forme;
	var $tvaIntra;
	var $dateCreation;
	var $dateFermeture;
	var $piedBonCmd;
	var $piedDevis;
	var $piedFacture;
	var $marge;
	var $refBonPrefix;
	var $refBonIncre;
	var $refDevisPrefix;
	var $refDevisIncre;
	var $refFacturePrefix;
	var $refFactureIncre;
	var $refAvoirPrefix;
	var $refAvoirIncre;
	var $refAcomptePrefix;
	var $refAcompteIncre;
	var $inactif;
	var $bloc;
	var $consult;
	var $delai1;
	var $delai2;
	var $catalogue;
	var $tableName;
	
	function Societe() {
		$this->tableName = "societe";
	}
	
	function findById($id) {
		$sql = "select * from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql);
		if (mysql_num_rows($query) == 1) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->nom = mysql_result($query, 0, "NOM");
			$this->logo = mysql_result($query, 0, "LOGO");
			$this->adresse1 = mysql_result($query, 0, "ADRESSE1");
			$this->adresse2 = mysql_result($query, 0, "ADRESSE2");
			$this->codePostal = mysql_result($query, 0, "CODE_POSTAL");
			$this->ville = mysql_result($query, 0, "VILLE");
			$this->telFix = mysql_result($query, 0, "TEL_FIX");
			$this->telMob = mysql_result($query, 0, "TEL_MOB");
			$this->fax = mysql_result($query, 0, "FAX");
			$this->email = mysql_result($query, 0, "EMAIL");
			$this->siteWeb = mysql_result($query, 0, "SITE_WEB");
			$this->siret = mysql_result($query, 0, "SIRET");
			$this->ape = mysql_result($query, 0, "APE");
			$this->rcs = mysql_result($query, 0, "RCS");
			$this->forme = mysql_result($query, 0, "FORME");
			$this->tvaIntra = mysql_result($query, 0, "TVA_INTRA");
			$this->dateCreation = mysql_result($query, 0, "DATE_CREATION");
			$this->dateFermeture = mysql_result($query, 0, "DATE_FERMETURE");
			$this->piedBonCmd = mysql_result($query, 0, "PIED_BON_CMD");
			$this->piedDevis = mysql_result($query, 0, "PIED_DEVIS");
			$this->piedFacture = mysql_result($query, 0, "PIED_FACTURE");
			$this->inactif = mysql_result($query, 0, "INACTIF");
			$this->marge = mysql_result($query, 0, "MARGE");
			$this->refBonPrefix = mysql_result($query, 0, "REF_BON_PREFIX");
			$this->refBonIncre = mysql_result($query, 0, "REF_BON_INCRE");
			$this->refDevisPrefix = mysql_result($query, 0, "REF_DEVIS_PREFIX");
			$this->refDevisIncre = mysql_result($query, 0, "REF_DEVIS_INCRE");
			$this->refFacturePrefix = mysql_result($query, 0, "REF_FACTURE_PREFIX");
			$this->refFactureIncre = mysql_result($query, 0, "REF_FACTURE_INCRE");
			$this->refAvoirPrefix = mysql_result($query, 0, "REF_AVOIR_PREFIX");
			$this->refAvoirIncre = mysql_result($query, 0, "REF_AVOIR_INCRE");
			$this->refAcomptePrefix = mysql_result($query, 0, "REF_ACOMPTE_PREFIX");
			$this->refAcompteIncre = mysql_result($query, 0, "REF_ACOMPTE_INCRE");
			$this->bloc = mysql_result($query, 0, "BLOC");
			$this->consult = mysql_result($query, 0, "CONSULT");
			$this->delai1 = mysql_result($query, 0, "DELAI1");
			$this->delai2 = mysql_result($query, 0, "DELAI2");
			$this->catalogue = mysql_result($query, 0, "CATALOGUE");
		}
	}
	
	function insert() {
		$aRefBonIncre = 0; if (!empty($this->refBonIncre)) {$aRefBonIncre = $this->refBonIncre;}
		$aRefDevisIncre = 0; if (!empty($this->refDevisIncre)) {$aRefDevisIncre = $this->refDevisIncre;}
		$aRefFactureIncre = 0; if (!empty($this->refFactureIncre)) {$aRefFactureIncre = $this->refFactureIncre;}
		$aRefAvoirIncre = 0; if (!empty($this->refAvoirIncre)) {$aRefAvoirIncre = $this->refAvoirIncre;}
		$aRefAcompteIncre = 0; if (!empty($this->refAcompteIncre)) {$aRefAcompteIncre = $this->refAcompteIncre;}
		
		$sql = "insert into " . $this->tableName . " (NOM, LOGO, ADRESSE1, ADRESSE2, CODE_POSTAL, VILLE, TEL_FIX, TEL_MOB, FAX, EMAIL, SITE_WEB, SIRET, APE, RCS, FORME, TVA_INTRA, DATE_CREATION, DATE_FERMETURE, PIED_BON_CMD, PIED_DEVIS, PIED_FACTURE, MARGE, REF_BON_PREFIX, REF_BON_INCRE, REF_DEVIS_PREFIX, REF_DEVIS_INCRE, REF_FACTURE_PREFIX, REF_FACTURE_INCRE, REF_AVOIR_PREFIX, REF_AVOIR_INCRE, REF_ACOMPTE_PREFIX, REF_ACOMPTE_INCRE, INACTIF, BLOC, CONSULT, DELAI1, DELAI2, CATALOGUE) " 
				. "values ('" . str_replace("'", "''", $this->nom) . "', '" . 
								str_replace("'", "''", $this->logo) . "', '" . 
								str_replace("'", "''", $this->adresse1) . "', '" . 
								str_replace("'", "''", $this->adresse2) . "', '" . 
								str_replace("'", "''", $this->codePostal) . "', '" . 
								str_replace("'", "''", $this->ville) . "', '" . 
								str_replace("'", "''", $this->telFix) . "', '" . 
								str_replace("'", "''", $this->telMob) . "', '" . 
								str_replace("'", "''", $this->fax) . "', '" . 
								str_replace("'", "''", $this->email) . "', '" . 
								str_replace("'", "''", $this->siteWeb) . "', '" . 
								str_replace("'", "''", $this->siret) . "', '" . 
								str_replace("'", "''", $this->ape) . "', '" . 
								str_replace("'", "''", $this->rcs) . "', '" . 
								str_replace("'", "''", $this->forme) . "', '" . 
								str_replace("'", "''", $this->tvaIntra) . "', '" . 
								str_replace("'", "''", $this->dateCreation) . "', '" . 
								str_replace("'", "''", $this->dateFermeture) . "', '" . 
								str_replace("'", "''", $this->piedBonCmd) . "', '" . 
								str_replace("'", "''", $this->piedDevis) . "', '" . 
								str_replace("'", "''", $this->piedFacture) . "', '" . 
								str_replace("'", "''", $this->marge) . "', '" . 
								str_replace("'", "''", $this->refBonPrefix) . "', " . 
								$aRefBonIncre . ", '" . 
								str_replace("'", "''", $this->refDevisPrefix) . "', " . 
								$aRefDevisIncre . ", '" . 
								str_replace("'", "''", $this->refFacturePrefix) . "', " . 
								$aRefFactureIncre . ", '" . 
								str_replace("'", "''", $this->refAvoirPrefix) . "', " . 
								$aRefAvoirIncre . ", '" . 
								str_replace("'", "''", $this->refAcomptePrefix) . "', " . 
								$aRefAcompteIncre . ", '" . 
								str_replace("'", "''", $this->inactif) . "', '" . 
								str_replace("'", "''", $this->bloc) . "', '" . 
								str_replace("'", "''", $this->consult) . "', '" . 
								str_replace("'", "''", $this->delai1) . "', '" . 
								str_replace("'", "''", $this->delai2) . "', '" . 
								str_replace("'", "''", $this->catalogue) . "')";
		mysql_query($sql) or die(mysql_error());
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$aRefBonIncre = 0; if (!empty($this->refBonIncre)) {$aRefBonIncre = $this->refBonIncre;}
		$aRefDevisIncre = 0; if (!empty($this->refDevisIncre)) {$aRefDevisIncre = $this->refDevisIncre;}
		$aRefFactureIncre = 0; if (!empty($this->refFactureIncre)) {$aRefFactureIncre = $this->refFactureIncre;}
		$aRefAvoirIncre = 0; if (!empty($this->refAvoirIncre)) {$aRefAvoirIncre = $this->refAvoirIncre;}
		$aRefAcompteIncre = 0; if (!empty($this->refAcompteIncre)) {$aRefAcompteIncre = $this->refAcompteIncre;}
		
		$sql = "update " . $this->tableName . " set NOM = '" . str_replace("'", "''", $this->nom) . 
												"', LOGO = '" . str_replace("'", "''", $this->logo) . 
												"', ADRESSE1 = '" . str_replace("'", "''", $this->adresse1) . 
												"', ADRESSE2 = '" . str_replace("'", "''", $this->adresse2) . 
												"', CODE_POSTAL = '" . str_replace("'", "''", $this->codePostal) . 
												"', VILLE = '" . str_replace("'", "''", $this->ville) . 
												"', TEL_FIX = '" . str_replace("'", "''", $this->telFix) . 
												"', TEL_MOB = '" . str_replace("'", "''", $this->telMob) . 
												"', FAX = '" . str_replace("'", "''", $this->fax) . 
												"', EMAIL = '" . str_replace("'", "''", $this->email) . 
												"', SITE_WEB = '" . str_replace("'", "''", $this->siteWeb) . 
												"', SIRET = '" . str_replace("'", "''", $this->siret) . 
												"', APE = '" . str_replace("'", "''", $this->ape) . 
												"', RCS = '" . str_replace("'", "''", $this->rcs) . 
												"', FORME = '" . str_replace("'", "''", $this->forme) . 
												"', TVA_INTRA = '" . str_replace("'", "''", $this->tvaIntra) . 
												"', DATE_CREATION = '" . str_replace("'", "''", $this->dateCreation) . 
												"', DATE_FERMETURE = '" . str_replace("'", "''", $this->dateFermeture) . 
												"', PIED_BON_CMD = '" . str_replace("'", "''", $this->piedBonCmd) . 
												"', PIED_DEVIS = '" . str_replace("'", "''", $this->piedDevis) . 
												"', PIED_FACTURE = '" . str_replace("'", "''", $this->piedFacture) . 
												"', MARGE = '" . str_replace("'", "''", $this->marge) . 
												"', REF_BON_PREFIX = '" . str_replace("'", "''", $this->refBonPrefix) . 
												"', REF_BON_INCRE = " . $aRefBonIncre . 
												" , REF_DEVIS_PREFIX = '" . str_replace("'", "''", $this->refDevisPrefix) . 
												"', REF_DEVIS_INCRE = " . $aRefDevisIncre . 
												" , REF_FACTURE_PREFIX = '" . str_replace("'", "''", $this->refFacturePrefix) . 
												"', REF_FACTURE_INCRE = " . $aRefFactureIncre . 
												" , REF_AVOIR_PREFIX = '" . str_replace("'", "''", $this->refAvoirPrefix) . 
												"', REF_AVOIR_INCRE = " . $aRefAvoirIncre . 
												" , REF_ACOMPTE_PREFIX = '" . str_replace("'", "''", $this->refAcomptePrefix) . 
												"', REF_ACOMPTE_INCRE = " . $aRefAcompteIncre . 
												" , INACTIF = '" . str_replace("'", "''", $this->inactif) . 
												"', BLOC = '" . str_replace("'", "''", $this->bloc) . 
												"', CONSULT = '" . str_replace("'", "''", $this->consult) . 
												"', DELAI1 = '" . str_replace("'", "''", $this->delai1) . 
												"', DELAI2 = '" . str_replace("'", "''", $this->delai2) . 
												"', CATALOGUE = '" . str_replace("'", "''", $this->catalogue) . 
												"' where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function incrementRefBonIncre() {
		$aRefBonIncre = 0; if (!empty($this->refBonIncre)) {$aRefBonIncre = $this->refBonIncre + 1;}
		
		$sql = "update " . $this->tableName . " set REF_BON_INCRE = " . $aRefBonIncre . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
		
		$this->refBonIncre = $aRefBonIncre;
	}
	
	function incrementRefDevisIncre() {
		$aRefDevisIncre = 0; if (!empty($this->refDevisIncre)) {$aRefDevisIncre = $this->refDevisIncre;}
		
		$sql = "update " . $this->tableName . " set REF_DEVIS_INCRE = " . $aRefDevisIncre . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
		
		$this->refDevisIncre = $aRefDevisIncre;
	}
	
	function incrementRefFactureIncre() {
		$aRefFactureIncre = 0; if (!empty($this->refFactureIncre)) {$aRefFactureIncre = $this->refFactureIncre;}
		
		$sql = "update " . $this->tableName . " set REF_FACTURE_INCRE = " . $aRefFactureIncre . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
		
		$this->refFactureIncre = $aRefFactureIncre;
		return $aRefFactureIncre;
	}
	
	function incrementRefAvoirIncre() {
		$aRefAvoirIncre = 0; if (!empty($this->refAvoirIncre)) {$aRefAvoirIncre = $this->refAvoirIncre;}
		
		$sql = "update " . $this->tableName . " set REF_AVOIR_INCRE = " . $aRefAvoirIncre . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
		
		$this->refAvoirIncre = $aRefAvoirIncre;
	}
	
	function incrementRefAcompteIncre() {
		$aRefAcompteIncre = 0; if (!empty($this->refAcompteIncre)) {$aRefAcompteIncre = $this->refAcompteIncre;}
		
		$sql = "update " . $this->tableName . " set REF_ACOMPTE_INCRE = " . $aRefAcompteIncre . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
		
		$this->refAcompteIncre = $aRefAcompteIncre;
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
}
?>