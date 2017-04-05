<?php
class SocieteClientProspect {
	
	var $id;
	var $idSocieteClient;
	var $appel;
	var $relance;
	var $rdv;
	var $commentaire;
	var $tableName;
	
	function SocieteClientProspect() {
		$this->tableName = "societe_client_prospect";
	}
	
	function findByLogin($id) {
		$sql = "select * from " . $this->tableName . " where _ID = " . $id;
		$query = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($query) == 1) {
			$this->id = mysql_result($query, 0, "_ID");
			$this->idSocieteClient = mysql_result($query, 0, "ID_SOCIETE_CLIENT");
			$this->appel = mysql_result($query, 0, "APPEL");
			$this->relance = mysql_result($query, 0, "RELANCE");
			$this->rdv = mysql_result($query, 0, "RDV");
			$this->commentaire = mysql_result($query, 0, "COMMENTAIRE");
		}
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (ID_SOCIETE_CLIENT, APPEL, RELANCE, RDV, COMMENTAIRE) " 
				. "values (" . $this->idSocieteClient . ", '" . 
						str_replace("'", "''", $this->appel) . "', '" . 
						str_replace("'", "''", $this->relance) . "', '" . 
						str_replace("'", "''", $this->rdv) . "', '" . 
						str_replace("'", "''", $this->commentaire) . "')";
		mysql_query($sql) or die(mysql_error());
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set APPEL = '" . str_replace("'", "''", $this->appel) . 
											"', RELANCE = '" . str_replace("'", "''", $this->relance) . 
											"', RDV = '" . str_replace("'", "''", $this->rdv) . 
											"', COMMENTAIRE = '" . str_replace("'", "''", $this->commentaire) . 
											"' where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = " . $this->id;
		$query = mysql_query($sql) or die(mysql_error());
	}
	
}
?>