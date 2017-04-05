<?php
class Role {
	static $CODE_ADMIN = "ADM";
	static $CODE_GESTIONNAIRE = "GST";
	static $CODE_ENTREPRENEUR = "ENT";
	static $CODE_CONSULTANT = "CST";
	
	var $code;
	var $nom;
	var $tableName;
	
	function Role() {
		$this->tableName = "role";
	}
	
	function findByCode($code) {
		$sql = "select CODE, NOM from " . $this->tableName . " where CODE = '" . $code . "'";
		$query = mysql_query($sql);
		$this->code = mysql_result($query, 0, "CODE");
		$this->nom = mysql_result($query, 0, "NOM");
	}
	
}
?>