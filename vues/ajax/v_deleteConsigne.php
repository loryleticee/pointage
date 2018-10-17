<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['nomVoie'])) {
	$idChantier = $_SESSION["chantier"];
	$var = explode('.', $_POST['nomVoie']);
	$name = addslashes($var[0]);
	$date = $var[1];
	$del = $pdo->delConsigne($date,$idChantier,$name);
	if ($del) {
	}else
	echo "<div class='erreur'><center>Voie supprimé avec succès<center></center></div>";
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>