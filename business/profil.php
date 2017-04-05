<?php
class Profil {
	static $CODE_GESTIONNAIRE = "GST";
	static $CODE_CLIENT = "CLI";
	static $CODE_PROSPECT = "CRM";
	
	static $TYPE_MONTANT_HT = "HT";
	static $TYPE_MONTANT_TTC = "TTC";
	
	var $code;
	var $nom;
	var $tableName;
	
	function Profil() {
		$this->tableName = "profil";
	}
	
	function findByCode($code) {
		$sql = "select CODE, NOM from " . $this->tableName . " where CODE = '" . $code . "'";
		$query = mysql_query($sql);
		$this->code = mysql_result($query, 0, "CODE");
		$this->nom = mysql_result($query, 0, "NOM");
	}
	
}
?>