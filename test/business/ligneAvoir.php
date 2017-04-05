<?php
class LigneAvoir {

	var $id;
	var $idGroupeAvoir;
	var $designation;
	var $tauxTva;
	var $quantite;
	var $unite;
	var $prixUnitaireHT;
	var $numero;
	var $rang;
	var $tableName;
	
	var $ttcPrice;

	function LigneAvoir() {
		$this->tableName = "ligne_avoir";
		$this->quantite = "1.00";
		$this->prixUnitaireHT = "0.00";
	}

	function findById($id_) {
		$sql = "select _ID, GROUPE_AVOIR, DESIGNATION, TTVA, QTE, UNITE, PUHT, NUMERO, RANG from " . $this->tableName . " where _ID = " . $id_;
		$query = mysql_query($sql);
		if (!$query) {
			die (mysql_error());
		}
		$this->id = mysql_result($query, 0, "_ID");
		$this->idGroupeAvoir = mysql_result($query, 0, "GROUPE_AVOIR");
		$this->designation = mysql_result($query, 0, "DESIGNATION");
		$this->tauxTva = mysql_result($query, 0, "TTVA");
		$this->quantite = mysql_result($query, 0, "QTE");
		$this->unite = mysql_result($query, 0, "UNITE");
		$this->prixUnitaireHT = mysql_result($query, 0, "PUHT");
		$this->numero = mysql_result($query, 0, "NUMERO");
		$this->rang = mysql_result($query, 0, "RANG");
	}

	function duplicate($idGroupeAvoir) {
		$dupLigne = new LigneAvoir();
		$dupLigne->idGroupeAvoir = $idGroupeAvoir;
		$dupLigne->designation = $this->designation;
		$dupLigne->tauxTva = $this->tauxTva;
		$dupLigne->quantite = $this->quantite;
		$dupLigne->unite = $this->unite;
		$dupLigne->prixUnitaireHT = $this->prixUnitaireHT;
		$dupLigne->numero = $this->numero;
		$dupLigne->rang = $this->rang;
		$dupLigne->insert();
		return $dupLigne;
	}
	
	function insert() {
		$sql = "insert into " . $this->tableName . " (GROUPE_AVOIR, DESIGNATION, TTVA, QTE, UNITE, PUHT, NUMERO, RANG) values ('" . $this->idGroupeAvoir . "', '" . str_replace("'", "''", $this->designation) . "', '" . $this->tauxTva . "', '" . $this->quantite . "', '" . $this->unite . "', '" . $this->prixUnitaireHT . "', " . $this->numero . ", '" . $this->rang . "')";
		mysql_query($sql);
		$this->id = mysql_insert_id();
	}
	
	function update() {
		$sql = "update " . $this->tableName . " set DESIGNATION = '" . str_replace("'", "''", $this->designation) . "', TTVA = '" . $this->tauxTva . "', QTE = '" . $this->quantite . "', UNITE = '" . $this->unite . "', PUHT = '" . $this->prixUnitaireHT . "' where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function delete() {
		$sql = "delete from " . $this->tableName . " where _ID = '" . $this->id . "'";
		$query = mysql_query($sql);
	}
	
	function getHTPrice() {
		return floatval($this->quantite) * floatval($this->prixUnitaireHT);
	}

	function getTVAPrice() {
		return floatval($this->tauxTva) * $this->getHTPrice();
	}

	function getTTCPrice() {
		return $this->getTVAPrice() + $this->getHTPrice();
	}

	function getUnitHTPriceFormat() {
		return number_format($this->prixUnitaireHT, 2, ",", " ");
	}

	function getHTPriceFormat() {
		return number_format($this->getHTPrice(), 2, ",", " ");
	}

	function getQuantiteFormat() {
		return number_format($this->quantite, 2, ",", " ");
	}

	function getHtmlId() {
		return $this->idGroupeAvoir . "_" . $this->id;
	}

}
?>