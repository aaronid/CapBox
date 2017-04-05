<?php
require("business/ligneDevis.php");

class GroupeDevis {
	
	var $id;
	var $idDevis;
	var $designation;
//	var $quantiteMO;
//	var $uniteMO;
//	var $prixUnitaireHTMO;
//	var $tauxTvaMO;
//	var $marge;
	var $lignes = array();
	var $tableName;
	
	function GroupeDevis() {
		$this->tableName = "groupe_devis";
	}
	
	function findById($id_) {
		$sql = "select _ID, DEVIS, DESIGNATION from " . $this->tableName . " where _ID = " . $id_;
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$this->id = mysql_result($query, 0, "_ID");
		$this->idDevis = mysql_result($query, 0, "DEVIS");
		$this->designation = mysql_result($query, 0, "DESIGNATION");
//		$this->marge = 50;
//		$this->quantiteMO = 2;
//		$this->uniteMO = "heure";
//		$this->prixUnitaireHTMO = 15;
//		$this->tauxTvaMO = 0.196;

		$this->findLignes();
	}
	
	function findLignes() {
		$sql = "select _ID from ligne_devis where GROUPE_DEVIS = " . $this->id . " order by NUMERO";
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idLigne = mysql_fetch_array($query)) {
			$ligne = new LigneDevis();
			$ligne->findById($idLigne["_ID"]);
			$this->lignes[$idLigne["_ID"]] = $ligne;
		}
	}
	
	function addLigne() {
		$ligne = new LigneDevis();
		$ligne->idGroupeDevis = $this->id;
		return $ligne;
	}
	
	function duplicate($idDevis) {
		$dupGroup = new GroupeDevis();
		$dupGroup->idDevis = $idDevis;
		$dupGroup->designation = $this->designation;
//		$dupGroup->marge = $this->marge;
//		$dupGroup->quantiteMO = $this->quantiteMO;
//		$dupGroup->uniteMO = $this->uniteMO;
//		$dupGroup->prixUnitaireHTMO = $this->prixUnitaireHTMO;
//		$dupGroup->tauxTvaMO = $this->tauxTvaMO;

		$dupGroup->insert();
		return $dupGroup;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (DEVIS, DESIGNATION) values ('" . $this->idDevis . "', '" . str_replace("'", "''", $this->designation) . "')";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set DESIGNATION = '" . str_replace("'", "''", $this->designation) . "' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function delete() {
		foreach ($this->lignes as $ligne) {
			$ligne->delete();
		}
		$sql = "delete from " . $this->tableName . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function transformToGroupeFacture() {
		$newGrpFacture = new GroupeFacture();
		$newGrpFacture->id = "New" . $this->id;
		$newGrpFacture->designation = $this->designation;
		// $newGrpFacture->marge = $this->marge;
		// TODO BRI rajouter la MO
		foreach ($this->lignes as $ligne) {
			$newLigneFacture = $ligne->transformToLigneFacture();
			$newLigneFacture->idGroupeFacture = $newGrpFacture->id;
			$newGrpFacture->lignes[$newLigneFacture->id] = $newLigneFacture;
		}
		
		return $newGrpFacture;
	}
	
	function getHTPrice() {
//		$htPrice = $this->getHTMainOeuvre();
		$htPrice = 0;
		foreach ($this->lignes as $ligne) {
			$htPrice = $htPrice + $ligne->getHTPrice();
		}
		return $htPrice;
	}

/*	function getTvaPriceMO($tauxTva) {
		$tvaPrice = 0;
		if (floatval($this->tauxTvaMO) == $tauxTva) {
			$tvaPrice = floatval($this->tauxTvaMO) * $this->getHTMainOeuvre();
		}
		return $tvaPrice;
	}
*/
	function getTvaPrice($tauxTva) {
//		$tvaPrice = $this->getTvaPriceMO($tauxTva);
		$tvaPrice = 0;
		foreach ($this->lignes as $ligne) {
			if (floatval($ligne->tauxTva) == $tauxTva) {
				$tvaPrice = $tvaPrice + $ligne->getTvaPrice();
			}
		}
		return $tvaPrice;
	}

/*	function getHTMainOeuvre() {
		return floatval($this->quantiteMO) * floatval($this->prixUnitaireHTMO);
	}
	
	function getMargeEuro() {
		return $this->getHTMainOeuvre() * $this->marge / 100;
	}
*/	
	function getHTPriceFormat() {
		return number_format($this->getHTPrice(), 2, ",", " ");
	}

/*	function getQuantiteMOFormat() {
		return number_format($this->quantiteMO, 2, ",", " ");
	}
	
	function getUnitHTMainOeuvreFormat() {
		return number_format($this->prixUnitaireHTMO, 2, ",", " ");
	}
	
	function getHTMainOeuvreFormat() {
		return number_format($this->getHTMainOeuvre(), 2, ",", " ");
	}

	function getMargeFormat() {
		return number_format($this->marge, 2, ",", " ");
	}

	function getMargeEuroFormat() {
		return number_format($this->getMargeEuro(), 2, ",", " ");
	}
*/
}
?>