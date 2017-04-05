<?php
require("business/ligneAvoir.php");

class GroupeAvoir {
	
	var $id;
	var $idAvoir;
	var $designation;
	var $marge;
	var $lignes = array();
	var $tableName;
	
	function GroupeAvoir() {
		$this->tableName = "groupe_avoir";
	}
	
	function findById($id_) {
		$sql = "select _ID, AVOIR, DESIGNATION from " . $this->tableName . " where _ID = " . $id_;
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$this->id = mysql_result($query, 0, "_ID");
		$this->idAvoir = mysql_result($query, 0, "AVOIR");
		$this->designation = mysql_result($query, 0, "DESIGNATION");
		$this->marge = 50;
		
		$this->findLignes();
	}
	
	function findLignes() {
		$sql = "select _ID from ligne_avoir where GROUPE_AVOIR = " . $this->id . " order by NUMERO";
		$query = mysql_query($sql);
		// $nbResult = mysql_num_rows($query);
		while ($idLigne = mysql_fetch_array($query)) {
			$ligne = new LigneAvoir();
			$ligne->findById($idLigne["_ID"]);
			$this->lignes[$idLigne["_ID"]] = $ligne;
		}
	}
	
	function addLigne() {
		$ligne = new LigneAvoir();
		$ligne->idGroupeAvoir = $this->id;
		return $ligne;
	}
	
	function duplicate($idAvoir) {
		$dupGroup = new GroupeAvoir();
		$dupGroup->idAvoir = $idAvoir;
		$dupGroup->designation = $this->designation;
		$dupGroup->marge = $this->marge;
		$dupGroup->insert();
		return $dupGroup;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (AVOIR, DESIGNATION) values ('" . $this->idAvoir . "', '" . str_replace("'", "''", $this->designation) . "')";
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
	
	function getMargeEuro() {
		return $this->getHTPrice() * $this->marge / 100;
	}
	
	function getHTPriceFormat() {
		return number_format($this->getHTPrice(), 2, ",", " ");
	}

	function getMargeFormat() {
		return number_format($this->marge, 2, ",", " ");
	}

	function getMargeEuroFormat() {
		return number_format($this->getMargeEuro(), 2, ",", " ");
	}

}
?>