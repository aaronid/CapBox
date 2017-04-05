<!--
function remplis(nume,nom,prenom,fonction,initiales,mmail,INTITULE,INTER){
	document.getElementById("nom"+nume).value=nom;
	document.getElementById("prenom"+nume).value=prenom;
	document.getElementById("fonction"+nume).value=fonction;
	document.getElementById("initiales"+nume).value=initiales;
	document.getElementById("mmail"+nume).value=mmail;
	document.getElementById("INTITULE"+nume).value=INTITULE;
	document.getElementById("INTER"+nume).value=INTER;
}
function vide(nume){
	document.getElementById("INTER_").value=document.getElementById("INTER_").value+'-'+document.getElementById("INTER"+nume).value;	
}

function suppression(ligne){
	document.getElementById('tableArticle').deleteRow(ligne.rowIndex);
}

var compteur='1';
function ajoutLigne(nem){ 
	if(Math.abs(nem)>0){
		compteur=nem;
	}

	var Cell;
	// var nom = document.forms["formulaire"].nom.value;
	// var prenom = document.forms["formulaire"].prenom.value;
	var tableau = document.getElementById('tableArticle');
	var ligne = tableau.insertRow(-1); 
	
	Cell = ligne.insertCell(0);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<span style=\"font-weight: bold; color: #545454\">Prenom / Nom</span>";
	 
	Cell = ligne.insertCell(1);
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#F9F9F9';
	// Cell.class='Style1';
	Cell.innerHTML = "<select title=\"Sélectionner une civilité en déroulant cette liste.\" name=\"INTITULE"+compteur+"\" id=\"INTITULE"+compteur+"\"><option selected=\"selected\" value=\"1\">M.</option><option value=\"2\" >Mme</option><option value=\"3\" >Melle</option><option value=\"4\">M. et Mme</option></select><input name=\"prenom"+compteur+"\" type=\"text\" id=\"prenom"+compteur+"\" value=\"\" size=\"15\" />  <input name=\"nom"+compteur+"\" type=\"text\" id=\"nom"+compteur+"\" value=\"\" size=\"20\" />";
	  
	Cell = ligne.insertCell(2);
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<span style=\"font-weight: bold; color: #545454\">Fonction</span>";
	  
	Cell = ligne.insertCell(3); 
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#F9F9F9';
	Cell.innerHTML = "<input name=\"fonction"+compteur+"\" type=\"text\" id=\"fonction"+compteur+"\" value=\"\" size=\"20\" />";
	
	Cell = ligne.insertCell(4); 
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#EAF0F7';
	Cell.innerHTML = "<span style=\"font-weight: bold; color: #545454\">Mail</span>";
	
	Cell = ligne.insertCell(5); 
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#F9F9F9';
	Cell.innerHTML = "<input name=\"mmail"+compteur+"\" type=\"text\" id=\"mmail"+compteur+"\" value=\"\" size=\"15\" />";
	
	Cell = ligne.insertCell(6); 
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#F9F9F9';
	Cell.innerHTML = "<span style=\"font-weight: bold; color: #545454\">Initiales </span><input name=\"initiales"+compteur+"\" type=\"text\" id=\"initiales"+compteur+"\" value=\"\" size=\"2\" /><input type=\"hidden\" id=\"INTER"+compteur+"\" name=\"INTER"+compteur+"\"/><input type=\"hidden\" id=\"INTER_"+compteur+"\" name=\"INTER_"+compteur+"\"/>";
				  
	Cell = ligne.insertCell(7); 
	Cell.style.borderColor='#84F0FF';
	Cell.style.backgroundColor='#F9F9F9';
	Cell.style.textAlign='left';
	var bouton = document.createElement("input");
	bouton.type = "button";
	bouton.title = "Supprimer"+compteur+"";
	bouton.setAttribute ("style","border: none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor: pointer; vertical-align: middle;");
	// bouton.onclick = function(){};
	var compteur2= compteur;
	bouton.onclick = function(){vide(compteur2);suppression(ligne);};
	Cell.appendChild(bouton);  
	compteur++
	document.getElementById("d_hid").value=parseFloat(compteur);

}
