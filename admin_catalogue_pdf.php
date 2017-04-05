<?php
require('inc.php');
require('fpdf.php');
class PDF extends FPDF
{
//En-tête
function Header()
{
$this->SetY(10);
    //Logo  
    //Police Arial gras 15
    $this->SetFont('Arial','B',19);
      
    //Titre
	$this->SetFillColor(230,230,230);
    $this->Cell(90,10,'CATALOGUE CAP ACHAT',0,1,'C',true);
    //Saut de ligne
	$this->SetFont('Arial','',9);
    $this->Ln(2);
	//sous titre
	 $d1= utf8_decode('Date émission : '.date("d / m  / Y"));
	 $pag=$this->PageNo(); 

}

//Pied de page
function Footer()
{
    //Positionnement à 5 cm du bas
    $this->SetY(-30);
    //Numéro de page
	$this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
}
//ligne d'un multicell
var $widths;
var $aligns;

function SetWidths($w)
{
    //Tableau des largeurs de colonnes
    $this->widths=$w;
}

function SetAligns($a)
{
    //Tableau des alignements de colonnes
    $this->aligns=$a;
}

function Row($data)
{
    //Calcule la hauteur de la ligne
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Effectue un saut de page si nécessaire
    $this->CheckPageBreak($h);
    //Dessine les cellules
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		$b=isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';
        //Sauve la position courante
        $x=$this->GetX();
        $y=$this->GetY();
        //Dessine le cadre
        $this->Rect($x,$y,$w,$h);
        //Imprime le texte
		if($i==0){
        $this->MultiCell($w,5,$data[$i],0,$a);
		}else{
		$this->MultiCell($w,5,$data[$i],0,$b);
		}
        //Repositionne à droite
        $this->SetXY($x+$w,$y);
    }
    //Va à la ligne
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //Si la hauteur h provoque un débordement, saut de page manuel
    if($this->GetY()+$h>$this->PageBreakTrigger){
        $this->AddPage($this->CurOrientation);		
		}
   
}

function NbLines($w,$txt)
{
    //Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}



}


//Instanciation de la classe dérivée
$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(1,40);


$pdf->Cell(0,10,utf8_decode($rd[TITRE]),1,0,'C');
$pdf->Ln(10);
	 
//TABLEAU : LISTING ligne_devis : couleurs, épaisseur du trait et police grasse 
    $pdf->SetFillColor(230,230,230);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','B',6);
    //En-tête du tableau
    $w=array(20,30,20,80,10,15,15);
	$header=array(utf8_decode('REF. INTERNE'),utf8_decode('MARQUE'),utf8_decode('REFERENCE'),utf8_decode('DESIGNATION'),utf8_decode('UNITE'),utf8_decode('PRIX PUBLIC'),'CAP ACHAT');
    for($i=0;$i<count($header);$i++){
        $pdf->Cell($w[$i],7,$header[$i],1,0,'L',1);		
		}
    $pdf->Ln();
    //Restauration des couleurs et de la police
    //$pdf->SetFillColor(224,235,255);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetLineWidth(.3);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','',7);
    //Données
	$select="select*from catalogue where client!='1' order by FOURNISSEUR,FAMILLE,SOUS_FAMILLE";
	$result=mysql_query($select);
    $fill=false;
    while($res=mysql_fetch_array($result)){
	    $DESIGNATION=utf8_decode($res[DESIGNATION]);
		$FAMILLE=utf8_decode($res[FAMILLE]);
		$SOUS_FAMILLE=utf8_decode($res[SOUS_FAMILLE]);
		$FOURNISSEUR=utf8_decode($res[FOURNISSEUR]);
		$REFERENCE=utf8_decode($res[REFERENCE]);
		$REF_INTERNE=utf8_decode($res[REF_INTERNE]);
		$MARQUE=utf8_decode($res[MARQUE]);
		$PRIX_AU=number_format($res[PRIX_AU]);
		$PRIX_BASE=number_format($res[PRIX_BASE],2,',',' ');
		$PRIX_NET=number_format($res[PRIX_NET],2,',',' ');	
		if($pdf->GetY()+20>$pdf->PageBreakTrigger){
	        $pdf->AddPage();		
		}	
		if($F!=$FOURNISSEUR){
			$pdf->Cell(190,7,'Catalogue'.utf8_decode($FOURNISSEUR),1,0,'C',1);
			$pdf->Ln();
			$F=$FOURNISSEUR;
		}	
		if($Fa!=$FAMILLE){
			$pdf->Cell(190,7,'Famille de produits : '.utf8_decode($FAMILLE),1,0,'R',1);
			$pdf->Ln();
			$Fa=$FAMILLE;
		}	
		if($SFa!=$SOUS_FAMILLE){
			$pdf->Cell(190,7,'Sous famille de produits : '.utf8_decode($SOUS_FAMILLE),1,0,'R',1);
			$pdf->Ln();
			$SFa=$SOUS_FAMILLE;
		}	
		$pdf->SetWidths(array($w[0],$w[1],$w[2],$w[3],$w[4],$w[5],$w[6]));
	    $pdf->Row(array($REF_INTERNE,$MARQUE,$REFERENCE,$DESIGNATION,$PRIX_AU,$PRIX_BASE,$PRIX_NET));
    }	
	
$pdf->Output();
?>