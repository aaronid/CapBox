<!--
function format1(valeur) {
// formate un chiffre avec 'decimal' chiffres après la virgule et un separateur
	var deci=Math.round( Math.pow(10,2)*(Math.abs(valeur)-Math.floor(Math.abs(valeur)))) ; 
	var val=Math.floor(Math.abs(valeur));
	var val_format=val+"";
	var nb=val_format.length;
	for (var i=1;i<4;i++) {
		if (val>=Math.pow(10,(3*i))) {
			val_format=val_format.substring(0,nb-(3*i))+" "+val_format.substring(nb-(3*i));
		}
	}
	
		var decim=""; 
		for (var j=0;j<(2-deci.toString().length);j++) {decim+="0";}
		deci=decim+deci.toString();
		val_format=val_format+","+deci;	
	
	return val_format;
}
function format2(valeur) {
valeur2= valeur.replace(',','.');
valeur2= valeur2.replace(' ','');
if(Math.abs(valeur2)>0){
valeur2= parseFloat(valeur2);
}else{
valeur2=0;	
}
valeur2=valeur2.toFixed(2);
return (valeur2);
}

var compteur =1;
var tab_cout = new Array();
var tva5_cout = new Array();
var tva19_cout = new Array();

function remplis(nume,design,quant,unite,prix,tva){
document.getElementById("designation"+nume).value=design;
document.getElementById("quant"+nume).value=quant;
document.getElementById("unite"+nume).value=unite;
document.getElementById("prix"+nume).value=prix;
document.getElementById("tauxtva"+nume).value=tva;
//document.getElementById("Htotalht").value=document.getElementById("Htotalht").value+(document.getElementById("Hquant"+nume).value*document.getElementById("unite"+nume));
}

function calcul(inp,num)
{ 
if(inp=="q"){
document.getElementById("Hquant"+num).value=format2(document.getElementById("quant"+num).value);
document.getElementById("quant"+num).value=format1(document.getElementById("Hquant"+num).value);
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}else if(inp=="p"){
document.getElementById("Hprix"+num).value=format2(document.getElementById("prix"+num).value);
document.getElementById("prix"+num).value=format1(document.getElementById("Hprix"+num).value);
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}else if(inp=="t"){
document.getElementById("Hquant"+num).value=format2(document.getElementById("quant"+num).value);
document.getElementById("quant"+num).value=format1(document.getElementById("Hquant"+num).value);
document.getElementById("Hprix"+num).value=format2(document.getElementById("prix"+num).value);
document.getElementById("prix"+num).value=format1(document.getElementById("Hprix"+num).value);
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}else if(inp=="r"){
document.getElementById("Hremise1").value=format2(document.getElementById("remise1").value);
document.getElementById("remise1").value=format1(document.getElementById("Hremise1").value);
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}
else if(inp=="a"){
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}else if(inp=="x"){
document.getElementById("Hquant"+num).value=format2(document.getElementById("quant"+num).value);
document.getElementById("quant"+num).value=format1(document.getElementById("Hquant"+num).value);
document.getElementById("Hprix"+num).value=format2(document.getElementById("prix"+num).value);
document.getElementById("prix"+num).value=format1(document.getElementById("Hprix"+num).value);
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("acompte").value=format1(document.getElementById("Hacompte").value);
}
var ht=document.getElementById("Htotalht").value;
if(ht==0){
tab_cout = new Array();
tva5_cout = new Array();
tva19_cout = new Array();
}
var numm=0;
var tva=0;
var total1=0;

if (  Math.abs(num) > 0 ){

numm=parseFloat(document.getElementById("Hquant"+num).value)*parseFloat(document.getElementById("Hprix"+num).value);
//document.getElementById("quant"+num).value=format1(document.getElementById("quant"+num).value);

if (  Math.abs(numm) > 0 ){
document.getElementById("total"+num).innerHTML= format1(numm);
tva = numm*parseFloat(document.getElementById("tauxtva"+num).value);
//document.getElementById("totaltva"+num).value= numm*(document.getElementById("tauxtva"+num).value);
//document.getElementById("totalt"+num).value= tva+numm; 
tab_cout[num] = numm;
if(parseFloat(document.getElementById("tauxtva"+num).value)==tvaclient2){
tva5_cout[num] = tva;
tva19_cout[num] = 0;
}else{
tva19_cout[num] = tva;
tva5_cout[num] = 0;
}}
 
 //totalHT
 }
tot = 0;
var totcompteur=parseFloat(document.getElementById('d_hid').value);
for (var i=0; i < totcompteur;i++) {
	if(Math.abs(tab_cout[i]) >= 0 ){
 tot = tot+tab_cout[i];
	}
}
var tva5 = 0;
for (var i=0; i < totcompteur;i++) {
	if(Math.abs(tva5_cout[i]) >= 0 ){
 tva5 = tva5+tva5_cout[i];
	}
}
var tva19 = 0;
for (var i=0; i < totcompteur;i++) {
	if(Math.abs(tva19_cout[i]) >= 0 ){
 tva19 = tva19+tva19_cout[i];
	}
}

document.getElementById("Htotalht").value= tot;
document.getElementById("totalht").innerHTML= format1(document.getElementById("Htotalht").value);
document.getElementById("Htva55").value= tva5-(tva5*(document.getElementById("Hremise1").value)/100);
document.getElementById("Htva19").value= tva19-(tva19*(document.getElementById("Hremise1").value)/100);
document.getElementById("Hremise2").value= (parseInt(document.getElementById("Hremise1").value)/100)*parseFloat(document.getElementById("Htotalht").value);
document.getElementById("Htotalht1").value= parseFloat(document.getElementById("Htotalht").value)-document.getElementById("Hremise2").value;
document.getElementById("totalht1").innerHTML= format1(document.getElementById("Htotalht1").value);
document.getElementById("tva55").innerHTML= format1(document.getElementById("Htva55").value);
document.getElementById("tva19").innerHTML= format1(document.getElementById("Htva19").value);

document.getElementById("Htotalttc").value= parseFloat(document.getElementById("Htva55").value)+parseFloat(document.getElementById("Htva19").value)+parseFloat(document.getElementById("Htotalht1").value);
document.getElementById("totalttc").innerHTML= format1(document.getElementById("Htotalttc").value);
document.getElementById("remise2").innerHTML= format1(document.getElementById("Hremise2").value);
document.getElementById("restettc").innerHTML= "<strong>"+format1((document.getElementById("Htotalttc").value)-(document.getElementById("Hacompte").value))+"€ TTC</strong>";	
numm=0;
}

function uncalcul(nn)
{
var untotalht=parseFloat(document.getElementById("Htotalht").value);	
var unquant=parseFloat(document.getElementById("Hquant"+nn).value)*parseFloat(document.getElementById("Hprix"+nn).value);
var un_tva=parseFloat(document.getElementById("tauxtva"+nn).value);
var untva55=parseFloat(document.getElementById("Htva55").value);
var untva19=parseFloat(document.getElementById("Htva19").value);
var unremise=parseFloat(document.getElementById("Hremise1").value);

if(Math.abs(unquant)>0){
tab_cout[nn] = 0;
tva5_cout[nn] = 0;
tva19_cout[nn] = 0;
document.getElementById("Htotalht").value= untotalht-unquant;
document.getElementById("totalht").innerHTML= format1(document.getElementById("Htotalht").value);
untotalht=parseFloat(document.getElementById("Htotalht").value);	
if(Math.abs(un_tva)>0){
	if(un_tva=="tvaclient2"){
document.getElementById("Htva55").value= untva55-((un_tva*unquant)-(un_tva*unquant)*unremise/100);
document.getElementById("tva55").innerHTML= format1(document.getElementById("Htva55").value);

	}else{
document.getElementById("Htva19").value= untva19-((un_tva*unquant)-(un_tva*unquant)*unremise/100);
document.getElementById("tva19").innerHTML= format1(document.getElementById("Htva19").value);

	}
}else{
	un_tva=0;
}
untva55=parseFloat(document.getElementById("Htva55").value);
untva19=parseFloat(document.getElementById("Htva19").value);
document.getElementById("Htotalht1").value= untotalht+untva55+untva19;
document.getElementById("totalht1").innerHTML= format1(document.getElementById("Htotalht1").value);
var untotalht1=parseFloat(document.getElementById("Htotalht1").value);
document.getElementById("Hremise2").value= parseFloat(document.getElementById("remise1").value)/100*untotalht1;
document.getElementById("remise2").innerHTML= format1(document.getElementById("Hremise2").value);
var unremise=parseFloat(document.getElementById("Hremise2").value);
document.getElementById("Htotalttc").value= untotalht1+unremise;
document.getElementById("totalttc").innerHTML= format1(document.getElementById("Htotalttc").value);
//document.getElementById("acompte2").innerHTML= "<strong>% soit "+format1((document.getElementById("Htotalttc").value)*(document.getElementById("Hacompte").value)/100)+"€ TTC</strong>";
nn=0;
}
}
function reste(){
document.getElementById("Hacompte").value=format2(document.getElementById("acompte").value);
document.getElementById("restettc").innerHTML= "<strong>"+format1((document.getElementById("Htotalttc").value)-(document.getElementById("Hacompte").value))+"€ TTC</strong>";	
}
function suppression(ligne){
	document.getElementById('tableArticle').deleteRow(ligne.rowIndex);
	}


function ajoutLigne(nem)
{ 
if(Math.abs(nem)>0){
	compteur=nem;
}
  var Cell;
  //var nom = document.forms["formulaire"].nom.value;
  //var prenom = document.forms["formulaire"].prenom.value;
  var tableau = document.getElementById('tableArticle');
  var ligne = tableau.insertRow(-1); 
  
Cell = ligne.insertCell(0);
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
 Cell.innerHTML = "<textarea name=\"designation"+compteur+"\" id=\"designation"+compteur+"\" value=\""+compteur+"\"cols=\"85\"></textarea><input type=\"hidden\" name=\"numero"+compteur+"\" id=\"numero"+compteur+"\"value=\""+compteur+"\"/>";

  
Cell = ligne.insertCell(1);
Cell.style.backgroundColor='#EAF0F7';
  Cell.innerHTML = "<div align=center><a href=\"#\" onclick=\"window.open('catalogue_liste_pop.php?pop="+compteur+"','','scrollbars=yes,resizable=yes,width=825,height=600')\" ><img src=images/icones/panier-ajouter-icone-7116-32.png width=32 height=32 /></a></div>";
  Cell = ligne.insertCell(2); 
  Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
  Cell.innerHTML = "<div align=left> <input id=quant"+compteur+" name=quant"+compteur+" size=5  alt=quantite value=\"1\" onchange=\"calcul('q',"+compteur+")\"/><input id=Hquant"+compteur+" name=Hquant"+compteur+" type=\"hidden\" value=\"1\"/></div>";
Cell = ligne.insertCell(3); 
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
Cell.style.textAlign='right';
Cell.innerHTML = "<div align=left><select name=unite"+compteur+" id=unite"+compteur+"><option >Pièce</option><option >m²</option><option >heure</option><option >jour</option><option >ml</option><option >forfait</option><option >m3</option></select></div>";
			  
Cell = ligne.insertCell(4); 
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
Cell.style.textAlign='right';
 Cell.innerHTML ="<div align=left><input id=prix"+compteur+" name=prix"+compteur+" size=10 alt=montant onchange=\"calcul('p',"+compteur+")\"/><input id=Hprix"+compteur+" name=Hprix"+compteur+" type=\"hidden\" /></div>";
Cell = ligne.insertCell(5); 
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
Cell.style.textAlign='right';
 Cell.innerHTML ="<div align=left><select name=\"tauxtva"+compteur+"\" id=\"tauxtva"+compteur+"\" onchange=\"calcul('0',"+compteur+")\";><option value=\""+tvaclient1+"\">"+tvaclient11+"%</option><option value=\""+tvaclient2+"\">"+tvaclient22+"%</option><option></option></select></div>";
Cell = ligne.insertCell(6); 
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
Cell.style.textAlign='right';
  Cell.innerHTML ="<div id=\"total"+compteur+"\" name=\"total"+compteur+"\"></div>";

Cell = ligne.insertCell(7);
Cell.style.borderColor='#84F0FF';
Cell.style.backgroundColor='#EAF0F7';
Cell.style.textAlign='right';
  var bouton = document.createElement("input");
  bouton.type = "button";
  bouton.title = "Supprimer"+compteur+"";
  bouton.setAttribute ("style","border: none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor: pointer; vertical-align: middle;");
  //bouton.onclick = function(){};
  var compteur2= compteur;
  bouton.onclick = function(){uncalcul(compteur2);suppression(ligne);};
 Cell.appendChild(bouton);  
 compteur++
  document.getElementById("d_hid").value=parseFloat(compteur);

}
