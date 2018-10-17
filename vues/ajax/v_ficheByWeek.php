<?php
session_start();
require_once ("../../include/class.pdogsb.inc.php");
require_once ("../../include/fct.inc.php");
$pdo = PdoGsb::getPdoGsb();
			$getStat = $pdo->getStatut($_SESSION["idVisiteur"]);
			if (isset($_POST["idDay"]) && $_POST["idDay"]!=0) {
				if ($getStat["statut"] =='0' || $getStat["statut"] == '3' || $getStat["statut"] == '2') {
					$lesAnim = $pdo->getAllAnimator($_SESSION["chantier"],$_POST["idDay"]);
					$_SESSION["lejour"] = $_POST["idDay"];?>
			     		<center><h2>Sélectionner un chef de chantier</h2></center><center>
 					<label for="listCc" accesskey="n">Chef : </label>
					<select id="listCc" name="listCc" onchange="voirPointageDayBis(this.value);">
						<option value='0'>Sélectionner un chef de chantier</option>
<?php
						//Compteur en cas de gestion d'un liste de chef de chantier par un autre chef de chantier 
						$stt=0;
						foreach ($lesAnim as $aAnim) {
							//Ident du chef de chantier
							$id = $aAnim["id"];
							//Si l'utilisateur est un chef de chantier
							if ($getStat["statut"] == '2') {
								$prenom = 'Anonyme';
								$nom = $stt;
							}
							else{
								$prenom = $aAnim["prenom"];
								$nom = $aAnim["nom"];
							}
							//Affiche une option dans la liste
							echo "<option value='$id'>$nom $prenom</option>";
							$stt++;
						}?>
					</select>
<?php 			}
			}?>
<form id="res" action="index.php?uc=pointages&action=createFiche" method="POST">  
</form>
<?php
/**
														SI UNE SEMAINE EST CHOISIT 
*/$i=0;
if (isset($_POST["idWeek"]) && $_POST["idWeek"]!=0) {
/**
													POINTAGE SALARIE																				
*/
	$chantier = $_SESSION["chantier"];
	$week = $_POST["idWeek"]; 
	$lesPointagesSal = $pdo->getPointagesByWeek($week,$chantier,$_SESSION["idVisiteur"]);
	if (!empty($lesPointagesSal)) {?>
		<table>
	<caption><b><h1>Les Pointages  main d’œuvre du <?php echo $_SESSION["lejour"];?></h1></b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>OUVRIER</center></th>   	
		<th><center>AVANT PAUSE</center></th>  
		<th><center>APRÈS PAUSE</center></th>
		<th><center>DURÉE JOUR</center></th>
		<th><center>DURÉE NUIT</center></th>
		<?php if(isset($_POST["idDay"])){?>
			<th><center>ACTION</center></th>
<?php	}?>
		
	</tr> 
<?php		foreach ($lesPointagesSal as $unPointage) {
			$id = $unPointage ["id"];
			$date = $unPointage ["jour"];
			//Elements du pointage de début de service 1ere partie de la journée
			$debutBrutOne = $unPointage["dt_debutOne"];
			$laDate = $debutBrutOne;
			$theDateDebutOne = substr($laDate, 0,10);
			$hDebutOne = substr($laDate, 11,2);
			$mDebutOne = substr($laDate, 14,2);
			$debutOne = $theDateDebutOne." ".$hDebutOne.":".$mDebutOne;
			//Elements du pointage de fin de service 
			$finBrutOne = $unPointage ["dt_finOne"];
			$theDateFinOne = substr($finBrutOne, 0,11);
			$hFinOne = substr($finBrutOne, 11,2);
			$mFinOne = substr($finBrutOne, 14,2);
			$finOne = $theDateFinOne.$hFinOne.":".$mFinOne;
			//2eme partie de la journée
			$debutBrut = $unPointage ["dt_debut"];
			$theDateDebut = substr($debutBrut, 0,11);
			$hDebut = substr($debutBrut, 11,2);
			$mDebut = substr($debutBrut, 14,2);
			$debut = $theDateDebut.$hDebut.":".$mDebut;
			//Elements du pointage de fin de service 
			$finBrut = $unPointage ["dt_fin"];
			$theDateFin = substr($finBrut, 0,11);
			$hFin = substr($finBrut, 11,2);
			$mFin = substr($finBrut, 14,2);
			$fin = $theDateFin.$hFin.":".$mFin;
			//Elements du pointage identité ect.. 
			$nomSal = $unPointage ["nom"];
			$prenomSal = $unPointage ["prenom"];
			$nom = $nomSal.' '.$prenomSal;
   			//Retourne vri si l'heure de fin de la premier 
   			//partie de la journée est plus grande que le debut
   			// de la 2em partie de la journée/soirée
   			$StartTallerEnd = hDebutTallerhFin($hFinOne,$hDebut);
   			//Retourne vri si l'heure de fin de la deuxieme 
   			//partie de la journée est plus grande que le debut de la deuxieme partie
   			$startEndTFinal = hDebutTallerhFin($hDebut,$hFin);
   			//retourne vrai si lheure de debut de la premiere partie de la
   			// journée est plus grande que l'heure de fin de la premiere
   			// partie de la journée
   			$BeginHStartTallerHEnd = hDebutStartTallerhFin($hDebutOne,$hFinOne);
			//retourne vrai si lheure de debut de la deuxieme
			// partie de la journée est plus grande que l'heure de fin la deuxieme
			// partie de la journée
   			$EndHStartTallerHEnd = hDebutEndTallerhFin($hDebut,$hFin);
   			//var_dump($StartTallerEnd);var_dump($startEndTFinal);var_dump($BeginHStartTallerHEnd);var_dump($EndHStartTallerHEnd);
   			if ($StartTallerEnd == true && $theDateFin!="0000-00-00") {
   				$jourDebut = substr($theDateFinOne,8,2); 
				$jourFin = substr($theDateDebut,8,2);
				$temp = dayOrNight($jourFin,$jourDebut);
				if ($temp == "Jour"){
					$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
					$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				}else{
					$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
					$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
				}			
   			}
    		if ($StartTallerEnd == true && $theDateDebut!="0000-00-00" && $theDateFin =="0000-00-00") {
   				$jourDebut = substr($theDateDebutOne,8,2); 
				$jourFin = substr($theDateDebut,8,2);
				$temp = dayOrNight($jourFin,$jourDebut);
				if ($temp == "Jour") {
					$total = totalJour($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				}else{
					$total = totalNuit($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut,$theDateDebut,$theDateFin);
				}	
   			}
   			if ($BeginHStartTallerHEnd == true && $theDateFin =="0000-00-00" && $theDateDebut =="0000-00-00") {
   				//Recuperer le jour de debut et le jour de fin
				$jourDebut = substr($theDateDebutOne,8,2); 
				$jourFin = substr($theDateFinOne,8,2);
				$temp = dayOrNight($jourFin,$jourDebut);
				if ($temp == "Jour") {
					$total = totalJourHalf($hDebutOne,$hFinOne,$mDebutOne,$mFinOne);
					$pause = 0;
				}else{
					$total = totalNuitHalf($hDebutOne,$mDebutOne,$hFinOne,$mFinOne);
					$pause = 0;
				}
   			}
   			if ($BeginHStartTallerHEnd == true && $StartTallerEnd == false && $startEndTFinal == true) {
   				$jourDebut = substr($theDateDebut,8,2); 
				$jourFin = substr($theDateFin,8,2);
   				$temp = dayOrNight($jourDebut,$jourFin);
   			//var_dump($temp);
   				if ($temp == "Jour") {
					$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
					$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				}else{
					$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
					$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
				}
   			}
   	   		if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == false) {
   				$jourDebut = substr($theDateDebutOne,8,2); 
				$jourFin = substr($theDateFinOne,8,2);
   				$temp = dayOrNight($jourFin,$jourDebut);
   				if ($temp == "Jour") {
					$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
					$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				}else{
					$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
					$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
				}
   			}
   	 		if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == true && $EndHStartTallerHEnd == true) {
   				$jourDebut = substr($theDateDebutOne,8,2);
				$jourFin = substr($theDateFin,8,2);
   				$temp = dayOrNight($jourFin,$jourDebut);
   				if ($temp == "Jour") {
					$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
					$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				}else{
					$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
					$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
				}
   			}
   			$dayOrNight=$temp;
?>
			<form action="" method="POST">
			<td><input type="text" id="nom<?php echo $i?>" value="<?php echo $nom?>"></td>
			<td><input type="text" id="debutOne<?php echo $i?>" size="16" name="debutOne" value="<?php echo $debutOne; ?>" required/><input type="text" id="finOne<?php echo $i?>" size="20" name="finOne" value="<?php echo $finOne; ?>" required/></td>
			<td><input type="text" id="debut<?php echo $i?>" size="16" name="debut" value="<?php echo $debut; ?>" required/><input type="text" id="fin<?php echo $i?>" size="18" name="fin" value="<?php echo $fin; ?>" required/></td>
			<td><?php if($dayOrNight == "Jour"){echo "$total";}else{echo"";}?></td>
			<td><?php if($dayOrNight == "Nuit"){echo "$total";}else{echo"";}?></td>
	</tr>
			</form>
<?php
/**
													CALCUL DU CUMUL DES  POINTAGES																			
*/ 	
//Transforme les virgulke en point pour le total
			$preTotal=explode(',', $total);
			$concat=implode('.', $preTotal);
			if (!isset($_SESSION[$nom])) {
				//extract($_SESSION,EXTR_PREFIX_ALL,$nom);
				$_SESSION[$nom]=floatval($concat);
			}else{
				$_SESSION[$nom]+=floatval($concat);
			}
			$i++;
		}//foreach
		?>
</table>
		<?php

	}//fin empty
	else{
		echo "<div class='erreur'><center>Aucun pointage Salarié à ce jour<center></div>";
	}?>

<br>
<br>
<?php
/**
													POINTAGE MATERIEL																				
*/
$lesPointageEngin = $pdo->getLesPointagesEnginByWeek($_SESSION["chantier"],$week,$_SESSION["idVisiteur"]);
$i=0;
if(isset($lesPointageEngin)){?>
<table>
	<caption><b><h1>Les Pointages Materiel du <?php echo $_SESSION["lejour"];?></h1></b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>ENGIN</center></th>     	
		<th><center>NUMERO</center></th>
		<th><center>INDICE</center></th>  
		<th><center>CHANTIER</center></th>
	</tr> 
<?php	foreach ($lesPointageEngin as $unPointage) {
		$nomEngin = $unPointage["nom"];
		$numEngin = $unPointage["numero"];
		$chantierEngin = $unPointage["numeroChantier"].$unPointage["chantier"];
		$indice = $unPointage["indice"];?>

	<form action="#" method="POST">
	<td><input type="text" id="nomEngin<?php echo $i?>" value="<?php echo $nomEngin?>"size="14"></td>
	<td><input type="text" id="numEngin<?php echo $i?>" size="16" name="numEngin" value="<?php echo $numEngin;?>" required/></td>
	<td><input type="text" id="indice<?php echo $i?>" size="16" name="indice" value="<?php echo $indice?>" required/></td>
	<td><input type="text" id="chantierEngin<?php echo $i?>" size="24" name="chantierEngin" value="<?php echo $chantierEngin?>" required/></td>
</tr></form>
<?php $i++;}
}else{
	echo "<div class='erreur'><center>Aucun pointage matériel à cette semaine<center></div>";
}?>
</table>
<?php
	$lesConsigne = $pdo->getLesConsigneByWeek($_SESSION["chantier"],$week,$_SESSION["idVisiteur"]);
 	if(!empty($lesConsigne)){?>
	 <div id="resConsigne"></div>
	<table>
		<caption><b><h1>Les consignes d'aujourd'hui du <?php echo $_SESSION["lejour"];?></h1></b></caption>
		<tr>
    		<!--<th><center>Id</center></th>-->
			<th><center>NUMERO DE VOIE</center></th>     	
			<th><center>COUPURE VOIE AITC DEBUT</center></th>
			<th><center>COUPURE VOIE AITC FIN</center></th>  
			<th><center>HEURE CONSIGNATION CATÉNAIRE(9007)</center></th>
			<th><center>HEURE CONSIGNATION CATÉNAIRE(9007) FIN</center></th>  
			<th><center>HEURE  DEBUT TRAVAUX</center></th>
			<th><center>HEURE FIN TRAVAUX</center></th>
			<th><center>ACTION</center></th>
		</tr> 
<?php $i=0;
	foreach ($lesConsigne as $unConsigne) {
		$idConsigne = $unConsigne["idFiche"];
		$jourConsigne = $unConsigne["jour"];
		$voie = $unConsigne["num_voie"];
		$aitcDebut = $unConsigne["aitc1"];
		$aitcFin = $unConsigne["aitc2"];
		$cCD = $unConsigne["c_catenaire_debut"];
		$cCF = $unConsigne["c_catenaire_fin"];
		$travauxD = $unConsigne["debutTravaux"];
		$travauxF = $unConsigne["finTravaux"];?>
	<form action="#" method="POST">
	<input type="hidden" id="jourConsigne<?php echo $i?>" value="<?php echo $jourConsigne?>">
	<td><input type="text" id="voieConsigne<?php echo $i?>" name="voieConsigne" value="<?php echo $voie?>" size="6"></td>
	<td><input type="text" id="aitc1<?php echo $i?>" value="<?php echo $aitcDebut?>" size="8"></td>
	<td><input type="text" id="aitc2<?php echo $i?>" size="8" name="aitc2" value="<?php echo $aitcFin;?>" required/></td>
	<td><input type="text" id="cCD<?php echo $i?>" size="8" name="cCD" value="<?php echo $cCD?>" required/></td>
	<td><input type="text" id="cCF<?php echo $i?>" size="8" name="cCF" value="<?php echo $cCF?>" required/></td>
	<td><input type="text" id="travauxD<?php echo $i?>" size="8" name="travauxD" value="<?php echo $travauxD?>" required/></td>
	<td><input type="text" id="travauxF<?php echo $i?>" size="8" name="travauxF" value="<?php echo $travauxF?>" required/></td>
	<td><input type="button"  class="button" name="modifier" value="modifier" alt="modifier <?php echo $voie?>" title="modifier <?php echo $voie?>" onclick="alterConsigne(<?php echo $i?>)"><a/><input type="button"  class="button" name="supprimer" value="supprimer" onclick="delConsigne(<?php echo $i?>);"></td>
</tr></form>
<?php $i++;
	}?>
	</table><?php
  }else{
  	echo "<div class='erreur'><center>Aucune consigne Ajouté</center></div>";
  }
}else{
	echo "<div class='erreur'><center>Vous avez choisit un tri par jour<center></div>";
}
/**
														SI UN JOUR EST CHOISIT
*/
if (isset($_POST["idDay"]) && $_POST["idDay"]!=0 || isset($_POST["chef"]) || isset($_POST["numb"])) {
	if(isset($_POST["chef"])){
		$dateJour = $_SESSION["lejour"];
		//CHef de chantier
		$chef = $_POST["chef"];
		$_SESSION["chef"]=$chef ;
		//Utilisateur
		$user = $chef;
		$LesFiche = $pdo->getLesFiche($_SESSION["chantier"],$_SESSION["lejour"]);?>					
		<br>
		<center><h2>Sélectionner un numero de fiche</h2></center><center>
 		<label for="listN" accesskey="n">Numero : </label>
		<select id="listN" name="listN" onchange="voirPointageDayBisBis(this.value);">
			<option value='0'>Selectionner</option>
		<?php
		foreach ($LesFiche as $aFiche) {
			$num = $aFiche["numero"];
			echo "<option value='$num.$chef'>Fiche $num</option>";
		}?>
		</select>
		<?php	
	}
	else{
		if (isset($_SESSION["lejour"])) {
			$dateJour = $_SESSION["lejour"];
		}elseif(isset($_POST["idDay"])){
			$dateJour = $_POST["idDay"];
		}
		$user =$_SESSION["idVisiteur"];
	}
	if (isset($_POST["numb"])){
		$var=explode('.',$_POST["numb"]);
		$user=$var[1];
		$lnum=$var[0];
		$dateJour = $_SESSION["lejour"];
		$lesPointagesSal = $pdo->getPointagesByDayBis($_SESSION["chantier"],$dateJour,$user,$lnum);
	}
	else{
		$lesPointagesSal = $pdo->getPointagesByDay($_SESSION["chantier"],$dateJour,$user);
	}
	
	
/**
													POINTAGE SALARIE																				
*/
		if (!empty($lesPointagesSal)) {?>
		<table>
				<caption><b><h1>Les Pointages main d’œuvre du <?php echo $_SESSION["lejour"];?></h1></b></caption>
			<tr>
    		<!--<th><center>Id</center></th>-->
			<th><center>OUVRIER</center></th>   	
			<th><center>AVANT PAUSE</center></th>  
			<th><center>APRÈS PAUSE</center></th>
			<th><center>DURÉE JOUR</center></th>
			<th><center>DURÉE NUIT</center></th>
			<?php if(isset($_POST["idDay"])){?>
			<th><center>ACTION</center></th>
<?php		}?>
		
			</tr> 
<?php		foreach ($lesPointagesSal as $unPointage) {
				$id = $unPointage ["id"];
				$date = $unPointage ["jour"];
				//Elements du pointage de début de service 1ere partie de la journée
				$debutBrutOne = $unPointage["dt_debutOne"];
				$laDate = $debutBrutOne;
				$theDateDebutOne = substr($laDate, 0,10);
				$hDebutOne = substr($laDate, 11,2);
				$mDebutOne = substr($laDate, 14,2);
				$debutOne = $hDebutOne.":".$mDebutOne;

				//Elements du pointage de fin de service 
				$finBrutOne = $unPointage ["dt_finOne"];
				$theDateFinOne = substr($finBrutOne, 0,11);
				$hFinOne = substr($finBrutOne, 11,2);
				$mFinOne = substr($finBrutOne, 14,2);
				$finOne = $hFinOne.":".$mFinOne;
				//2eme partie de la journée
				$debutBrut = $unPointage ["dt_debut"];
				$theDateDebut = substr($debutBrut, 0,11);
				$hDebut = substr($debutBrut, 11,2);
				$mDebut = substr($debutBrut, 14,2);
				$debut = $hDebut.":".$mDebut;
				//Elements du pointage de fin de service 
				$finBrut = $unPointage ["dt_fin"];
				$theDateFin = substr($finBrut, 0,11);
				$hFin = substr($finBrut, 11,2);
				$mFin = substr($finBrut, 14,2);
				$fin = $hFin.":".$mFin;
				//Elements du pointage identité ect.. 
				$nomSal = $unPointage ["nom"];
				$prenomSal = $unPointage ["prenom"];
				$nom = $nomSal.' '.$prenomSal;
				$redacteur=$unPointage ["redacteur"];


   				//Retourne vri si l'heure de fin de la premier 
   				//partie de la journée est plus grande que le debut
   				// de la 2em partie de la journée/soirée
   				$StartTallerEnd = hDebutTallerhFin($hFinOne,$hDebut);
   				//Retourne vri si l'heure de fin de la deuxieme 
   				//partie de la journée est plus grande que le debut de la deuxieme partie
   				$startEndTFinal = hDebutTallerhFin($hDebut,$hFin);
   				//retourne vrai si lheure de debut de la premiere partie de la
   				// journée est plus grande que l'heure de fin de la premiere
   				// partie de la journée
   				$BeginHStartTallerHEnd = hDebutStartTallerhFin($hDebutOne,$hFinOne);
				//retourne vrai si lheure de debut de la deuxieme
				// partie de la journée est plus grande que l'heure de fin la deuxieme
				// partie de la journée
   				$EndHStartTallerHEnd = hDebutEndTallerhFin($hDebut,$hFin);
   				//var_dump($StartTallerEnd);var_dump($startEndTFinal);var_dump($BeginHStartTallerHEnd);var_dump($EndHStartTallerHEnd);
   				if ($StartTallerEnd == true && $theDateFin!="0000-00-00") {
   					$jourDebut = substr($theDateFinOne,8,2); 
					$jourFin = substr($theDateDebut,8,2);
					$temp = dayOrNight($jourFin,$jourDebut);
					//var_dump($temp);
					if ($temp == "Jour"){
						$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
						$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
					//var_dump($total);
					}else{
						$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
						$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
					}			
   				}
    			if ($StartTallerEnd == true && $theDateDebut!="0000-00-00" && $theDateFin =="0000-00-00") {
   					$jourDebut = substr($theDateDebutOne,8,2); 
					$jourFin = substr($theDateDebut,8,2);
					$temp = dayOrNight($jourFin,$jourDebut);
					//var_dump($temp);
					if ($temp == "Jour") {
						$total = totalJour($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
					}else{
						$total = totalNuit($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut,$theDateDebut,$theDateFin);
					}	
   				}
   				if ($BeginHStartTallerHEnd == true && $theDateFin =="0000-00-00" && $theDateDebut =="0000-00-00") {
   					//Recuperer le jour de debut et le jour de fin
					$jourDebut = substr($theDateDebutOne,8,2); 
					$jourFin = substr($theDateFinOne,8,2);
					$temp = dayOrNight($jourFin,$jourDebut);
					if ($temp == "Jour") {
						$total = totalJourHalf($hDebutOne,$hFinOne,$mDebutOne,$mFinOne);
						$pause = 0;
					}else{
						$total = totalNuitHalf($hDebutOne,$mDebutOne,$hFinOne,$mFinOne);
						$pause = 0;
					}
   				}
   				if ($BeginHStartTallerHEnd == true && $StartTallerEnd == false && $startEndTFinal == true) {
   					$jourDebut = substr($theDateDebut,8,2); 
					$jourFin = substr($theDateFin,8,2);
   					$temp = dayOrNight($jourDebut,$jourFin);
   					if ($temp == "Jour") {
						$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
						$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
					}else{
						$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
						$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
					}
   				}
   	   			if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == false) {
   					$jourDebut = substr($theDateDebutOne,8,2); 
					$jourFin = substr($theDateFinOne,8,2);
   					$temp = dayOrNight($jourFin,$jourDebut);
   					if ($temp == "Jour") {
						$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
						$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
					}else{
						$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
						$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
					}
   				}
   	 			if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == true && $EndHStartTallerHEnd == true) {
   					$jourDebut = substr($theDateDebutOne,8,2);
					$jourFin = substr($theDateFin,8,2);
   					$temp = dayOrNight($jourFin,$jourDebut);
   					if ($temp == "Jour") {
						$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
						$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
					}else{
						$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
						$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
					}
   				}
   				$dayOrNight=$temp;
   				?>
				<form action="" method="POST">
				<input type="hidden" id="chantier<?php echo $i?>" value="<?php echo $_SESSION['chantier']?>">
				<td><input type="text" id="nom<?php echo $i?>" value="<?php echo $nom?>" size="14"></td>
				<td><input type="text" id="debutOne<?php echo $i?>" size="10" name="debutOne" value="<?php echo $debutOne; ?>" required/><input type="text" id="finOne<?php echo $i?>" size="10" name="finOne" value="<?php echo $finOne; ?>" required/></td>
				<td><input type="text" id="debut<?php echo $i?>" size="10" name="debut" value="<?php echo $debut; ?>" required/><input type="text" id="fin<?php echo $i?>" size="10" name="fin" value="<?php echo $fin; ?>" required/></td>
				<td><?php if($dayOrNight == "Jour"){echo "$total";}else{echo"";}?></td>
				<td><?php if($dayOrNight == "Nuit"){echo "$total";}else{echo"";}?></td>
				<td><input type="button" class="button" name="modifier" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>" onclick="alterPointage(<?php echo $i?>)"><a/><input class="button" type="button" name="supprimer" value="supprimer" onclick="delPointage(<?php echo $i?>);"></td>
				</tr>
				</form>
				<?php $i++;
			}//fin foreach
/**
																PDF
*/
	if (isset($redacteur)) {
		if(isset($_POST["numb"])){
			$valider = $pdo->verifFicheValideBis($_SESSION['chantier'],$redacteur,$dateJour,$lnum);
		}else{
			$valider = $pdo->verifFicheValide($_SESSION['chantier'],$redacteur,$dateJour);
		}
		if ($_SESSION["statut"]=="Conducteur de travaux") {
			if($valider["signature"]!='') {
				if(isset($lnum)){?>
					<div id="pdf"><a href="index.php?uc=pointages&action=pdfPointage&day=<?php echo $dateJour;?>&chantier=<?php echo $_SESSION['chantier'];?>&id=<?php echo $user?>&num=<?php echo $lnum?>" title="PDF">TELECHARGER LE PDF</a></div>
		<?php	}
			}
			else{
				echo "Cette fiche n'est pas validée";?>
				<a href="index.php?uc=pointages&action=validerPointage&meteo=0"><input type="button" class="button" value="Valider Cette fiche"></a>
	<?php	}
		}
		else{
	 		echo "<div class='erreur'><center>Pour être imprimé cette fiche doit être validé<center></div>";
		}
	}
		}//fin empty
		else{
			echo "<div class='erreur'><center>Aucun pointage Salarié à ce jour<center></div>";
		}?>
		</table>
		<br><br>
<?php
/**
													POINTAGE MATERIEL																				
*/
if (isset($_POST["numb"])){
	$lnum=$_POST["numb"];
	$dateJour = $_SESSION["lejour"];
	$lesPointageEngin = $pdo->getLesPointagesEnginByDayBis($_SESSION["chantier"],$dateJour,$user,$lnum);
}
else{
	$lesPointageEngin = $pdo->getLesPointagesEnginByDay($_SESSION["chantier"],$dateJour,$user);
}													
$i=0;
if(isset($lesPointageEngin)){
	if(!empty($lesPointageEngin)){?>
<table>
	<caption><b><h1>Les Pointages Materiel du <?php echo $_SESSION["lejour"];?></h1></b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>ENGIN</center></th>     	
		<th><center>NUMERO</center></th>
		<th><center>INDICE</center></th>  
		<th><center>CHANTIER</center></th>
		<th><center>ACTION</center></th>
	</tr> 
<?php	foreach ($lesPointageEngin as $unPointage) {
		$nomEngin = $unPointage["libengin"];
		$numEngin = $unPointage["nengin"];
		$jour = $unPointage["jour"];
		$chantierEngin = $unPointage["numchant"].$unPointage["libchant"];
		$indice = $unPointage["indice"];?>

		<form action="#f" method="POST">
		<input type="hidden" id="jourEngin<?php echo $i?>" value="<?php echo $jour?>">
		<td><input type="text" id="nomEngin<?php echo $i?>" value="<?php echo $nomEngin?>" size="14"></td>
		<td><input type="text" id="numEngin<?php echo $i?>" size="4" name="numEngin" value="<?php echo $numEngin;?>" required="required"/></td>
		<td><input type="text" id="indice<?php echo $i?>" size="4" name="indice" value="<?php echo $indice?>" required/></td>
		<td><input type="text" id="chantierEngin<?php echo $i?>" size="18" name="chantierEngin" value="<?php echo $chantierEngin?>" required/></td>
		<td><input class="button" type="button" name="modifier" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>" onclick="alterPointageEngin(<?php echo $i?>)"><a/><input class="button" type="button" name="supprimer" value="supprimer" onclick="delPointageEngin(<?php echo $i?>);"></td>
</tr>
		</form>
<?php 
$i++;
		}//fin foreach
		?>
	</table><?php
}//fin empty
else{
	echo "<div class='erreur'><center>Aucun pointage matériel à ce jour</center></div>";
}?>
<!														LES CONSIGNES										>
<?php
if (isset($_POST["numb"])){
	$lnum=$_POST["numb"];
	$dateJour = $_SESSION["lejour"];
	$lesConsigne = $pdo->getLesConsigneByDayBis($_SESSION["chantier"],$dateJour,$user,$lnum);
	}else{
		$lesConsigne = $pdo->getLesConsigneByDay($_SESSION["chantier"],$dateJour,$user);
	}	
 if(!empty($lesConsigne)){?>
 <div id="resConsigne"></div>
<table>
	<caption><b><h1>Les consignes du <?php echo $_SESSION["lejour"];?></h1></b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>NUMERO DE VOIE</center></th>     	
		<th><center>COUPURE VOIE AITC DEBUT</center></th>
		<th><center>COUPURE VOIE AITC FIN</center></th>  
		<th><center>HEURE CONSIGNATION CATÉNAIRE(9007)</center></th>
		<th><center>HEURE CONSIGNATION CATÉNAIRE(9007) FIN</center></th>  
		<th><center>HEURE  DEBUT TRAVAUX</center></th>
		<th><center>HEURE FIN TRAVAUX</center></th>
		<th><center>DUREÉ EFFECTIVE</center></th>
		<th><center>ACTION</center></th>
	</tr> 
<?php $i=0;
	foreach ($lesConsigne as $unConsigne) {
		$idConsigne = $unConsigne["idFiche"];
		$jourConsigne = $unConsigne["jour"];
		$voie = $unConsigne["num_voie"];
		$aitcDebut = $unConsigne["aitc1"];
		$aitcFin = $unConsigne["aitc2"];
		$cCD = $unConsigne["c_catenaire_debut"];
		$cCF = $unConsigne["c_catenaire_fin"];
		$travauxD = $unConsigne["debutTravaux"];
		$travauxF = $unConsigne["finTravaux"];
		$dureeEffectiv = dureeEffective($aitcDebut,$aitcFin,$cCD,$cCF);?>
	<form action="#" method="POST">
	<input type="hidden" id="jourConsigne<?php echo $i?>" value="<?php echo $jourConsigne?>">
	<td><input type="text" id="voieConsigne<?php echo $i?>" name="voieConsigne" value="<?php echo $voie?>" size="6"></td>
	<td><input type="text" id="aitc1<?php echo $i?>" value="<?php echo $aitcDebut?>" size="8"></td>
	<td><input type="text" id="aitc2<?php echo $i?>" size="8" name="aitc2" value="<?php echo $aitcFin;?>" required/></td>
	<td><input type="text" id="cCD<?php echo $i?>" size="8" name="cCD" value="<?php echo $cCD?>" required/></td>
	<td><input type="text" id="cCF<?php echo $i?>" size="8" name="cCF" value="<?php echo $cCF?>" required/></td>
	<td><input type="text" id="travauxD<?php echo $i?>" size="8" name="travauxD" value="<?php echo $travauxD?>" required/></td>
	<td><input type="text" id="travauxF<?php echo $i?>" size="8" name="travauxF" value="<?php echo $travauxF?>" required/></td>
	<td><input type="text" id="dureeEff<?php echo $i?>" size="4" name="dureeEff" value="<?php echo $dureeEffectiv?>" required/></td>
	<td><input type="button"  class="button" name="modifier" value="modifier" alt="modifier <?php echo $voie?>" title="modifier <?php echo $voie?>" onclick="alterConsigne(<?php echo $i?>)"><a/><input type="button"  class="button" name="supprimer" value="supprimer" onclick="delConsigne(<?php echo $i?>);"></td>
</tr></form>
<?php $i++;
	}?>
	</table><?php
  }else{
  	echo "<div class='erreur'><center>Aucune consigne Ajouté</center></div>";
  }?>
<?php
}else{
	echo "<div class='erreur'><center>Vous avez choisit un tri par semaine<center></div>";
}
}else{echo "<div class='erreur'><center>Selectionner un autre jour ou selectionner une semaine<center></div>";}?>