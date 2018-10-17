<?php session_start();
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if(isset($_POST["pointage"])){
	$var = explode('.', $_POST['pointage']);
	$name = $var[0];
	$num = $var[1];
	$date = $var[2];
	$indice = $var[3];
	if ($indice!="0.5" && $indice!="1." && $indice!="05" && $indice!="5" && $indice!="0") {
		echo "<div class='erreur'><center>Entrer un indice valable</center></div>";
	}
	else{
		if ($indice=="0.5") {
			$indice=0;
		}
		if($indice=="1."){
			$indice=1;
		}
		if($indice=="05"){
			$indice=0;
		}
		if($indice=="5"){
			$indice=0;
		}
		if($indice=="0"){
			$indice=0;
		}
		$getEngin = $pdo->getIdEngin($num,$name);
		$idEngin = $getEngin["id"];
		$modifier = $pdo->alterPointageEngin($name,$idEngin,$date,$_SESSION["chantier"],$indice,$num); 
	}

	if (isset($modifier)) {
		if(!$modifier){
			echo "<div class='erreur'><center>$name modifié avec succès</center></div>";
		}
		else{
			echo "<div class='erreur'><center>Contactez votre webmaster</center></div>";
		}
	}
}
else{
	echo"Pas de post";
}
?>