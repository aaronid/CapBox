<?php
require("business/ligneFacture.php");

class GroupeFacture {
	
	var $id;
	var $idFacture;
	var $designation;
//	var $marge;
	var $lignes = array();
	var $tableName;
	
	function GroupeFacture() {
		$this->tableName = "groupe_facture";
	}
	
	function findById($id_) {
		$sql = "select _ID, FACTURE, DESIGNATION from " . $this->tableName . " where _ID = " . $id_;
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$this->id = mysql_result($query, 0, "_ID");
		$this->idFacture = mysql_result($query, 0, "FACTURE");
		$this->designation = mysql_result($query, 0, "DESIGNATION");
//		$this->marge = 50;
		
		$this->findLignes();
	}
	
	function findLignes() {
		$sql = "select _ID from ligne_facture where GROUPE_FACTURE = " . $this->id . " order by NUMERO";
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idLigne = mysql_fetch_array($query)) {
			$ligne = new LigneFacture();
			$ligne->findById($idLigne["_ID"]);
			$this->lignes[$idLigne["_ID"]] = $ligne;
		}
	}
	
	function addLigne() {
		$ligne = new LigneFacture();
		$ligne->idGroupeFacture = $this->id;
		return $ligne;
	}
	
	function duplicate($idFacture) {
		$dupGroup = new GroupeFacture();
		$dupGroup->idFacture = $idFacture;
		$dupGroup->designation = $this->designation;
//		$dupGroup->marge = $this->marge;
		$dupGroup->insert();
		return $dupGroup;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (FACTURE, DESIGNATION) values ('" . $this->idFacture . "', '" . str_replace("'", "''", $this->designation) . "')";
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
	
	function getHTPrice() {
		$htPrice = 0;
		foreach ($this->lignes as $ligne) {
			$htPrice = $htPrice + $ligne->getHTPrice();
		}
		return $htPrice;
	}

	function getTvaPrice($tauxTva) {
		$tvaPrice = 0;
		foreach ($this->lignes as $ligne) {
			if (floatval($ligne->tauxTva) == $tauxTva) {
				$tvaPrice = $tvaPrice + $ligne->getTvaPrice();
			}
		}
		return $tvaPrice;
	}
	
/*	function getMargeEuro() {
		return $this->getHTPrice() * $this->marge / 100;
	}
*/	
	function getHTPriceFormat() {
		return number_format($this->getHTPrice(), 2, ",", " ");
	}

/*	function getMargeFormat() {
		return number_format($this->marge, 2, ",", " ");
	}

	function getMargeEuroFormat() {
		return number_format($this->getMargeEuro(), 2, ",", " ");
	}
*/
}
?>