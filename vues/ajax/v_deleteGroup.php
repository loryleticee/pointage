<?php
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
//var_dump($_POST);
if(isset($_POST["id"])){
	$id = $_POST["id"];
	$delete=$pdo->supGroup($id);
	if($delete){
		echo "<div class ='erreur'>Supression echoué</center></div>"; 
	}
	else{
		echo "<div class ='erreur'>Supression reussit</center></div>"; 
	}
}
else{
	echo "<div class ='erreur'>Probleme de post</center></div>"; 
}
?>