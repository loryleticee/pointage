<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["id"])){
	$var = explode('.', $_POST['pointage']);
	$voie = $var[0];
	$date = $var[1];
	$aitcDebut = $var[2];
	$aitcFin = $var[3];
	$cCD = $var[4];
	$cCF = $var[5];
	$travauxD = $var[6];
	$travauxF = $var[7];
	$finD = $var[8];
	$debutF = $var[9];
	$finF = $var[10];
	$modifier = $pdo->alterConsigne($voie,$date,$_SESSION["idVisiteur"],$_SESSION["chantier"],$aitcDebut,$aitcFin,$cCD,$cCF,$travauxD,$travauxF); 
	if(!$modifier){
		echo "<div class='erreur'><center>$voie modifié avec succès</center></div>";
	}
	else{
		echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
	}
}
else{
	echo"Pas de post";
}
?>