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
		$this->dateCreation = "0000-00-00";
		$this->dateFermeture = "0000-00-00";
	}

    /**
     * SELECT BY ID - TABLE SOCIETE
     * Sélectionner une SOCIETE par son_ID
     * @param $id
     * @return $this
     */
	function findById($id) {

        if(!isset($cnx)){
            $cnx = getConnection();
            //echo('Connection BDD');
        }

        try{
            $sql = "select * from " . $this->tableName . " where _ID = " . $id;
            $query = mysqli_query($cnx,$sql);
            if (mysqli_num_rows($query) == 1) {
                $result = mysqli_fetch_object($query);
                $this->itemBuilder($result);
            }
        }catch(Exception $ex){
            $ex->getCode().' '.$ex->getMessage();
        }

        closeConnection($cnx);
        //echo('Fermeture connection BDD');
        return $this;

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

    /**
     * Création d'un objet Societe à partir des données d'une BDD
     * @param $result
     */
	function itemBuilder($result){

        $this->id=$result->_ID;
        $this->nom=$result->NOM;
        $this->logo=$result->LOGO;
        $this->adresse1=$result->ADRESSE1;
        $this->adresse2=$result->ADRESSE2;
        $this->codePostal=$result->CODE_POSTAL;
        $this->ville=$result->VILLE;
        $this->telFix=$result->TEL_FIX;
        $this->telMob=$result->TEL_MOB;
        $this->fax=$result->FAX;
        $this->email=$result->EMAIL;
        $this->siteWeb=$result->SITE_WEB;
        $this->siret=$result->SIRET;
        $this->ape=$result->APE;
        $this->rcs=$result->RCS;
        $this->forme=$result->FORME;
        $this->tvaIntra=$result->TVA_INTRA;
        $this->dateCreation=$result->DATE_CREATION;
        $this->dateFermeture=$result->DATE_FERMETURE;
        $this->piedBonCmd=$result->PIED_BON_CMD;
        $this->piedDevis=$result->PIED_DEVIS;
        $this->piedFacture=$result->PIED_FACTURE;
        $this->marge=$result->MARGE;
        $this->refBonPrefix=$result->REF_BON_PREFIX;
        $this->refBonIncre=$result->REF_BON_INCRE;
        $this->refDevisPrefix=$result->REF_DEVIS_PREFIX;
        $this->refDevisIncre=$result->REF_DEVIS_INCRE;
        $this->refFacturePrefix=$result->REF_FACTURE_PREFIX;
        $this->refFactureIncre=$result->REF_FACTURE_INCRE;
        $this->refAvoirPrefix=$result->REF_AVOIR_PREFIX;
        $this->refAvoirIncre=$result->REF_AVOIR_INCRE;
        $this->refAcomptePrefix=$result->REF_ACOMPTE_PREFIX;
        $this->refAcompteIncre=$result->REF_ACOMPTE_INCRE;
        $this->inactif=$result->INACTIF;
        $this->bloc=$result->BLOC;
        $this->consult=$result->CONSULT;
        $this->delai1=$result->DELAI1;
        $this->delai2=$result->DELAI2;
        $this->catalogue=$result->CATALOGUE;

    }

}
