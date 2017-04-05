<?php
	static $TYPE_MONTANT_HT = "HT";
	static $TYPE_MONTANT_TTC = "TTC";
	
	function getCurrentYearDateMaxStr() {
		return date("Y-m-d", mktime());
	}
	
	function getCurrentYearDateMaxStrToDisplay() {
		return date("d/m/Y", mktime());
	}
	
	function getLastYear() {
		return date("Y", strtotime(getCurrentYearDateMaxStr() . " - 1 year"));
	}
	
	function getCurrentYear() {
		return date("Y", mktime());
	}
	
	function getLastYearDateMaxStr() {
		return date("Y-m-d", strtotime(getCurrentYearDateMaxStr() . " - 1 year"));
	}
	
	function getCurrentYearDateMinStr() {
		return date("Y-01-01", mktime());
	}
	
	function getCurrentYearDateMinStrToDisplay() {
		return date("01/01/Y", mktime());
	}
	
	function getLastYearDateMinStr() {
		return date("Y-m-d", strtotime(getCurrentYearDateMinStr() . " - 1 year"));
	}
	
	function getCurrentYearCurrentMonthMaxStr() {
		return getCurrentYearDateMaxStr();
	}

	function getCurrentYearLastMonthMaxStr() {
		return date("Y-m-d", strtotime(getCurrentYearCurrentMonthMinStr() . " - 1 day"));
	}

	function getCurrentYearLast2MonthMaxStr() {
		return date("Y-m-d", strtotime(getCurrentYearLastMonthMinStr() . " - 1 day"));
	}

	function getCurrentYearCurrentMonthMinStr() {
		return date("Y-m-01", mktime());
	}

	function getCurrentYearLastMonthMinStr() {
		return date("Y-m-d", strtotime(getCurrentYearCurrentMonthMinStr() . " - 1 month"));
	}

	function getCurrentYearLast2MonthMinStr() {
		return date("Y-m-d", strtotime(getCurrentYearCurrentMonthMinStr() . " - 2 month"));
	}

	function getLastYearCurrentMonthMaxStr() {
		return getLastYearDateMaxStr();
	}

	function getLastYearLastMonthMaxStr() {
		return date("Y-m-d", strtotime(getLastYearCurrentMonthMinStr() . " - 1 day"));
	}

	function getLastYearLast2MonthMaxStr() {
		return date("Y-m-d", strtotime(getLastYearLastMonthMinStr() . " - 1 day"));
	}

	function getLastYearCurrentMonthMinStr() {
		return date("Y-m-d", strtotime(getCurrentYearCurrentMonthMinStr() . " - 1 year"));
	}

	function getLastYearLastMonthMinStr() {
		return date("Y-m-d", strtotime(getLastYearCurrentMonthMinStr() . " - 1 month"));
	}

	function getLastYearLast2MonthMinStr() {
		return date("Y-m-d", strtotime(getLastYearCurrentMonthMinStr() . " - 2 month"));
	}

	function getCALastMonthHistoChart($societeContact, $typeMontant) {
      	$caCurrentYearCurrentMonth = Facture::getCACurrentYearCurrentMonth($societeContact->societe->id, $typeMontant);
      	$caCurrentYearLastMonth    = Facture::getCACurrentYearLastMonth($societeContact->societe->id, $typeMontant);
      	$caCurrentYearLast2Month   = Facture::getCACurrentYearLast2Month($societeContact->societe->id, $typeMontant);
      	$caLastYearCurrentMonth    = Facture::getCALastYearCurrentMonth($societeContact->societe->id, $typeMontant);
      	$caLastYearLastMonth       = Facture::getCALastYearLastMonth($societeContact->societe->id, $typeMontant);
      	$caLastYearLast2Month      = Facture::getCALastYearLast2Month($societeContact->societe->id, $typeMontant);
      	
		$configValue = "var configCAMonthHisto = {data: {".
			"datasets: [{" .
                "data: [" . $caLastYearLast2Month .  ", " . $caLastYearLastMonth . ", " . $caLastYearCurrentMonth . "]," .
                "backgroundColor: \"#F7464A\"," .
                "label: \"Année précédente\"," .
		        "yAxisID: \"y-axis-1\"" .
				"},{" .
                "data: [" . $caCurrentYearLast2Month .  ", " . $caCurrentYearLastMonth . ", " . $caCurrentYearCurrentMonth . "]," .
                "backgroundColor: \"#46BFBD\"," .
                "label: \"Année courante\"," .
		        "yAxisID: \"y-axis-1\"" .
		"}]," .
            "labels: [\"2 mois avant\",\"mois précédent\",\"mois courant\"]" .
        "}," .
        "options: {responsive: true, " .
			"legend: {display:false}," .
			"title: {display:true, text:\"Le CA du mois\"}," .
			"scales: {yAxes: [{type: \"linear\", display: true, position: \"left\", id: \"y-axis-1\"}] }}};";
		
		return $configValue;
	}

	function getDevisCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$montantDevisValides = Devis::getMontantTotalDevisValidee($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant);
		$montantDevisNonValides = Devis::getMontantTotalDevis($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) - $montantDevisValides;
		$configValue = "var configDevis = {type: 'pie',data: {".
			"datasets: [{" .
                "data: [" . $montantDevisValides . ", " . $montantDevisNonValides. "]," .
                "backgroundColor: [\"#F7464A\",\"#46BFBD\"]," .
            "}]," .
            "labels: [\"Total des devis validés\",\"Total des devis non validés\"]" .
        "}," .
        "options: {responsive: true}};";
		
		return $configValue;
	}

	function getFactureCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$montantFactureValides = Facture::getMontantTotalFactureValidee($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant);
		$montantFactureNonValides = Facture::getMontantTotalFacture($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) - $montantFactureValides;
		$configValue = "var configFacture = {type: 'pie',data: {".
			"datasets: [{" .
                "data: [" . $montantFactureValides . ", " . $montantFactureNonValides. "]," .
                "backgroundColor: [\"#F7464A\",\"#46BFBD\"]," .
            "}]," .
            "labels: [\"Total des factures validées\",\"Total des factures non validées\"]" .
        "}," .
        "options: {responsive: true}};";
		
		return $configValue;
	}

	function getBonCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$montantBonValides = Bon::getMontantTotalBonValidee($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant);
		$montantBonNonValides = Bon::getMontantTotalBon($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) - $montantBonValides;
		$configValue = "var configBon = {type: 'pie',data: {".
			"datasets: [{" .
                "data: [" . $montantBonValides . ", " . $montantBonNonValides. "]," .
                "backgroundColor: [\"#F7464A\",\"#46BFBD\"]," .
            "}]," .
            "labels: [\"Total des bons clos\",\"Total des bons non validés\"]" .
        "}," .
        "options: {responsive: true}};";
		
		return $configValue;
	}

	function getAvoirCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) {
		$montantAvoirValides = Avoir::getMontantTotalAvoirValidee($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant);
		$montantAvoirNonValides = Avoir::getMontantTotalAvoir($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant) - $montantAvoirValides;
		
		$configValue = "var configAvoir = {type: 'pie',data: {".
			"datasets: [{" .
                "data: [" . $montantAvoirValides . ", " . $montantAvoirNonValides . "]," .
                "backgroundColor: [\"#F7464A\", \"#46BFBD\"]," .
            "}]," .
            "labels: [\"Total des avoirs clos\", \"Total des avoirs non validés\"]" .
        "}," .
        "options: {responsive: true}};";
		
		return $configValue;
	}

	function getClientCamenbertChart($societeContact) {
		$nbClient = SocieteClient::getNbClient($societeContact->societe->id);
		$nbFournisseur = SocieteClient::getNbFournisseur($societeContact->societe->id);
		$nbProspect = SocieteClient::getNbProspect($societeContact->societe->id);
		
		$configValue = "var configClient = {type: 'pie',data: {".
			"datasets: [{" .
                "data: [" . $nbClient . ", " . $nbFournisseur . ", " . $nbProspect . "]," .
                "backgroundColor: [\"#F7464A\", \"#46BFBD\", \"#BDF746\"]," .
            "}]," .
            "labels: [\"Nb de clients\", \"Nb de fournisseurs\", \"Nb de prospects\"]" .
        "}," .
        "options: {responsive: true}};";
		
		return $configValue;
	}

?>