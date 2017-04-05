<?php
	require("business/facture.php");
	require("business/tva.php");
	require('inc.php');
	require('fpdf.php');
	
	$id = $_GET['id'];
	class PDF extends FPDF
	{
		//En-tête
		function Header()
		{
//			$client = $_GET['client'];
			$id = $_GET['id'];
//			$sel = "select * from client where _ID = '$client'";
//			$resul = mysql_query($sel);
//			$re = mysql_fetch_array($resul);
			$facture = new Facture();
			$facture->findById($id);
			$this->SetY(10);

			//Logo
			$societeContact = $_SESSION['societeContact'];
			
			if (!empty($societeContact->societe->logo)) {
				$this->Image('images/logos/'.$societeContact->societe->logo, 10, 10);
			}
			//Police Arial gras 15
			$this->SetFont('Arial', 'B', 19);
			//Décalage à droite
			$this->Cell(100);
			//Titre
			$this->SetFillColor(230, 230, 230);
			$this->Cell(90, 10, 'FACTURE', 0, 1, 'C', true);
			//Saut de ligne
			$this->SetFont('Arial', '', 9);
			$this->Ln(2);
			//sous titre
			$d1= utf8_decode('Date émission : ' . date('d/m/Y', strtotime($facture->dateEmission)));
			$d2=utf8_decode('Référence devis : ' . $facture->refDevis);
			$this->Cell(100);
			$this->Cell(90, 5, 'Ref : ' . $facture->reference, 0, 0, 'R');
			$this->Ln(1);
			$this->Cell(100);
			$this->Cell(90, 10, $d1, 0, 0, 'R');
			$this->Ln(4);
			$this->Cell(100);
			$this->Cell(90, 10, $d2, 0, 0, 'R');
			$this->Ln(4);
	
			$pag = $this->PageNo();
			if($pag !=1){
	
				//TITRE
				$this->Ln(5);
				$this->Cell(0, 10, utf8_decode($facture->titre) . ' (suite)', 1, 0, 'C');
				$this->Ln(10);
				//En-tête du tableau
				$w = array(100, 15, 16, 14, 21, 24);
				$header = array(utf8_decode('Désignation'), 'TVA %', utf8_decode('Qte'), utf8_decode('Unité'), 'PU HT', 'Total HT');
				for ($i = 0; $i < count($header); $i++) {
					$this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
				}
				$this->Ln();
	
			}
	
		}
	
		//Pied de page
		function Footer()
		{
			//Positionnement à 5 cm du bas
			$this->SetY(-30);
		    //Police Arial italique 8
		    $societeContact = $_SESSION['societeContact'];
			
//			$client = $_GET['client'];
//			$sel = "select * from client where _ID = '$client'";
//			$resul = mysql_query($sel);
//			$re = mysql_fetch_array($resul);

			$pied = $societeContact->societe->piedFacture;
			$pied2 = $societeContact->societe->forme . " - SIRET : " . $societeContact->societe->siret . " - " . $societeContact->societe->rcs . " - NAF : " . $societeContact->societe->ape;
			$pied3 = "- TVAI : " . $societeContact->societe->tvaIntra;
			//$this->Cell(45);
			$this->SetFont('Arial', '', 8);
			$this->MultiCell(0, 3, utf8_decode($pied));
			$this->Cell(0, 10, utf8_decode($pied2) . ' ' . utf8_decode($pied3), 0, 0, 'L');
			$this->Ln(5);
			//Numéro de page
			$this->SetFont('Arial', 'I', 8);
			$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
		}
		//ligne d'un multicell
		var $widths;
		var $aligns;
	
		function SetWidths($w)
		{
			//Tableau des largeurs de colonnes
			$this->widths = $w;
		}
	
		function SetAligns($a)
		{
			//Tableau des alignements de colonnes
			$this->aligns = $a;
		}
	
		function Row($data)
		{
			//Calcule la hauteur de la ligne
			$nb = 0;
			for ($i=0;$i<count($data);$i++) {
				$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
			}
			$h = 5 * $nb;
			//Effectue un saut de page si nécessaire
			$this->CheckPageBreak($h);
			//Dessine les cellules
			for ($i = 0; $i < count($data); $i++)
			{
				$w = $this->widths[$i];
				//Sauve la position courante
				$x = $this->GetX();
				$y = $this->GetY();
				//Dessine le cadre
				$this->Rect($x, $y, $w, $h);
				//Imprime le texte
				$this->MultiCell($w, 5, $data[$i], 0, $this->aligns[$i]);
				//Repositionne à droite
				$this->SetXY($x + $w, $y);
			}
			//Va à la ligne
			$this->Ln($h);
		}
	
		function CheckPageBreak($h)
		{
			//Si la hauteur h provoque un débordement, saut de page manuel
			if($this->GetY() + $h > $this->PageBreakTrigger){
				$this->AddPage($this->CurOrientation);
			}
				
		}
	
		function NbLines($w, $txt)
		{
			//Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
			$cw = &$this->CurrentFont['cw'];
			if ($w == 0) {
				$w = $this->w - $this->rMargin - $this->x;
			}
			$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
			$s = str_replace("\r", '', $txt);
			$nb = strlen($s);
			if ($nb > 0 and $s[$nb - 1] == "\n") {
				$nb--;
			}
			$sep = -1;
			$i = 0;
			$j = 0;
			$l = 0;
			$nl = 1;
			while ($i < $nb)
			{
				$c = $s[$i];
				if ($c == "\n")
				{
					$i++;
					$sep = -1;
					$j = $i;
					$l = 0;
					$nl++;
					continue;
				}
				if ($c == ' ') {
					$sep = $i;
				}
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
						$i++;
					}
					else {
						$i = $sep + 1;
					}
					$sep = -1;
					$j = $i;
					$l = 0;
					$nl++;
				}
				else {
					$i++;
				}
			}
			return $nl;
		}
	
	}

	$allTva = Tva::findAll();
	$usedTva = array();
	ob_get_clean();
	//Instanciation de la classe dérivée
	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(1, 40);
	// COORDONNEES EMETTEUR
	$yy = $pdf->GetY();
	$pdf->SetFillColor(230, 230, 230);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(0);
	$pdf->Cell(0, 10, 'Emetteur', 0, 0, 'L');
	$pdf->Ln();

	$societeContact = $_SESSION['societeContact'];
			
//	$sel = "select * from client where _ID = '$client'";
//	$resul = mysql_query($sel);
//	$re = mysql_fetch_array($resul);
	$SOCIETE = utf8_decode($societeContact->societe->nom);
	$ADRESSE1 = utf8_decode($societeContact->societe->adresse1);
	$ADRESSE2 = utf8_decode($societeContact->societe->adresse2);
	$CP = utf8_decode($societeContact->societe->codePostal);
	$VILLE = utf8_decode($societeContact->societe->ville);
	$TEL = wordwrap ($societeContact->societe->telFix, 2, '.', 1);
	$FAX = wordwrap ($societeContact->societe->fax, 2, '.', 1);
	$MAIL = utf8_decode($societeContact->societe->email);
	$WEB = utf8_decode($societeContact->societe->siteWeb);
	$delai2 = utf8_decode('Modalités de paiement : ' . $societeContact->societe->delai2);

	$pdf->SetFont('Arial', 'B', 12);
	$pdf->MultiCell(90, 5, $SOCIETE, 0, 'L', true);
	$pdf->SetFont('Arial', '', 10);
	$pdf->MultiCell(90, 5, $ADRESSE1, 0, 'L', true);
	if (!empty($ADRESSE2)) {
		$pdf->MultiCell(90, 5, $ADRESSE2, 0, 'L', true);
	}
	$pdf->MultiCell(90, 5, $CP . ' ' . $VILLE, 0, 'L', true);
	$pdf->MultiCell(90, 5, 'TEL ' . $TEL . ' - FAX ' . $FAX, 0, 'L', true);
	$pdf->MultiCell(90, 5, 'Email : ' . $MAIL, 0, 'L', true);
	$pdf->MultiCell(90, 5, 'Web : ' . $WEB, 0, 'L', true);
	$pdf->Ln(0);
	$yyy = $pdf->GetY();
	// COORDONNEES DESTINATAIRE
	$pdf->SetY($yy);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(.3);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(100);
	$pdf->Cell(0, 10, 'Destinataire', 0, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(100);
	$facture = new Facture();
	$facture->findById($id);
	
	$socClient = new SocieteClient();
	$socClient->findByLogin($facture->idSocieteClient);
//	$sel = "select * from contact where _ID = '" . $facture->destinataire . "'";
//	$resul = mysql_query($sel);
//	$re = mysql_fetch_array($resul);

	$SOCIETE = utf8_decode($socClient->entreprise);
	$INTITULE = utf8_decode($socClient->civilite);
	$NOM = utf8_decode($socClient->nom);
	$PRENOM = utf8_decode($socClient->prenom);
	$ADRESSE1 = utf8_decode($socClient->adresse1);
	$ADRESSE2 = utf8_decode($socClient->adresse2);
	$CP = utf8_decode($socClient->codePostal);
	$VILLE = utf8_decode($socClient->ville);
	
	$pdf->MultiCell(90, 5, $SOCIETE, 0, 'L', false);
	$pdf->Cell(100);
	$pdf->MultiCell(90, 5, $INTITULE . ' ' . $PRENOM . ' ' . $NOM, 0, 'L', false);
	$pdf->Cell(100);
	$pdf->MultiCell(90, 5, $ADRESSE1, 0, 'L', false);
	if (!empty($ADRESSE2)) {
		$pdf->Cell(100);
		$pdf->MultiCell(90, 5, $ADRESSE2, 0, 'L', false);
	}
	$pdf->Cell(100);
	$pdf->MultiCell(90, 5, $CP . ' ' . $VILLE, 0, 'L', false);
	$pdf->Ln(0);
	$pdf->SetY($yyy);
	// INTERLOCUTEUR - CONTACT SOCIETE
	$contactFacture = new SocieteContact();
	$contactFacture->findById($facture->idSocieteContact);
//	$selectinter = "select * from interlocuteur where _ID = '" . $facture->idInterlocuteur . "'";
//	$resultinter = mysql_query($selectinter);
//	$rinter = mysql_fetch_array($resultinter);
	
	$pdf->Cell(0, 10, 'Votre interlocuteur : ' . utf8_decode($contactFacture->prenom) . ' ' . utf8_decode($contactFacture->nom), 0, 0, 'L');
	$pdf->Ln();

	//TITRE
	$pdf->MultiCell(0, 5, utf8_decode($facture->titre), 1, 'C', false);
	$pdf->Ln(10);
	
	//TABLEAU : LISTING ligne_facture : couleurs, épaisseur du trait et police grasse
	$pdf->SetFillColor(230, 230, 230);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(.3);
	$pdf->SetFont('Arial', 'B', 10);

	//En-tête du tableau
	// En-tête du tableau
	$wLignes = array(100, 15, 16, 14, 21, 24);
	$aLignes = array('L', 'R', 'R', 'R', 'R', 'R');
	$headerLignes = array(utf8_decode('Désignation'), 'TVA %', utf8_decode('Qte'), utf8_decode('Unité'), 'PU HT', 'Total HT');

	//Restauration des couleurs et de la police
	//$pdf->SetFillColor(224,235,255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial', '', 10);

	//Données
	$fill = false;
	foreach ($facture->groupes as $groupe) {
		$pdf->Cell(190, 7, utf8_decode("Détail de l'ensemble :" . $groupe->designation), 1, 0, 'L', true);
		$pdf->Ln();
		for ($i = 0; $i < count($headerLignes); $i++) {
			$pdf->Cell($wLignes[$i], 7, $headerLignes[$i], 1, 0, 'L', 1);
		}
		$pdf->Ln();
		foreach ($groupe->lignes as $ligne) {
			$designation = utf8_decode($ligne->designation);
			$UNITE = utf8_decode($ligne->unite);
			$QTE = $ligne->getQuantiteFormat();
			$PUHT = $ligne->getUnitHTPriceFormat();
			$t1 = $ligne->getHTPriceFormat();
			$ttva = $allTva[$ligne->tauxTva];
			$pdf->SetWidths($wLignes);
			$pdf->SetAligns($aLignes);
			$pdf->Row(array($designation, $ttva->libelle, $QTE, $UNITE, $PUHT, $t1));

			if (empty($usedTva[$ttva->id])) {
				$usedTva[$ttva->id] = $ttva->id;
			}
		}
		$pdf->Cell(115);
		$pdf->Cell(51, 5, 'Sous total :', 1, 0, 'L', true);
		$pdf->Cell(24, 5, $groupe->getHTPriceFormat(), 1, 0, 'R', true);
		$pdf->Ln();
		$pdf->Ln();
	}

	//TOTAUX
	$yyy = array($pdf->PageNo(), $pdf->GetY());
	$pdf->Ln();
	if ($pdf->GetY() + 40 > $pdf->PageBreakTrigger) {
		$pdf->AddPage();
	}
	$pdf->Cell(100, 5, 'Commentaires', 0, 0, 'L');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 7);
	$chaine = str_replace('€', 'euros', $facture->commentaire);
	$pdf->MultiCell(100, 5, utf8_decode($chaine), 1, 'L', false);
	$pdf->SetFont('Arial', '', 9);
	$pdf->Ln(1);
	if ($pdf->GetY() + 35 > $pdf->PageBreakTrigger) {
		$pdf->AddPage();
	}
	$pdf->Cell(100, 5, 'Observations', 0, 0, 'L');
	$pdf->Ln();
	$pdf->Cell(100, 30, '', 1, 0, 'L');
	$pdf->Ln();
	
	$pdf->MultiCell(100, 5, $delai2, 0, 'L', false);
	if ($yyy[0] == $pdf->PageNo()) {
		$pdf->SetY($yyy[1]);
		if ($pdf->GetY() + 40 > $pdf->PageBreakTrigger) {
			$pdf->AddPage();
		}
	}
	else {
		$pdf->SetY(70);
	}
	//$pdf->Ln(5);
	if (!empty($facture->remise) && $facture->remise != 0) {
		$pdf->Cell(115);
		$pdf->Cell(51, 5, 'TOTAL HT :', 0, 0, 'L', false);
		$pdf->Cell(24, 5, $facture->getHTPriceFormat(), 0, 0, 'R');
		$pdf->Ln();
//		$remise=$tll * $rd['REMISE'] / 100;
//		$remise=number_format($remise, 2, ',', ' ');
		$pdf->Cell(115);
		$pdf->Cell(51, 5, 'Remise globale ' . $facture->getRemiseFormat() . ' % :', 0, 0, 'L');
		$pdf->Cell(24, 5, $facture->getTotalRemiseFormat(), 0, 0, 'R');
		$pdf->Ln();
		$pdf->Cell(115);
		$pdf->Cell(51, 5, 'TOTAL HT NET :', 0, 0, 'L', true);
		$pdf->Cell(24, 5, $facture->getHTPriceRemiseFormat(), 0, 0, 'R', true);
		$pdf->Ln();
	} else {
		$pdf->Cell(115);
		$pdf->Cell(51, 5, 'TOTAL HT :', 0, 0, 'L');
		$pdf->Cell(24, 5, $facture->getHTPriceRemiseFormat(), 0, 0, 'R');
		$pdf->Ln();
	}

	foreach ($allTva as $tva) {
		if ($tva->id != 0.0 && ($tva->isActif || !empty($usedTva[$tva->id]))) {
			$pdf->Cell(115);
			$pdf->Cell(51, 5, 'TVA ' . $tva->libelle . ' :', 0, 0, 'L');
			$pdf->Cell(24, 5, $facture->getTvaPriceFormat($tva->id), 0, 0, 'R');
			$pdf->Ln();
		}
	}
	
	$pdf->Cell(115);
	$pdf->Cell(51, 5, 'TOTAL TTC :', 0, 0, 'L', true);
	$pdf->Cell(24, 5, $facture->getTTCPriceFormat(), 0, 0, 'R', true);
	$pdf->Ln(10);

	$allAcompte = Acompte::findByFacture($facture->id);
	if (count($allAcompte) > 0) {
		$pdf->Cell(115);
		$pdf->Cell(51, 5, utf8_decode('Acompte(s) :'), 0, 0, 'L');
		$pdf->Ln();
		foreach ($allAcompte as $acompte) {
			$pdf->Cell(115);
			$pdf->Cell(51, 5, utf8_decode($acompte->reference), 0, 0, 'L');
			$pdf->Cell(24, 5, $acompte->getMontantFormat(), 0, 0, 'R');
			$pdf->Ln();
		}
	}
	
	$pdf->Cell(115);
	$pdf->Cell(51, 5, utf8_decode('Restant dû TTC :'), 0, 0, 'L', true);
	$pdf->Cell(24, 5, $facture->getResteAPayerTTCFormat(), 0, 0, 'R', true);
	$pdf->Ln(10);
	$pdf->Cell(115);
	$reglement=utf8_decode('En votre aimable réglement');
	$pdf->Cell(75, 5, $reglement, 0, 0, 'L');
	
	if ($pdf->GetY() + 50 > $pdf->PageBreakTrigger) {
		$pdf->AddPage();
	}
	//$pdf->Cell(115);
	//$pdf->Cell(51,5,'Bon pour accord',0,0,'L');
	//$pdf->Ln();
	//$pdf->Cell(115);
	//$pdf->MultiCell(75,5,"\n\n\n\n\n Date et signature",1,'L',false);
	//$pdf->Cell(0,10,$client,0,'','T');

	$x = 10;
	$y = $pdf->GetY()+10;
	$resultat = mysql_query('SELECT LOGO FROM societe_logo_bas_de_page WHERE ID_SOCIETE ='.$societeContact->societe->id);
	while ($ligne = mysql_fetch_assoc($resultat))
	{
		$pdf->Image('images/logos_bas_de_page/'.$ligne['LOGO'], $x , $y+10,20);
		$x = $x + 22;
	}
	
	$pdf->Output();

?>