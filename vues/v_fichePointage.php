<div id="contenu">
		<div id="resultat">
			<?php if (!isset($_SESSION["date"])) {?>
			<input type="text" name="ladate" size="8" maxlength="8" id="ladate" >
			<input type="button" class="button" value="Dater" style="width:200px;height:40px;" onclick="createSDate(getElementById('ladate').value);">
			<?php }else{	$aDay=$_SESSION['date'];	?>
				<input type="text" name="ladate" size="8" value="<?php echo "$aDay"; ?>" maxlength="8" id="ladate">
			<input type="button" class="button" value="Dater" style="width:200px;height:40px;" onclick="createSDate(getElementById('ladate').value);">
		<?php	}?>
	</div>
	<div id="dater">
	</div>
</br>
<!													AFFICHAGE initiale								>
<?php //Si la variable de session chantier est crée
 	if (!isset($_SESSION["chantier"])) {?>
		<!Afficher liste chantier>	
			Chantier: 
			<select id="lieu" name="lieu" onchange="showSearchOuvrier();" onclick="if(getElementById('ladate').value==''){alert('Dater dabord la fiche de pointage');};">
				<option value="#"  selected>Selectionner un chantier</option>
				<?php //Pour chaque chantier
    				foreach ($lesChantiers as $unChantier) {
    					//L'identifiant du chantier
       					$idChantier=$unChantier["id"];
       					//Le libelle du chantier
        				$libChantier=$unChantier["libelle"];
       					echo "<option value=$idChantier>$libChantier</option>";
    				}?>
			</select>
<?php 	}//sinon
		else{?>
                        		<!Afficher liste chantier>	
			Chantier: 
			<select id="lieu" name="lieu">
				<option value="#"  selected>Selectionner un chantier</option>
				<?php //Pour chaque chantier
    				foreach ($lesChantiers as $unChantier) {
    					//L'identifiant du chantier
       					$idChantier=$unChantier["id"];
       					//Le libelle du chantier
        				$libChantier=$unChantier["libelle"];
       					echo "<option value=$idChantier>$libChantier</option>";
    				}?>
			</select>
		<!Afficher input recherche chantier>
         <center> <h1><u>SAISIR UN SALARIÉ</u></h1>
 		<label for="listYear" accesskey="n">Salarié : </label>
 		<input id="text" type="text" class="search" name="search" 
			  onkeyup="searchOuvrier(document.getElementById('text').value);" 
			onblur="alert('VOUS POUVEZ SAISIR :\n\n Un nom\n Un prénom\n Des initiales .*** Faite défiler la liste pour lire le reste \n\nIMPORTANT !\n Les heures que vous allez bientôt saisir doivent être au format suivant:\n 1530 pour l`heure 15h30\nPour ne plus revoir ce message à la prochaine saisie ,appuyer dans la case pendant 1 seconde')"
  			autocomplete="off"/>
  			<input type="button" class="button" onclick="addOdaSal();" value="Autre salarié">
<?php }?>
<!-																											>
	<div id="chantier"></div>
	<form id="res" action="index.php?uc=pointages&action=createFiche" method="POST">  
	</form></center>
	<!Bouton pour recuperer les pointages d'hier>
	<!<input type="button" onclick="backPointage();" value="Réucpérer pointages d'hier">
<?php
//La variable de session chantier est crée
if(isset($_SESSION["chantier"])){
	//Recupere le numero de la fiche de pointage d'aujourdhui
	$getIdFiche = $pdo->getIdFicheByDC($_SESSION["date"],$_SESSION["chantier"],$_SESSION["idVisiteur"]);?>
<?php
	//Si  aucune fiche n'est crée
	if (!empty($getIdFiche)){
/**
															LES POINTAGES SALARIÉES AUJOURDHUI
*///Si La variable de session chantier est crée
	if (isset($_SESSION["chantier"])) {
	//$i est égal à zéro
	$i=0;
	//SI Il y a des pointages salariée aujourdhui
if (!empty($lesPointagesSalToday)) {?>
<!Tableau de pointages salariées>
	<table>
		<caption><b>Les Pointages main d’œuvre d'aujourd'hui</b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>OUVRIER</center></th>
		<th><center>CHANTIER</center></th>  	
		<th><center>AVANT PAUSE</center></th>  
		<th><center>APRÈS PAUSE</center></th>
		<th><center>TOTAL JOUR</center></th>
		<th><center>TOTAL NUIT</center></th>
		<th><center>ACTION</center></th>
	</tr> 
<?php //Pour chaque pointage salariée auourdhui
	foreach ($lesPointagesSalToday as $unPointage) {
		//Identifiant de la fiche pointage
		$id = $unPointage ["id"];
		//Date de la fiche
		$date = $unPointage ["jour"];
		//Elements du pointage de début de service 1ere partie de la journée
		$debutBrutOne = $unPointage["dt_debutOne"];
		//La date
		$laDate = $debutBrutOne;
		//Heure de debut en entier
		$theDateDebutOne = substr($laDate, 0,10);
		//heure de debut
		$hDebutOne = substr($laDate, 11,2);
		//minute de début
		$mDebutOne = substr($laDate, 14,2);
		//Date debut pointage premier partie journée à afficher 
		$debutOne = $theDateDebutOne." ".$hDebutOne.":".$mDebutOne;
		//Date et heure de fin de premier parti de journée
		$finBrutOne = $unPointage ["dt_finOne"];
		//Date de fin de premier parti de journée
		$theDateFinOne = substr($finBrutOne, 0,11);
		//heure
		$hFinOne = substr($finBrutOne, 11,2);
		//minute
		$mFinOne = substr($finBrutOne, 14,2);
		//Date fin pointage premier partie journée à afficher 
		$finOne = $theDateFinOne.$hFinOne.":".$mFinOne;
		//2eme partie de la journée
		//Date et heure debut 2eme partie journé
		$debutBrut = $unPointage ["dt_debut"];
		//Date 
		$theDateDebut = substr($debutBrut, 0,11);
		//heure
		$hDebut = substr($debutBrut, 11,2);
		//Minutes
		$mDebut = substr($debutBrut, 14,2);
		//Date debut pointage premier partie journée à afficher 
		$debut = $theDateDebut.$hDebut.":".$mDebut;
		//Elements du pointage de fin de service 
		$finBrut = $unPointage ["dt_fin"];
		//Date
		$theDateFin = substr($finBrut, 0,11);
		//heure
		$hFin = substr($finBrut, 11,2);
		//Minutes
		$mFin = substr($finBrut, 14,2);
		//Date debut pointage premier partie journée à afficher 
		$fin = $theDateFin.$hFin.":".$mFin;
		//Elements du pointage identité ect.. 
		$nomSal = $unPointage ["nom"];
		//Prenom du salarié
		$prenomSal = $unPointage ["prenom"];
		//Nom aà afficher
		$nom = $nomSal.' '.$prenomSal;
		//Chantier à afficher
		$chantier = $unPointage["numero"].$unPointage["chantier"];
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
   		//var_dump($StartTallerEnd);var_dump($startEndTFinal);var_dump($BeginHStartTallerHEnd);
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
				//var_dump($total);
			}			
   		}
    	if ($StartTallerEnd == true && $theDateDebut!="0000-00-00" && $theDateFin =="0000-00-00") {
   			$jourDebut = substr($theDateDebutOne,8,2); 
			$jourFin = substr($theDateDebut,8,2);
			$temp = dayOrNight($jourFin,$jourDebut);
			//var_dump($temp);
			if ($temp == "Jour") {
				$total = totalJour($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				//var_dump($total);
			}else{
				$total = totalNuit($hDebutOne,$hDebut,$mDebutOne,$mDebut)-pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
				//var_dump($total);
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
				//var_dump($total);
			}else{
				$total = totalNuitHalf($hDebutOne,$mDebutOne,$hFinOne,$mFinOne);
				$pause = 0;
				//var_dump($total);
			}
			//var_dump($temp);
   		}
   		if ($BeginHStartTallerHEnd == true && $StartTallerEnd == false && $startEndTFinal == true) {
   			$jourDebut = substr($theDateDebut,8,2); 
			$jourFin = substr($theDateFin,8,2);
   			$temp = dayOrNight($jourDebut,$jourFin);
   			//var_dump($temp);
   			if ($temp == "Jour") {
				$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
				$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				//var_dump($total);
			}else{
				$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
				$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
			//var_dump($total);
			}
			//var_dump($temp);
   		}//var_dump($startEndTFinal);var_dump($StartTallerEnd);var_dump($BeginHStartTallerHEnd);
   		if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == false) {
	   		$jourDebut = substr($theDateDebutOne,8,2); 
			$jourFin = substr($theDateFinOne,8,2);
   			$temp = dayOrNight($jourFin,$jourDebut);
   			//var_dump($temp);
   			if ($temp == "Jour") {
				$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
				$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
			//var_dump($total);
			}else{
				$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
				$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
			}
   		}
   		if ($BeginHStartTallerHEnd == false && $StartTallerEnd == false && $startEndTFinal == true) {
   			$jourDebut = substr($theDateDebutOne,8,2);
			$jourFin = substr($theDateFin,8,2);
   			$temp = dayOrNight($jourFin,$jourDebut);
   			//var_dump($temp);
   			if ($temp == "Jour") {
				$total = totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin);
				$pause = pauseJour($hFinOne,$hDebut,$mFinOne,$mDebut);
				//var_dump($total);
			}else{
				$total = totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin);
				$pause = pauseNuit($hFinOne,$hDebut,$mFinOne,$mDebut);
			}
   		}
   		if($hDebutOne>="22"|| $hFinOne>="22" || $hDebut>="22" || $hFin>="22"){
   			$temp="Nuit";	
   		}
   		if($hDebutOne<="06"|| $hFinOne<="06" || $hDebut<="06" || $hFin<="06"){
   			$temp="Nuit";	
   		}
   		$dayOrNight=$temp;?>
		<form action="#" method="POST">
		<td><input type="text" id="nom<?php echo $i?>" size="13" value="<?php echo $nom?>"></td>
		<td><input type="text" id="chantier<?php echo $i?>" size="13" value="<?php echo $chantier?>"></td>
		<td><input type="text" id="debutOne<?php echo $i?>" size="16" name="debutOne" value="<?php echo $debutOne;?>" required/><input type="text" id="finOne<?php echo $i?>" size="16" name="finOne" value="<?php echo $finOne; ?>" required/></td>
		<td><input type="text" id="debut<?php echo $i?>" size="16" name="debut" value="<?php echo $debut ?>" required/><input type="text" id="fin<?php echo $i?>" size="16" name="fin" value="<?php echo $fin; ?>" required/></td>
		<td><?php if($dayOrNight == "Jour"){echo "$total";}else{echo"";}?></td>
		<td><?php if($dayOrNight == "Nuit"){echo "$total";}else{echo"";}?></td>
		<td><input  class="button" type="button" name="modifier" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>" onclick="alterPointage(<?php echo $i?>)"><a/><input  class="button" type="button" name="supprimer" value="supprimer" onclick="delPointage(<?php echo $i?>);"></td>
	</tr></form>
<?php $i++;
	}//fin foreach
}//fin empty lespointages
else{
		echo "<div class='erreur'><center>Aucune salarié Pointé</center></div>";
}
}//fin isset chantier?>
</table><br><br><div id="resPointageEngin"></div><?php
 $getIdFiche = $pdo->getIdFicheByDC($_SESSION["date"],$_SESSION["chantier"],$_SESSION["idVisiteur"]);
if($getIdFiche){?>
<!                                        POINTAGE UN MATERIEL            >
<?php 
//Si La variable de session chantier est crée
	if (isset($_SESSION["chantier"])) {?>
         <center> <h1><u>CHOISIR UN LOUEUR </u></h1>
 	<select id="listCategorie" name="listCategorie" onchange="voirCategorie();">
			<option value="0"  selected>Selectionner un loueur</option>
<?php
	foreach ($lesCateg as $uneCateg) {
		$idCateg= $uneCateg["id"];
		$libCateg= $uneCateg["raison"];
		//var_dump($annee);
		echo "<option value='$idCateg'>$libCateg</option>";
	}?>
		</select>
<form id="resMateriel" action="index.php?uc=pointages&action=createFiche" method="POST">  
</form>
<?php }
}?>
<br>
<!-                                                     LES POINATES MATERIELS                                    >
<?php
$i=0;
if(isset($lesPointageEnginToday)){

if(!empty($lesPointageEnginToday)){?>
<table>
	<caption><b>Les Pointages Materiel d'aujourd'hui</b></caption>
	<tr>
    	<!--<th><center>Id</center></th>-->
		<th><center>ENGIN</center></th>     	
		<th><center>NUMERO</center></th>
		<th><center>DURÉE</center></th>  
		<th><center>ENTREPRISE</center></th>
		<th><center>ACTION</center></th>
	</tr> 
<?php
//Pour tous les pointages matériels
	foreach ($lesPointageEnginToday as $unPointage) {
		//Jour du pointage
		$jourEngin = $unPointage["jour"];
		//Nom du  matériel
		$nomEngin = $unPointage["nom"];
		//Numéroi du matériel
		$numEngin = $unPointage["numero"];
		//Numéro de chnatier
		$numChantier = $unPointage["numeroChantier"];
		//Chantier à afficher
		$entrepriseEngin = $unPointage["E"];
		//Durée du pointage matériel
		$indice = $unPointage["indice"];?>

		<form action="#" method="POST">
		<input type="hidden" id="jourEngin<?php echo $i?>" value="<?php echo $jourEngin?>">
		<input type="hidden" id="numChantierEngin<?php echo $i?>" value="<?php echo $numChantier?>">
		<td><input type="text" id="nomEngin<?php echo $i?>" value="<?php echo $nomEngin?>"></td>
		<td><input type="text" id="numEngin<?php echo $i?>" size="4" maxlenght="4" name="numEngin" value="<?php echo $numEngin;?>" required/></td>
		<td><input type="text" id="indice<?php echo $i?>" size="4" name="indice"  maxlenght="3" value="<?php echo $indice?>" required/></td>
		<td><input type="text" id="chantierEngin<?php echo $i?>" size="25" name="chantierEngin" value="<?php echo $entrepriseEngin?>" required/></td>
		<td><input type="button"  class="button" name="modifier" value="modifier" alt="modifier <?php echo $nom?>" title="modifier <?php echo $nom?>" onclick="alterPointageEngin(<?php echo $i?>)"><a/><input type="button"  class="button" name="supprimer" value="supprimer" onclick="delPointageEngin(<?php echo $i?>);"></td>
	</tr>
		</form>
<?php $i++;
	}//fin foreach
}//fin is empty
}else{
	echo "<div class='erreur'><center>Aucune matériel Pointé</center></div>";
}//fin isset?>
</table><br><?php
/**
																LES CONSIGNGES
*/
//Si La variable de session chantier est crée															
if (isset($_SESSION["chantier"])) {?>
<div id="resConsigne"></div>
<?php
$i=0;
//SI il y a des consigne pointé
if(isset($lesConsigneToday)){
	//Si le tableau associatif dede ocnsonsigne n'est pas vide
 if(!empty($lesConsigneToday)){?>
<table>
	<caption><b>Les consignes d'aujourd'hui</b></caption>
	<tr>
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
<?php
	//pour toutes les consignes
	foreach ($lesConsigneToday as $unConsigne) {
		//Identifiant de la fiche
		$idConsigne = $unConsigne["idFiche"];
		//jour du pointage
		$jourConsigne = $unConsigne["jour"];
		//Libelle de la voie
		$voie = $unConsigne["num_voie"];
		//Heure debut consigne
		$aitcDebut = $unConsigne["aitc1"];
		//heure fin consigne
		$aitcFin = $unConsigne["aitc2"];
		//Heure debut catanaire
		$cCD = $unConsigne["c_catenaire_debut"];
		//heure fin caténaire
		$cCF = $unConsigne["c_catenaire_fin"];
		//Heure debut travaux
		$travauxD = $unConsigne["debutTravaux"];
		//Heure fin travauxs
		$travauxF = $unConsigne["finTravaux"];
        $dureeEffectiv = dureeEffective($aitcDebut,$aitcFin,$cCD,$cCF);
		?>
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
	}//fin forach
	?>
	</table><?php
  }//fin isse empty
  else{
  	//echo "<div class='erreur'><center>Aucune consigne Ajouté</center></div>";
  }
}
}//fin isset chantier?>
</table><br>	
<?php 
//Si La variable de session chantier est crée
if (isset($_SESSION["chantier"])) {?>
<div id="resultatUn"></div>
<button class='button' onclick="addConsigne();" style="width:500px;height:70px;">Voies</button>
<form id="resVoie" action="index.php?uc=pointages&action=createFiche" method="POST">  
</form>
<?php }?>
<div id="resultatDeux"></div>
<?php 
		//Si La variable de session chantier est crée
		if (isset($_SESSION["chantier"])) {?>
		<br><br>
		Travaux réaliser :<textarea id="travaux" name="travaux" onclick="alert('Séparez les differents travaux par deux points (:)\nEXEMPLE: Coupure voie1:Coupure voie2\nPour ne plus revoir ce message à la prochaine saisie ,appuyer dans la case pendant 1 seconde ');" onBlur="tAR(document.getElementById('travaux').value);"></textarea><br>
		Panne et arret :<textarea id="msg" name="msg" onclick="alert('Séparez les differents items par deux points (:)\nEXEMPLE: Panne de caténaire:Panne de merlo\nPour ne plus revoir ce message à la prochaine saisie ,appuyer dans la case pendant 1 seconde ');" onBlur="sendMail(document.getElementById('msg').value);"></textarea><br>
		Matériel à prévoir :<textarea id="matos" name="matos" onclick="alert('Séparez les differents items par un deux points (:)\nEXEMPLE: Autobetoniaire:Rail route\nPour ne plus revoir ce message à la prochaine saisie ,appuyer dans la case pendant 1 seconde ');" onBlur="mAP(document.getElementById('matos').value);"></textarea><br>
<br><br>
<!						METEO                                     >
<?php	//Si La variable de session chantier est crée
if (isset($_SESSION["chantier"])) {?>
	<div id="valider">
		<form action="index.php?uc=pointages&action=validerPointage" method="POST">
		<center><b><h1><u>MÉTÉO</u><h1></b></center>
		<h2><center>Il fait beaup... Vous pouvez passer cette étape</center></h2>
		<select id="listMeteo" name="listMeteo" onchange="createMeteo(this.value);" style="width:350px;">
			<option value="1" selected="selected">Choisir la météo du moment</option>
<?php 			foreach ($LesMeteo as $meteo) {
					//id de la meteo
					$id = $meteo["id"];
					//Libelle de la méteo
					$libelle = $meteo["libelle"];?>
					<option value="<?php echo $id?>"><?php echo "$libelle"?></option>
<?php 			}?>
		</select><br><br><br><br><br><br><br>
<?php 	//Verifie si la fiche est valider 
		$valider = $pdo->verifFicheValideBis($_SESSION["chantier"],$_SESSION["idVisiteur"],$_SESSION["date"],$_SESSION["numba"]);
		//Si la fiche n'est pas validé
		if($valider["signature"]=='') {?>
		<!Ajouter le bouton valider>
		<input type="submit" class="button" style="width:350px;height:100px;" value="VALIDER"></a></div>
<?php }?></form>
<?php
 	}?>
</div>
<?php }
}else{
}
}
?>
