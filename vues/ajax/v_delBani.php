<?php
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["adresse"])){
	$id = $_POST["adresse"];
	$delete=$pdo->delBani(addslashes($id));
	if($delete){
		echo "<div class ='erreur'><center>Supression echoué</center></div>"; 
	}
	else{
		echo "<div class ='erreur'><center>Supression reussit</center></div>"; 
		 
	}
}
else{
	echo "<div class ='erreur'><center>Probleme de post</center></div>"; 
}
?>