<?php
class Tva {
	
	var $id;
	var $libelle;
	var $isActif;

	function Tva() {
		$this->tableName = "t_tva";
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (_ID, LIBELLE, ACTIF) " 
				. "values ('" . $this->id . "', '" . $this->libelle . "', '1')";
		if (!mysql_query($sql)) {
			die (mysql_error());
		}
	}
	
	function update() {
		$actif = $this->isActif ? "1" : "0";
		$sql = "update " . $this->tableName . " set LIBELLE = '" . $this->libelle . "', ACTIF = '" . $actif . "' where _ID = '" . $this->id . "'";
		if (!mysql_query($sql)) {
			die (mysql_error());
		}
	}
	
	function activate() {
		$this->isActif = true;
		$this->update();
	}
	
	function desactivate() {
		$this->isActif = false;
		$this->update();
	}
	
	static function findAll() {
		$tvaTab = array();

		$sql = "select _ID, LIBELLE, ACTIF from t_tva order by _ID";
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}

		while ($tvaRow = mysql_fetch_array($query)) {
			$tva = new Tva();
			$tva->id = $tvaRow["_ID"];
			$tva->libelle = $tvaRow["LIBELLE"];
			$tva->isActif = ($tvaRow["ACTIF"] == "1");
			$tvaTab[$tva->id] = $tva;
		}
		
		return $tvaTab;
	}
}
?>