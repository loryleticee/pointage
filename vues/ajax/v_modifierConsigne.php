<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if(isset($_POST["nomVoie"])){
	$var = explode('.', $_POST['nomVoie']);
	$name =$var[0];
	$date = $var[1];
	$aitcD = $var[2];
	$aitcF = $var[3];
	$cCD = $var[4];
	$cCF = $var[5];
	$travuxD = $var[6];
	$travuxF = $var[7];
	$modifier = $pdo->alterConsigne($name,$date,$_SESSION["idVisiteur"],$_SESSION["chantier"],$aitcD,$aitcF,$cCD,$cCF,$travuxD,$travuxF); 
	if(!$modifier){
		echo "<div class='erreur'><center>$name modifié avec succès</center></div>";
	}
	else{
		echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
	}
}
else{
	echo"Pas de post";
}
?>