<?php

require("business/societeContact.php");

$societeContact = new SocieteContact();
$login = "FERGWE337";
$societeContact->findByLogin($login);

echo($societeContact->societe->nom);


