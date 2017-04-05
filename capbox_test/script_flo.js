<!--
function format1(valeur)
{
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
	for (var j=0;j<(2-deci.toString().length);j++) {
		decim+="0";
	}
	deci=decim+deci.toString();
	val_format=val_format+","+deci;	
	
	return val_format;
}

function format2(valeur)
{
	if (valeur == undefined || valeur == null || valeur == "") {
		valeur = "0.0";
	}
	valeur2 = valeur.replace(',','.');
	valeur2 = valeur2.replace(' ','');
	if (Math.abs(valeur2) > 0) {
		valeur2 = parseFloat(valeur2);
	}
	else {
		valeur2 = 0;
	}
	valeur2 = valeur2.toFixed(2);
	return valeur2;
}

function calculPourcentAcompte()
{
	var totalFacture = document.getElementById("HtotalFacture").value;
	var newTotalTTC = format2(document.getElementById("montant").value);
	document.getElementById("Hmontant").value = newTotalTTC;
	document.getElementById("montant").value = format1(newTotalTTC);
	
	var newPourcent = newTotalTTC * 100 / totalFacture;
	document.getElementById("Hpourcent").value = newPourcent.toFixed(2);
	document.getElementById("pourcent").value = format1(newPourcent);
	
	reloadTotalAcompte();
}

function calculMontantAcompte()
{
	var totalFacture = document.getElementById("HtotalFacture").value;
	var newPourcent = format2(document.getElementById("pourcent").value);
	document.getElementById("Hpourcent").value = newPourcent;
	document.getElementById("pourcent").value = format1(newPourcent);
	
	var newTotalTTC = newPourcent * totalFacture / 100;
	document.getElementById("Hmontant").value = newTotalTTC.toFixed(2);
	document.getElementById("montant").value = format1(newTotalTTC);
	
	reloadTotalAcompte();
}

function reloadTotalAcompte()
{
	var oldTotalTTC = document.getElementById("Htotalttc").value;
	var newTotalTTC = document.getElementById("Hmontant").value;
	document.getElementById("Htotalttc").value = newTotalTTC;
	document.getElementById("totalttc").innerHTML = "<strong>" + format1(newTotalTTC) + "</strong>";
	
	var oldResteTTC = document.getElementById("Hrestettc").value;
	var newResteTTC = parseFloat(oldResteTTC) + parseFloat(oldTotalTTC) - parseFloat(newTotalTTC);
	document.getElementById("Hrestettc").value = newResteTTC.toFixed(2);
	document.getElementById("restettc").innerHTML = "<strong>" + format1(newResteTTC.toFixed(2)) + "</strong>";
}

function calcul(inp, num)
{
	if (num != '0') {
		var idGroupe = num.split("_")[0];
		var oldTotalHT = getTotalHT(num);
		var tot = parseFloat(document.getElementById("Htotalht").value) - oldTotalHT;
		var totGrp = parseFloat(format2(document.getElementById("total" + idGroupe).innerHTML)) - oldTotalHT;
		
		var oldTva = document.getElementById("Htauxtva" + num).value;
		if (oldTva != undefined && oldTva != null && oldTva != "" && oldTva != 0) {
			var oldTotalTva = parseFloat(document.getElementById("Htva" + oldTva).value) / (1 - getTauxRemise());
	
			oldTotalTva = oldTotalTva - (oldTotalHT * oldTva);
	
			document.getElementById("Htva" + oldTva).value = oldTotalTva * (1 - getTauxRemise());
			document.getElementById("tva" + oldTva).innerHTML = format1(document.getElementById("Htva" + oldTva).value);
		}
	}

	if(inp=="q"){
		document.getElementById("Hquant"+num).value=format2(document.getElementById("quant"+num).value);
		document.getElementById("quant"+num).value=format1(document.getElementById("Hquant"+num).value);
	}else if(inp=="p"){
		document.getElementById("Hprix"+num).value=format2(document.getElementById("prix"+num).value);
		document.getElementById("prix"+num).value=format1(document.getElementById("Hprix"+num).value);
	}else if(inp=="t"){
		document.getElementById("Hquant"+num).value=format2(document.getElementById("quant"+num).value);
		document.getElementById("quant"+num).value=format1(document.getElementById("Hquant"+num).value);
		document.getElementById("Hprix"+num).value=format2(document.getElementById("prix"+num).value);
		document.getElementById("prix"+num).value=format1(document.getElementById("Hprix"+num).value);
	}else if(inp=="r"){
		var oldRemise = document.getElementById("Hremise1").value;
		var newRemise = format2(document.getElementById("remise1").value);
		document.getElementById("Hremise1").value = newRemise;
		document.getElementById("remise1").value = format1(newRemise);
		reloadAllTva(oldRemise, newRemise);
	}else if(inp=="a"){
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
	
	if (num != '0') {
		var numm = getTotalHT(num);
		var newTva = numm * parseFloat(document.getElementById("tauxtva" + num).value);

		document.getElementById("Htauxtva" + num).value = document.getElementById("tauxtva" + num).value;
		document.getElementById("total" + num).innerHTML = format1(numm);
 
		tot = tot + numm;
		totGrp = totGrp + numm;

		document.getElementById("total" + idGroupe).innerHTML =	format1(totGrp);
		document.getElementById("Htotalht").value = tot;
		document.getElementById("totalht").innerHTML = format1(tot);

		var newTva = document.getElementById("tauxtva" + num).value;
		if (newTva != undefined && newTva != null && newTva != "" && newTva != 0) {
			var newTotalTva = parseFloat(document.getElementById("Htva" + newTva).value) / (1 - getTauxRemise());

			newTotalTva = newTotalTva + (numm * newTva);

			document.getElementById("Htva" + newTva).value = newTotalTva * (1 - getTauxRemise());
			document.getElementById("tva" + newTva).innerHTML = format1(document.getElementById("Htva" + newTva).value);
		}
	}
	
	reloadTotal();
}

function uncalcul(idHtml)
{
	var idGroupe = idHtml.split("_")[0];
	var untotalht = parseFloat(document.getElementById("Htotalht").value);	
	var unquant = getTotalHT(idHtml);
	var un_tva = parseFloat(document.getElementById("tauxtva" + idHtml).value);
	var unremise = parseFloat(document.getElementById("Hremise1").value);

	var totGrp = parseFloat(format2(document.getElementById("total" + idGroupe).innerHTML)) - unquant;
	document.getElementById("total" + idGroupe).innerHTML =	format1(totGrp);

	document.getElementById("Htotalht").value = untotalht - unquant;
	document.getElementById("totalht").innerHTML = format1(document.getElementById("Htotalht").value);
	untotalht = parseFloat(document.getElementById("Htotalht").value);	

	if (un_tva != undefined && un_tva != null && un_tva != "" && un_tva != 0) {
		var totalTva = parseFloat(document.getElementById("Htva" + un_tva).value) / (1 - getTauxRemise());
	
		totalTva = totalTva - (un_tva * unquant);
	
		document.getElementById("Htva" + un_tva).value = totalTva * (1 - getTauxRemise());
		document.getElementById("tva" + un_tva).innerHTML = format1(document.getElementById("Htva" + un_tva).value);
	}
	
	reloadTotal();
}

function reloadTotal()
{ 
	document.getElementById("Hremise2").value = getTauxRemise() * parseFloat(document.getElementById("Htotalht").value);
	document.getElementById("remise2").innerHTML = format1(document.getElementById("Hremise2").value);
	document.getElementById("Htotalht1").value = parseFloat(document.getElementById("Htotalht").value) - parseFloat(document.getElementById("Hremise2").value);
	document.getElementById("totalht1").innerHTML = format1(document.getElementById("Htotalht1").value);

	var totalTtc = parseFloat(document.getElementById("Htotalht1").value);
	var idInputs = document.getElementsByTagName("input");
	for (var i = 0; i < idInputs.length; i++) {
		var anInput = idInputs[i];
		if (anInput.id.indexOf("Htva") == 0) {
			totalTtc = totalTtc + parseFloat(anInput.value);
		}
	}
	document.getElementById("Htotalttc").value = totalTtc;
	document.getElementById("totalttc").innerHTML = format1(document.getElementById("Htotalttc").value);

	if (document.getElementById("acompte2") != undefined) {
		var montantAcompte = document.getElementById("Htotalttc").value * getTauxAcompte();
		document.getElementById("acompte2").innerHTML = "<strong>% soit " + format1(montantAcompte) + "€ TTC</strong>";
	}
	if (document.getElementById("restettc") != undefined) {
		reste();
	}
}

function reloadAllTva(oldRemise, newRemise){
	var idInputs = document.getElementsByTagName("input");
	for (var i = 0; i < idInputs.length; i++) {
		var anInput = idInputs[i];
		if (anInput.id.indexOf("Htva") == 0) {
			var totalTvaSansRemise = parseFloat(anInput.value) / (1 - (oldRemise / 100));
			anInput.value = totalTvaSansRemise * (1 - (newRemise / 100));
			document.getElementById(anInput.id.substring(1)).innerHTML = format1(anInput.value);
		}
	}
}

function getTotalHT(idHtml)
{ 
	return parseFloat(document.getElementById("Hquant"+idHtml).value)*parseFloat(document.getElementById("Hprix"+idHtml).value);
}

function getTauxAcompte()
{
	return parseFloat(document.getElementById("Hacompte").value)/100;
}

function getTauxRemise()
{
	return parseFloat(document.getElementById("Hremise1").value)/100;
}

function reste()
{
	var montantAcompte = document.getElementById("Htotalttc").value - document.getElementById("Hacompte").value;
	document.getElementById("restettc").innerHTML = "<strong>" + format1(montantAcompte) + "€ TTC</strong>";
}

function suppressionGroupe(idGroupe)
{
	var idGrp = document.getElementById("idGrp" + idGroupe);
	var indexRow = idGrp.parentNode.parentNode.rowIndex;
	var tabArticle = document.getElementById('tableArticle');
	tabArticle.deleteRow(indexRow);

	var idLines = document.getElementsByTagName("input");
	for (var i = 0; i < idLines.length; i++) {
		var line = idLines[i];
		if (line.id.indexOf("idLine" + idGroupe + "_") == 0) {
			suppressionLigne(line.value);
			i--;
		}
	}
	
	var sepGrp = document.getElementById("sep" + idGroupe);
	indexRow = sepGrp.parentNode.rowIndex;
	tabArticle.deleteRow(indexRow);

	var totalGrp = document.getElementById("total" + idGroupe);
	indexRow = totalGrp.parentNode.parentNode.rowIndex;
	tabArticle.deleteRow(indexRow);
}

function suppressionLigne(idHtml)
{
	uncalcul(idHtml);
	var totalGrp = document.getElementById("total" + idHtml);
	var indexRow = totalGrp.parentNode.parentNode.rowIndex;
	document.getElementById('tableArticle').deleteRow(indexRow);
}

function ajoutGroupe()
{
	var newIdGrp = 0;
	while (document.getElementById('idGrpNew' + newIdGrp) != undefined) {
		newIdGrp += 1;
	}
	
	var Cell;
	var tableau = document.getElementById('tableArticle');
	var ligne = tableau.insertRow(-1);
  
	Cell = ligne.insertCell(0);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<textarea name=\"designationGrpNew" + newIdGrp + "\" id=\"designationGrpNew" + newIdGrp + "\" cols=\"70\"></textarea><input type=\"hidden\" name=\"idGrpNew" + newIdGrp + "\" id=\"idGrpNew" + newIdGrp + "\" value=\"New" + newIdGrp + "\"/>";

	Cell = ligne.insertCell(1);
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<div align=\"center\"><a href=\"#\" onclick=\"ajoutLigne('New" + newIdGrp + "')\" title=\"Ajouter une ligne\"><img src=\"images/icones/ajouter-crayon-icone-4828-32.png\" width=\"32\" height=\"32\" /></a></div>";

	Cell = ligne.insertCell(2);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.setAttribute('colspan','5');

	Cell = ligne.insertCell(3);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	var bouton = document.createElement("input");
	bouton.type = "button";
	bouton.title = "Supprimer cet ensemble de ligne";
	bouton.setAttribute ("style","border: none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor: pointer; vertical-align: middle;");
	bouton.onclick = function(){suppressionGroupe("New" + newIdGrp);};
	Cell.appendChild(bouton);  
	
	// Ajout du sous total du groupe
	var ligneSep = tableau.insertRow(-1);
	
	Cell = ligneSep.insertCell(0);
	Cell.id = "sepNew" + newIdGrp;
	Cell.style.heigth=1;
	Cell.style.backgroundColor='#5289BA';
	Cell.setAttribute('colspan','8');

	var ligneSsTot = tableau.insertRow(-1);
	
	Cell = ligneSsTot.insertCell(0);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.setAttribute('colspan','6');

	Cell = ligneSsTot.insertCell(1);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	Cell.innerHTML ="<div id=\"totalNew" + newIdGrp + "\">0,00</div>";

	Cell = ligneSsTot.insertCell(2);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';

	// Ajout d'une ligne vide
	ajoutLigne("New" + newIdGrp);
	
}

function ajoutLigne(idGrp)
{
	var newIdHtml = findNewIdHtml(idGrp);
	var indexRow = -1;
	
	if (idGrp != "0") {
		var totalGrp = document.getElementById("total" + idGrp);
		indexRow = totalGrp.parentNode.parentNode.rowIndex - 1;
	}
	
	var tableau = document.getElementById('tableArticle');
	var ligne = tableau.insertRow(indexRow);
  
	var Cell;
	Cell = ligne.insertCell(0);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<textarea name=\"designation" + newIdHtml + "\" id=\"designation" + newIdHtml + "\" cols=\"70\"></textarea><input type=\"hidden\" name=\"idLine" + newIdHtml + "\" id=\"idLine" + newIdHtml + "\" value=\"" + newIdHtml + "\"/>";

	Cell = ligne.insertCell(1);
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<div align=\"center\"><a href=\"#\" onclick=\"window.open('catalogue_liste_pop.php?pop=" + newIdHtml + "','','scrollbars=yes,resizable=yes,width=825,height=600')\" ><img src=images/icones/panier-ajouter-icone-7116-32.png width=32 height=32 /></a></div>";

	Cell = ligne.insertCell(2);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<div align=\"left\"><input id=\"quant" + newIdHtml + "\" name=\"quant" + newIdHtml + "\" size=\"5\" alt=\"quantite\" value=\"1,00\" onchange=\"calcul('q','" + newIdHtml + "')\"/><input id=\"Hquant" + newIdHtml + "\" name=\"Hquant" + newIdHtml + "\" type=\"hidden\" value=\"1\"/></div>";

	Cell = ligne.insertCell(3);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	Cell.innerHTML = "<div align=\"left\"><select name=\"unite" + newIdHtml + "\" id=\"unite" + newIdHtml + "\"><option>Pièce</option><option>m²</option><option>heure</option><option>jour</option><option>ml</option><option>forfait</option><option>m3</option></select></div>";

	Cell = ligne.insertCell(4);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	Cell.innerHTML ="<div align=\"left\"><input id=\"prix" + newIdHtml + "\" name=\"prix" + newIdHtml + "\" size=\"10\" alt=\"montant\" value=\"0,00\" onchange=\"calcul('p','" + newIdHtml + "')\"/><input id=\"Hprix" + newIdHtml + "\" name=\"Hprix" + newIdHtml + "\" type=\"hidden\" value=\"0.0\"/></div>";

	Cell = ligne.insertCell(5);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	Cell.innerHTML ="<div align=\"left\"><select name=\"tauxtva" + newIdHtml + "\" id=\"tauxtva" + newIdHtml + "\" onchange=\"calcul('0','" + newIdHtml + "')\";>" + tvaOptionSelect + "</select><input id=\"Htauxtva" + newIdHtml + "\" name=\"Htauxtva" + newIdHtml + "\" type=\"hidden\" value=\"\"/></div>";

	Cell = ligne.insertCell(6);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	Cell.innerHTML ="<div id=\"total" + newIdHtml + "\" name=\"total" + newIdHtml + "\"></div>";

	Cell = ligne.insertCell(7);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.style.textAlign='right';
	var bouton = document.createElement("input");
	bouton.type = "button";
	bouton.title = "Supprimer cette ligne";
	bouton.setAttribute ("style","border: none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor: pointer; vertical-align: middle;");
	bouton.onclick = function(){suppressionLigne(newIdHtml);};
	Cell.appendChild(bouton);

}

function findNewIdHtml(idGrp)
{
	var prefixIdLine = "New";
	if (idGrp != "0") {
		prefixIdLine = "idLine" + idGrp + "_" + prefixIdLine;
	}
		
	var newIdLig = 0;
	while (document.getElementById(prefixIdLine + newIdLig) != undefined) {
		newIdLig += 1;
	}
	
	var newIdHtml = "New" + newIdLig;
	if (idGrp != "0") {
		newIdHtml = idGrp + "_" + newIdHtml;
	}
	return newIdHtml;
}
