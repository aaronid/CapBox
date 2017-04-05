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

	    var_dump($code);

		$sql = "select CODE, NOM from " . $this->tableName . " where CODE = '" . $code . "'";
		$cnx = getConnectionTest();
		$query = mysqli_query($cnx,$sql);

		$role = mysqli_fetch_object($query);

		var_dump($role);

		closeConnectionTest($cnx);
	}
	
}
