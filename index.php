<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
session_start();
include("vues/v_entete.php") ;
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
$lesIpBani=$pdo->getLesBani(); 
$bani=false;
foreach ($lesIpBani as $anIp) {
	if ($_SERVER["REMOTE_ADDR"]==$anIp["adresse"]) {
		$bani=true;
	}
}
if ($bani!=true) {
	if(!isset($_REQUEST['uc'])){
		if ($estConnecte) {
			 $uc = 'pointages';
		}
		else{
    	 	$uc = 'connexion';
    	}
	}	 
	elseif($_REQUEST['uc'] != "connexion" && $_REQUEST['uc'] != "pointages" && $_REQUEST['uc'] != "admin"){
			if ($estConnecte) {
		 		$uc = 'pointages';
			}
			else{
				$uc = "connexion";
			}
	}
	else{
		if ($estConnecte) {
		 	$uc = $_REQUEST['uc'];
		}
		else{
			$uc = "connexion";
		}
	}
	if (isset($uc)) {
		switch($uc){
			case 'connexion':{
				include("controleurs/c_connexion.php");break;
			}
			case 'pointages' :{
				include("controleurs/c_pointages.php");break;
			}
      		case 'admin' :{
        		include("controleurs/c_administrer.php");break;
    		}
    	}
	}
	include("vues/v_pied.php") ;
}else{
	include("vues/v_out.php") ;
}
?>

