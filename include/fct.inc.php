﻿<?php
/** 
 * Fonctions pour l'application GSB
 
 * @package default
 * @author Cheri Bibi ,OSMAN Montasir ,LETICEE Lory
 * @version    1.0
 */
 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id,$nom,$prenom,$statut){
	$_SESSION['idVisiteur'] = $id; 
	$_SESSION['nom'] = $nom;
	$_SESSION['prenom'] = $prenom;
    $_SESSION['statut'] =$statut;
}
/**
 * Détruit la session active
 */
function deconnecter(){
	session_destroy();
}
function firstLetta($chaine){
		$one = strtoupper(substr($chaine,0,1));
		$word = $one.substr($chaine,1,strlen($chaine));
		return $word;
}

function yesterday($day){
				//Date de la veille
			$jour = substr($day,6,2);	
			$annee = substr($day,0,4);
			$mois = substr($day,4,2);
			//Si on est au premiers jour du mois
			if($jour == 01){
				//Le jour precedent est au mois precedent
				$mois += -1;
				//Si le mois precedent est paire
				$paire = paire($mois);
				if($paire == true){
					//Si le mois precedent est decembre, l'année est l'année précedente 
					if ($mois == 12) {
						$jour = 31;
						$annee += -1;
					}//Sinon si le mois precedent est févrié le derniers jour est un 28
					elseif ($mois == 2) {
						$jour = 28;
					}//Sinon le derniers jour est un 30
					else{
						$jour = 30;
					}
				}//Sinon le derniers jour est un 31
				else{
					$jour = 31;
				}
				//Si le mois est composé d'un chiffre
				if (strlen($mois)==1) {
					//Rajouter un zéro devant le mois
					$mois='0'.$mois;
				}
				return $yesterday = $annee.$mois.$jour;
			}
			else{
				//Si le mois est composé d'un chiffre
				if (strlen($mois)==1) {
					//Rajouter un zéro devant le mois
					$mois='0'.$mois;
				}
				return $yesterday = $annee.$mois.$jour-1;
			}
}
function hIC($a,$b,$c,$d){
	$x=true;
	if ($a==true ||$b==true ||$c==true ||$d==true) {
		$x=false;
	}
	return $x;
}
function hourIsCorruptVoie($heure){
	$x=false;
	if (substr($heure,0,2) <"00" || substr($heure,0,2) >"23") {
		$x=true;
	}
	if (substr($heure,3,2) <"00" || substr($heure,3,2) >"59") {
			$x=true;
	}
	return $x;
}
function hourIsCorrupt($heure){
	$x=false;
	if (substr($heure,8,2) <"00" || substr($heure,8,2) >"23") {
		$x=true;
	}
	if (substr($heure,10,2) <"00" || substr($heure,10,2) >"59") {
			$x=true;
	}
	return $x;
}

function hourNotEnabled($a,$b,$c,$d){
	$x=false;
	if($a=="0000"){
		if($b=="0000"){
			$x=true;
		}
	}
	if ($b=="0000") {
		$x=true;
	}
return $x;
}
function tomorrow($day){ 
	//Date de la veille	
	$annee = substr($day,0,4);
	$mois = substr($day,4,2);
	$jour = substr($day,6,2);
	$heure = substr($day,8,6);
	//Si on est un 31
	if($jour == 31){
		//Le jour suivrant est au mois suivant
		$mois += 1;
		$jour = 01;
 		if($mois == 13){
			$annee+=1;
			$mois = 01;
		}	
	}//Sinon si on est le 30 dans un mois paire,le jour suivant est le 01 et le mois suivant le mois suivant
	if($jour == 30 && paire($mois)== true){
		$jour = 01;
		$mois += 1;
	}
	if($mois==2){                                                   
		if($annee == 2016 || $annee == 2020 || $annee == 2024 || $annee == 2028){
			if($jour == 29){
  				$jour =01;
				$mois+=1;
			}
			if($jour == 28){
				$jour =29;
				$mois+=1;
			}
		}
		else{
			if($jour == 28){
				$jour = 01;
				$mois+=1;
			}
			else{
				if (substr($jour,0,1)=='0') {
					$d=$jour+1;
					$jour='0'.$d;
				}else{
					$jour=$jour+1;
				}
			}
		}
	}
	//Si on est un jour quelquonque dans le mois
	if($jour !=30 && $jour !=31 && $mois!=2){
		//Jour prend 1
		if (substr($jour,0,1)=='0') {
					$d=$jour+1;
					$jour='0'.$d;
				}else{
					$jour=$jour+1;
				}
	}
	return $annee.$mois.$jour.$heure;
}                      
function hDebutTallerhFin($hDebut,$hFin){
	$x=false;
	if($hDebut>$hFin){
		$x=true;
	}
return $x;
}
function hDebutStartTallerhFin($hDebut,$hFin){
	$x=false;
	if($hDebut>$hFin){
		$x=true;
	}
return $x;
}
function hDebutEndTallerhFin($hDebut,$hFin){
	$x=false;
	if($hDebut>$hFin){
		$x=true;
	}
return $x;
}

function isEmpty($hDebut,$hFin){
	$x = true;
	if (strlen($hDebut)>3 && strlen($hFin)>3) {
		$x = false;
	}
	return $x;
}
function fullEmpty($hDebut,$hFin){
	$x = false;
	if (strlen($hDebut)>11 && strlen($hFin)<12) {
		$x = true;
	}
	return $x;
}
function dayOrNight($debut,$fin){
	$x = "Jour";
	if ($debut>$fin) {
		$x = "Nuit";
	}
	return $x;
}
/**Pour un pointage entier de nuit ,retourne le total des heures travaillées
*
*/
function totalNuit($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin,$theDateDebut,$theDateFin){
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
               	$diffHourOne = $hFinOne-$hDebutOne;
		//var_dump($diffHourOne);
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinutOne = $mFinOne-$mDebutOne;
		//Si le nombre de minute de difference est negatif 
		if(($mFinOne-$mDebutOne) < 0){
			//Recupere l'heure -1heure
			$diffHourOne = $diffHourOne-1;
		}
		//::::FIN
			//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		//var_dump($hFin);var_dump($hDebut);
		if ($theDateDebut>$theDateFin) {
			$diffHour = 24-$hDebut+$hFin;
		}
		else{
			$diffHour = $hFin-$hDebut;
		}
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 		
		if(($mFin-$mDebut) < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		if (substr((abs($diffMinutOne)+abs($diffMinut))/60,2,2)!=0) {
			$virgule = ',';
		}
		else{
			$virgule ='';
		}

		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		$total = abs($diffHourOne+$diffHour).$virgule.substr((abs($diffMinutOne)+abs($diffMinut))/60,2,2);
		return $total;
}
function totalJour($hDebutOne,$hFinOne,$mDebutOne,$mFinOne,$hDebut,$hFin,$mDebut,$mFin){
		//var_dump($hDebutOne);
		//var_dump($hFinOne);
		//var_dump($mDebutOne);
		//var_dump($mFinOne);

		//var_dump($hDebut);
		//var_dump($hFin);
		//var_dump($mDebut);
		//var_dump($mFin);
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHourOne = $hFinOne-$hDebutOne;
		//var_dump($diffHourOne);
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinutOne = $mFinOne-$mDebutOne;
		//Si le nombre de minute de difference est negatif 
		if($diffMinutOne < 0){
			//Recupere l'heure -1heure
			$diffHourOne = $diffHourOne-1;
		}
		//::::FIN
			//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHour = $hFin-$hDebut;

		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 
		if($diffMinut < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		if (substr((abs($diffMinutOne)+abs($diffMinut))/60,2,2)!=0) {
			$virgule = ',';
		}
		else{
			$virgule ='';
		}
		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		//Les taux minutes sont arrondie au decimal le plus proche(zéro si egal à 5) EXEMPLE : 5,19.2=>5,19
		if (abs($diffMinutOne)+$diffMinut==60) {
			$total = abs($diffHourOne+$diffHour)+'1'.$virgule.substr((abs($diffMinutOne)+abs($diffMinut))/60,2,2);
		}
		else{
			$total = abs($diffHourOne+$diffHour).$virgule.substr((abs($diffMinutOne)+abs($diffMinut))/60,2,2);
		}
		return $total;
}

function totalJourHalf($hDebut,$hFin,$mDebut,$mFin){
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHour = $hFin-$hDebut;
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 
		if($diffMinut < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		$total = $diffHour.','.abs($diffMinut);
		//var_dump($total);
		return $total;
}
function totalNuitHalf($hDebut,$mDebut,$hFin,$mFin){
		//var_dump($hDebut);
		//var_dump($hFin);
		//var_dump($mDebut);
		//var_dump($mFin);
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHour = 24-$hDebut+$hFin;
		//var_dump($diffHour);
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 
		if($diffMinut < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		$total = $diffHour.','.abs($diffMinut);
		return $total;
}

function pauseJour($hDebut,$hFin,$mDebut,$mFin){
			//var_dump($hDebutOne);
		//var_dump($hFinOne);
		//var_dump($mDebutOne);
		//var_dump($mFinOne);

		//var_dump($hDebut);
		//var_dump($hFin);
		//var_dump($mDebut);
		//var_dump($mFin);
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHour = $hFin-$hDebut ;
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 
		if($diffMinut < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		$pause = $diffHour.','.abs($diffMinut);
		//var_dump($pause);
		return $pause;
}
function pauseNuit($hDebut,$hFin,$mDebut,$mFin){
		//var_dump($hDebut);
		//var_dump($hFin);
		//var_dump($mDebut);
		//var_dump($mFin);
		//Calcule la difference d'heure entre les heures de la premiere partie de la journée
		$diffHour = 24-$hDebut+$hFin ;
		//var_dump($diffHour);
		//Calcule la difference d'heure entre les minutes de la premiere partie de la journée
		$diffMinut = $mFin-$mDebut;
		//Si le nombre de minute de difference est negatif 
		if($diffMinut < 0){
			//Recupere l'heure -1heure
			$diffHour = $diffHour-1;
		}
		//Le $total d'heure pour la premiere partie de journée 
		//est égal à l'heure + la valeur absolue des minutes
		$pause = $diffHour.','.abs($diffMinut);
		//var_dump($pause);
		return $pause;
}
function dureeEffective($hAitcD,$hAitcF,$hCateD,$hCateF){
	//Heure de debut aitc
	$hHAitcD = substr($hAitcD,0,2);
	//minutes
	$mHAitcD = substr($hAitcD,2,2);

	//heure de fin aict
	$hHAitcF = substr($hAitcF,0,2);
	//minute
	$mHAitcF = substr($hAitcF,2,2);

	//heure de debut catenaire
	$hHCateD = substr($hCateD,0,2);
		//minute
	$mHCateD = substr($hCateD,2,2);

	//heure de fin caténaire
	$hHCateF = substr($hCateF,0 ,2);
		//minute
	$mHCateF = substr($hCateF, 2,2);

	//Si 'heure de debut de Aitc  est plus tardive que l'heure debut catenaire
	if ($hAitcD>$hCateD) {
		//Si l'heure de fin caténaire est plus tot que l'heure fin Aitc
		if ($hHCateF < $hHAitcF) {
			//L'heure fin catenaire - finAitc
			$heure = $hHCateF -  $hHAitcD;
			//Si on est à cheval sur deux jours
			if ($heure<0) {
				//L'heure est la difference du debut aitc - 24 + fin catnaire
				$heure = 24 - $hHAitcD+ $hHCateF;
			}
			//Minute Fin catenaire - minute debut Aitc
			$minute = $mHCateF - $mHAitcD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}else{
			//Heure fin aitc - heure debut aitc
			$heure = $hHAitcF -  $hHAitcD;
			//Si on est à cheval sur deux jours
			if ($heure<0) {
				$heure = 24 - $hHAitcD+ $hHAitcF;
			}
			//minutes  fin aitc - minute debut aitc 
			$minute = $mHAitcF - $mHAitcD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}
	}

	//Si lheure de debut catenaire est plus tardive que heure debut aitc
	else{
		//SI l'heure de d=fin catenaire est plus tot que heure fin aitc
		if ($hHCateF < $hHAitcF) {
			//L'heure est égal a l'heure début consignation
			$heure = $hHCateF -  $hHCateD;
			//Si on est à cheval sur deux jours
			if ($heure<0) {
				$heure = 24 - $hHCateD+ $hHCateF;
			}
			$minute = $mHCateF - $mHCateD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}

		}else{
			$heure = $hHAitcF -  $hHCateD;
			//Si on est à cheval sur deux jours
			if ($heure<0) {
				$heure = 24 - $hHCateD+ $hHAitcF;
			}
			$minute =  $mHAitcF- $mHCateD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}
	}
	return($heure.', '.substr($minute/60,2,2));
}
function dureeProductive($hTravD,$TravF){
	//Heure de debut aitc
	$hHAitcD = substr($hTravD,0,2);
	//minutes
	$mHAitcD = substr($hTravD,2,2);

	//heure de fin aict
	$hHAitcF = substr($TravF,0,2);
	//minute
	$mHAitcF = substr($hAitcF,2,2);

	//Si 'heure de debut de Aitc  est plus tardive que l'heure debut catenaire
	if ($hAitcD>$hCateD) {
		//Si l'heure de fin caténaire est plus tot que l'heure fin Aitc
		if ($hHCateF < $hHAitcF) {
			//L'heure fin catenaire - finAitc
			$heure = $hHCateF -  $hHAitcD;
			//Minute Fin catenaire - minute debut Aitc
			$minute = $mHCateF - $mHAitcD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}else{
			//Heure fin aitc - heure debut aitc
			$heure = $hHAitcF -  $hHAitcD;
			//minutes  fin aitc - minute debut aitc 
			$minute = $mHAitcF - $mHAitcD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}
	}

	//Si lheure de debut catenaire est plus tardive que heure debut aitc
	else{
		//SI l'heure de d=fin catenaire est plus tot que heure fin aitc
		if ($hHCateF < $hHAitcF) {
			//L'heure est égal a l'heure début consignation
			$heure = $hHCateF -  $hHCateD;
			$minute = $mHCateF - $mHCateD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}

		}else{
			$heure = $hHAitcF -  $hHCateD;
			$minute =  $mHAitcF- $mHCateD;
			if ($minute<0) {
				$heure -= 1;
				$minute = abs($minute);
			}
		}
	}
	return($heure.', '.substr($minute/60,2,2));

}

function passwordValid($mdp,$mdp1){
	$x= true;
	if($mdp!=$mdp1){
		$x=false;
	}
	return $x;
}

function verifForm($email){
	$x=false;
	$adresse = $email;
	$place = strrpos($adresse,"@",1);
	if($place>=0){
		$point = strrpos($adresse,'.',$place+1);
	}
	if($point>$place+1){
		$x=true;
	}
	return $x;
				/*
				var point = adresse.indexOf(".",place+1);
				if ((place > -1)&&(adresse.length >2)&&(point > 1)){
					formulaire.submit();
					return(true);
				}
				else{
					alert('Entrez une adresse e-mail valide');
					return(false);
				}*/
			}
/**
 * T
 
 * 
 * 
*/
function paire($mois){
	if ($mois&1)
    return false;
  else
    return true;
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 
 * @param $madate au format  jj/mm/aaaa
 * @return la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa 
 
 * @param $madate au format  aaaa-mm-jj
 * @return la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}
/**
 * retourne le mois au format aaaamm selon le jour dans le mois
 
 * @param $date au format  jj/mm/aaaa
 * @return le mois au format aaaamm
*/
function getMois($date){
   
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}
function getDay($date){
   
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $jour.$mois.$annee;
}
function getTime($date){
   
		@list($heure,$minute,$seconde) = explode('/',$date);
		
		return $heure.$minute.$seconde;
}


/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 
 * @param $dateTestee 
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa 
 
 * @param $date 
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}
function ok($n)
{
    $p=$n*2;
    return $p;
   
}
/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
 
 * @param $lesFrais 
 * @return vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant 
 
 * des message d'erreurs sont ajoutés au tableau des erreurs
 
 * @param $dateFrais 
 * @param $libelle 
 * @param $montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}
/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}
?>
