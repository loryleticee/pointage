 <?php
include("vues/v_sommaire.php");
if (!isset($_REQUEST['action'])) {
  $_REQUEST['action']="accueil";
}
if ($_REQUEST['action'] != "voirPointage" && $_REQUEST['action'] != "accueil" && $_REQUEST['action'] 
    != "pdfPointage" && $_REQUEST['action'] != "createFiche" 
    && $_REQUEST['action'] != "voirAllPointage" && $_REQUEST['action'] != "validerPointage") {
    $_REQUEST['action'] = "accueil";
}
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
if (isset($_SESSION["date"])) {
  if(substr($_SESSION["date"],0,4)=='-'){
    $var = explode('-',$_SESSION["date"]);
    $day = $var[0].$var[1].$var[2];
  }
  else{
    $day=$_SESSION["date"];
  }
}else{
  $day = date("Ymd");
  $_SESSION["date"]=$day;
}
if (!isset($_SESSION["numba"])) {
  $_SESSION["numba"]=0;
  $numba = $_SESSION["numba"];
}else{
  $numba=$_SESSION["numba"];
}
switch($action){
		case'voirPointage':{
			$yesterday = yesterday($day);
			$idVisiteur = $_SESSION['idVisiteur'] ;
		  $lesChantiers = $pdo->getLesChantiers();
    include("vues/pointages.php");
			break;
		}
    case 'pdfPointage' :{
      $day= $_REQUEST['day'];
      $chantier = $_REQUEST['chantier'];
      $visiteur = $_REQUEST['id'];
      $numero = $_REQUEST['num'];
      //Recupere les pointages salariés
      $lesPointages = $pdo->getPointagesByDayBis($chantier,$day,$visiteur,$numero);
      //Récupere les pointages matériaux
      $lesMateriauxAnsart = $pdo->getPointagesEnginAnsartBis($chantier,$day,$visiteur,$numero);
      //Recupere les pointages matériaux de location
      $lesMateriauxLoc = $pdo->getPointagesEnginLocBis($chantier,$day,$visiteur,$numero);
      //Recupere les travaux réalisées sur le chantier
      $travaux = $pdo->getTravaux($chantier,$day);
      //Recupêre les pannes signalées
      $pannes = $pdo->getPannes($chantier,$day);
      //Recupere les matériaux à prévoir
      $materiauxAP = $pdo->getMateriauxAP($chantier,$day,$visiteur);
      //Récupere le chantier
      $leChantier = $pdo->getLibChantier($chantier);
      //Recupere la météo de la fiche de pointage
      $laMeteo = $pdo->getMeteoPointage($chantier,$day);
      //Verifie si une fiche à été cloturé par un utilisateur autre que celui connecté
      $existOdaAnimator = $pdo->verifOdaAnimator($chantier,$day,$numero);
      //Si une autre personne à validé la fiche
      if($existOdaAnimator["id"]){
        //recupere les infos du redacteur
        $redacteur = $pdo->getOtherAnimateur($chantier,$day,$numero);
      }else{
         //recupere les infos du redacteur
        $redacteur = $pdo->getAnimateur($chantier,$day,$numero);        
      }
      //Récupere les consignes  pointé
      $lesConsignes = $pdo->getLesConsigne($chantier,$day,$numero);
      /*
      $tARealiser = $pdo->getLibChantier($numAsc);
      $panne= $pdo->getObservation($numAsc,$dateAsc);
      */
      include("vues/v_pdf_resa.php");     
      break;  
    }
		case'createFiche':{
      if (isset($_REQUEST["ini"])) {
        if ($_REQUEST["ini"]=="ok") {
          if (isset($_SESSION["chantier"])) {
            unset($_SESSION["chantier"]);
          }
        }
      }
			if(isset($_POST["nomOuv"]) && isset($_POST["prenomOuv"])
      && isset($_POST["DebutD"]) && isset($_POST["FinD"]) &&
      isset($_POST["DebutF"]) && isset($_POST["FinF"]) && $_POST["lieu"]!=0){
/**
                                              DECLARATION DES VARIABLES
        */
          $nom = $_POST["nomOuv"];
  				$prenom = $_POST["prenomOuv"];
          $heureDeFin = $_POST["FinF"]; 
/**

*/
          //Retourne faux si la premiere partie de la journée est remplit
          $StartPartOfDayIsEmpty = isEmpty($_POST["DebutD"],$_POST["FinD"]);
          //Retourne faux si la deuxieme partie de la journée est remplit
          $FinalPartOfDayIsEmpty = isEmpty($_POST["DebutF"],$_POST["FinF"]);

          if ( $StartPartOfDayIsEmpty == false) {
            if ($_POST["DebutD"]>"2359" || $_POST["DebutD"]<"0000") {
              $_POST["DebutD"]="0000";
            }
            $DebutD = $day.$_POST["DebutD"]."00";
            if ($_POST["FinD"]>"2359" || $_POST["FinD"]<"0000") {
              $_POST["FinD"]="0000";
            }
            $FinD = $day.$_POST["FinD"]."00";
          }
          else{
            $DebutD=$day."0000"."00";
            $FinD = $day."0000"."00";
          }
          if ($FinalPartOfDayIsEmpty == false) {
            if ($_POST["DebutF"]>"2359" || $_POST["DebutF"]<"0000") {
              $_POST["DebutF"]="0000";
            }
            $DebutF = $day.$_POST["DebutF"]."00";
            if ($_POST["FinF"]>"2359" || $_POST["FinF"]<"0000") {
              $_POST["FinF"]="0000";
            }
            $FinF = $day.$_POST["FinF"]."00";
          }else{
            $DebutF = $day."0000"."00";
            $FinF = $day."0000"."00";
          }
/**

*/
          $hDDC = hourIsCorrupt($DebutD);
          $hFDC = hourIsCorrupt($FinD);
          $hDFC = hourIsCorrupt($DebutF);
          $hFFC = hourIsCorrupt($FinF);
          if ($hDDC == true) {
            $DebutD ="00000000000000";
          }
          if ($hFDC == true) {
            $FinD ="00000000000000";
          }
          if ($hDFC == true) {
            $DebutF ="00000000000000";
          }
          if ($hFFC == true) {
            $FinF ="00000000000000";
          }
/**

          */
          $coment = $_POST["coment"];
          $idChantier = $_POST["lieu"];
          $_SESSION["chantier"]= $idChantier;
          //Renvoi vrai si les heures sont égal à zéro
          $hourAreZero = hourNotEnabled(substr($DebutD,8,4),substr($FinD,8,4),substr($DebutF,8,4),substr($FinF,8,4));
           //Si les heures de la premier partie de la journée sont égal à zéro
          $anyCorrupt = hIC($hDDC,$hFDC,$hDFC,$hFFC);
        if ($hourAreZero == false && $anyCorrupt == true) {
          //Retourne vrai si l'heure de début de la premiere partie de la
          // journée est plus tard que l'heure de fin de la premiere
          // partie de la journée
          $BeginHStartTallerHEnd = hDebutStartTallerhFin($DebutD,$FinD);
          //Retourne vri si l'heure de fin de la premier 
          //partie de la journée est plus tard que le debut
          // de la 2em partie de la journée/soirée
          $StartTallerEnd = hDebutTallerhFin($FinD,$DebutF);
          //Retourne vrai si l'heure de fin de la deuxieme 
          //partie de la journée est plus tard que le debut de la deuxieme partie
          $startEndTFinal = hDebutTallerhFin($DebutF,$FinF);
          //Retourne vraix si uniquement le devut de la deuxieme partie de la journée est rempli 
          $FinalMiddleFull = fullEmpty($DebutF,$FinF);
          //Identifiant de l'utilisateur connecté
          $idVisiteur = $_SESSION['idVisiteur'];
          //Recupere sous tableau associatif l'identifiant du personnel qui a été ponté
          $getIdUser = $pdo->getOuvrierById($nom,$prenom);
          //Si une entreprise est posté
          if (isset($_POST["group"])) {
            //Entreprise
            $ent = $_POST["group"];
            //Ajoute un interimaire
            $lastId = $pdo->getLastIdSal();
            //L'identifiant du nouveau salarie
            $idUser = $lastId["id"]+1;
            //le prenom premier lettre en majuscule
            $lePrenom = strtoupper(substr($prenom, 0,1)).substr($prenom, 1,strlen($prenom));
            //enregistre le salarie interimaire
            $pdo->addSalInterim($idUser,strtoupper($nom),$lePrenom,$ent);
          }else{
            //Identifiant du personnel
            $idUser = $getIdUser["id"];
          }
/**
                                    GESTION DES FICHES POINTAGES SEMAINES  (SI POINTAGE AUTORISÉ)
*/
          $verifDejaPointe = $pdo->pointeAllReadySal($day,$idUser,$idChantier,$DebutD,$numba);
          //Si le pointage n'a pas encore été fait
          if($verifDejaPointe == false){
            //Recupere le numéro de la semaine sous tableau associatif
            $getIdSemaine = $pdo->getIdSemaine($day);
            //le numéro de la semaine
            $idSemaine = $getIdSemaine["id"];
            //on verifie si une fiche de pointage pour le chantier et pour la semaine a été déja été crée
            $verifCreateFicheSemaine = $pdo->getFichePointageSemaine($idSemaine,$idChantier);
            //Si aucune fiche n'a été crée pour le chantier à la semaine par l'utilisataeur
            if($verifCreateFicheSemaine == false){
                $createNewFicheWeek = $pdo->newFicheWeek($idSemaine,$idChantier); 
            }
/**
                                            GESTION DES FICHE DE POINTAGES JOURNALIERS
*/                
            
            //on verifie si une fiche de pointage a déja été crée au jour $day pour l'utilisateur 
            $verifCreateF = $pdo->getFichePointage($idSemaine,$idChantier,$day,$idVisiteur,$numba);
            //Si une aucune fiche n'a été crée pour l'utilisateur au jour J
            if($verifCreateF == false){
                $createNewFiche = $pdo->newFiche($idSemaine,$idChantier,$day,$idVisiteur,$numba);
                $numba=0;
                $_SESSION["numba"] = $numba;
            }
            else{
              $numFich = $pdo->getNumabFiche($idSemaine,$idChantier,$day,$idVisiteur,$numba);
              if($numFich["signature"]!=''){
                $numba = $numFich["numero"]+1;
                $_SESSION["numba"] = $numba;
                $createNewFiche = $pdo->newFicheAgain($idSemaine,$idChantier,$day,$idVisiteur,$numba);
              }else{
                $numba =  $_SESSION["numba"];
              }
            }
/**
                                      GESTION DES POINTAGES ET COMPLETION DES CASES
*/
            //Si  le pointage est sur la premiere parti de la journée et que la deuxieme parti n'est pas rempli
            if ($StartPartOfDayIsEmpty == false && $FinalPartOfDayIsEmpty == true) {
              //Si dans les heures de débuts ,on a affaire a un pointage de nuit
              if($BeginHStartTallerHEnd == true){
                $FinD = tomorrow($FinD);
                $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,00000000000000,00000000000000,0,$idUser,$coment,$numba);
                //echo "<div class='erreur'>-C'est un pointage de nuit pour la premiere partie de la journée/</div>";
              }//Sinon c'est un pointage de jour
              else{
                if ($FinalMiddleFull == true) {
                  if($StartTallerEnd == true){
                    $DebutF = tomorrow($DebutF);
                  }
                }
               else{
                  $DebutF = 00000000000000;
               }
                $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,00000000000000,0,$idUser,$coment,$numba);
               // echo "<div class='erreur'>Cest un pointage de jour pour la premiere partie de la journée</div>";
              }
            }
            //Si la premiere partie de la journée est remplit et la seconde aussi              ////
            if($StartPartOfDayIsEmpty == false && $FinalPartOfDayIsEmpty == false){
              //Si dans les heures de débuts ,on a affaire a un pointage de nuit 
              if($BeginHStartTallerHEnd == true){
                //le date de fin de la premiere partie de la journée est au lendemain
                $FinD = tomorrow($FinD);
                //Si après la pause l'heure est égal a une heure plus tot que celle de la fin de premiere journée (déja passé au lendemain)
                //C'est qu'il y a erreur de saisie
                if($StartTallerEnd == true){
                  echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                }
                elseif($startEndTFinal == true){
                  echo"<div class='erreur'>veuillez entrer des heures cohérentese</div>";
                }
                else{
                  //Si la premiere partie de la journée est déja entre 2 jour et que la deuxieme partie de la journée est à la date du jour
                  if($BeginHStartTallerHEnd == true && $FinD>$DebutF){
                    echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                  }//Sinon pointer
                  else{
                    $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,$FinF,0,$idUser,$coment,$numba);
                  }
                }
              }
              elseif($StartTallerEnd == true){
                  //le date de fin de la premiere partie de la journée est au lendemain
                  $DebutF = tomorrow($DebutF);
                  $FinF = tomorrow($FinF);
                  if ($BeginHStartTallerHEnd == true) {
                    echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                  }
                  elseif ($startEndTFinal == true && $heureDeFin!='') {
                    echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                  }
                  else{
                    $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,$FinF,0,$idUser,$coment,$numba);
                  }             
              }
              elseif($startEndTFinal == true){
                //
                $FinF = tomorrow($FinF);
                if($BeginHStartTallerHEnd == true){
                  echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                }
                elseif ($StartTallerEnd == true) {
                  echo"<div class='erreur'>veuillez entrer des heures cohérentes</div>";
                }
                else{
                  $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,$FinF,0,$idUser,$coment,$numba);
                }
              }
              else{
                  $pointer = $pdo->pointerSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,$FinF,0,$idUser,$coment,$numba);       
              }
            }/*
            //Si l'ouvrier a déja été pointé sur un chantier le matin 
            if (condition) {
              $pointer = $pdo->updatePointageSal($idSemaine,$idVisiteur,$idChantier,$day,$DebutF,$FinF,0,$idUser,$coment);
            }*/
            /**
                                                 AFFICHAGE RESULTAT DU POINTAGE
*/
      //-******----ici if faudra gérer le contenu des case heure pour ne pas dépasser 24h et empecher les chaines de caractere  par exemple 
               
                //Si le pointage ne reussit pas on affiche un message d'erreur
                if (isset($pointer)) {
                  if($pointer){
                    echo "Erreur";  
                  }
                  else{           
                    if($FinalPartOfDayIsEmpty == false && $StartPartOfDayIsEmpty == false){
                      if (substr($FinF, 8,2)!="00") {
                        $telJour = substr($FinF,6,2);
                        $telMoisFin = substr($FinF,4,2);
                        $telHeureFin = substr($FinF,8,2);                   
                        $telMinuteFin = substr($FinF,10,2);
                        $telHeureDebut = substr($DebutD,0,2);
                        $telMinuteDebut = substr($DebutD, 2,4);
                        $telDateDebut = date('d').'/'.date('m')." de ".$telHeureDebut.'h'.substr($telMinuteDebut,0,2);
                        $telDateFin = $telJour.'/'.$telMoisFin.' à '.$telHeureFin.'h'.$telMinuteFin;
                        echo "<div class='erreur'>".$nom.' '.$prenom." à été pointé pour le ".$telDateDebut." Jusqu'au ".$telDateFin."</div>";       
                      }else {
                        $telJour = substr($DebutF,6,2);
                         $telMoisFin = substr($DebutF,4,2);
                         $telHeureFin = substr($DebutF,8,2);                    
                         $telMinuteFin = substr($DebutF,10,2);
                         $telHeureDebut = substr($DebutD,0,2);
                         $telMinuteDebut = substr($DebutD, 2,4);
                         $telDateDebut = date('d').'/'.date('m')." de ".$telHeureDebut.'h'.substr($telMinuteDebut,0,2);
                         $telDateFin = $telJour.'/'.$telMoisFin.' à '.$telHeureFin.'h'.$telMinuteFin;
                         echo "<div class='erreur'>".$nom.' '.$prenom." à été pointé pour le ".$telDateDebut." Jusqu'au ".$telDateFin."</div>";       
                      }
                    }
                    elseif($FinalPartOfDayIsEmpty == true && $StartPartOfDayIsEmpty == false) {
                      //Jour de debut de pointage
                      $telJourDebut = substr($DebutD,6,2);
                      //Jour de fin du pointage
                      $telJourFin = substr($FinD,6,2);

                      $telMoisFin = substr($FinD,4,2);
                      $telHeureFin = substr($FinD,8,2);                   
                      $telMinuteFin = substr($FinD,10,2);
              
                      $telHeureDebut = substr($DebutD,0,2);
                      $telMinuteDebut = substr($DebutD, 2,4);
                      $telDateDebut = date('d').'/'.date('m')." de ".$telHeureDebut.'h'.$telMinuteDebut;
                      $telDateFin = $telJourFin.'/'.$telMoisFin.' à '.$telHeureFin.'h'.$telMinuteFin;
                        echo "<div class='erreur'>".$nom.' '.$prenom." à été pointé pour le ".$telDateDebut ." jusq`au ".$telDateFin."</div>";            
                      }
                      else{
                        echo "yenasouci";
                      }
                  }
                }//fin isset pointer

            }else{ 
              echo "<div class='erreur'><center>Ce salarié a déja été pointé</center></div>";
            }
            		/**Sinon on affiche un message comfirmant le pointage avec la date et l'heure
            		* Si aucune fiche de pointage n'a été crée à la date $day pour l'utilisateur $idVisiteur
            		* On crée une fiche de pointage
        */ }//finNotenabled
                else {
                echo "<div class='erreur'>Saisissez des horaires convenables</div>";
              }   		
    }//Fin Isset POST

    else{
          if (isset($_POST["lieu"])) {
            if ($_POST["lieu"]==0) {
              echo "<div class='erreur'>Saisissez toutes les informations requise (les dates et le chantier)</div>";
            }
          }

          if (isset($_POST["submitEngin"]) && isset($_POST["idMateriel"]) && isset($_POST["listIndice"]) && isset($_POST["numMateriel"])) {
              //l'identifiant du materiel est la variable POST idMateriel 
              $idMateriel = $_POST["idMateriel"];
              //SI la variable post materiel existe
              if (isset($_POST["materiel"])) {
                //le libelle du materiel est egal a la variable post
                $materiel = $_POST["materiel"];
              }//Sinon affichez message d'erreur 
              else{}
              //Si la variable POST numMateriel existe
              if (isset($_POST["numMateriel"])) {
                //Recupere le numéro du materiel
                $numMateriel = $_POST["numMateriel"];
              }//Sinon le numéro du materiel est egal à 0
              else{
                //numéro du materiel
                $numMateriel = 0;
                echo "Pas de numengin,pointage d'enign de loc";
              }
              //La durée d'un pointage matériel est égal à la variable POST listINDICE
              $indice = $_POST["listIndice"];

/**
requete peu etre rejeté ,à sécuriser
*/
              //Si c'est un pointage de location
              if(isset($_POST["nomEngin"])){
                if (isset($_POST["nomGroup"])) {
                  $libelle = addslashes(strtoupper($_POST["nomGroup"]));
                  $getIdGroup = $pdo->getLastEntreprise();
                  $idMateriel = $getIdGroup["id"]+1;
                  $pdo->addGroup($idMateriel,$libelle);
                }
                $verifDejaSave = $pdo->EnginAllReadySave($idMateriel,addslashes(strtoupper(addslashes($_POST["nomEngin"]))));
                if (!empty($verifDejaSave["numero"])) {
                  $numMateriel = $verifDejaSave["numero"]+1;
                }else{
                    $numMateriel = 0;
                }
                //Ajouter le vehicule dans la BDD
                $add = $pdo->addEnginLoc($idMateriel,$numMateriel,addslashes(strtoupper($_POST["nomEngin"])));
                //La variable materiel recupere le nom de l'engin de location
                $materiel = addslashes(strtoupper($_POST["nomEngin"]));
              }
              if (isset($_SESSION["yesterday"])) {
                $getIdFiche = $pdo->getIdFicheByDC(yesterday(date("Ymd")),$_SESSION["chantier"],$idVisiteur);
              }else{
                //Recupere l'identifiant de la fiche de pointage d'un chantier à la date d'aujourd'hui
                $getIdFiche = $pdo->getIdFicheByDC($_SESSION["date"],$_SESSION["chantier"],$idVisiteur);
              }

              //Le numero de la fiche
              $idFiche = $getIdFiche["id"];
              //Si il existe un numéro de fiche
              if ($idFiche) {
                //Pointe un matériel
                $pointer = $pdo->pointerEngin($idFiche,$_SESSION["date"],$_SESSION["chantier"],$idVisiteur,$indice,$idMateriel,$materiel,$numMateriel,$_SESSION["numba"]);
              }else{
                echo "<div class='erreur'><center>Aucune fiche crée pour le chantier,pointer d'abord un salarié<center></div>";
              }
              if (isset($pointer)) {
                if (empty($pointer)) {
                echo "<div class='erreur'><center>Le materiel à bien été pointé<center></div>";
                }
              }else{}
            
          }//fin isset pointage engin
          else{
            //echo "Probleme au passage des variable submit";
          }
		}
    if (isset($_SESSION["chantier"])) {
      //Récupere les pointages ssalariées d'une fiche pointage ,d'un jours précis
      $lesPointagesSalToday = $pdo->getLesPointagesSalToday($_SESSION["chantier"],$_SESSION["date"],$idVisiteur,$numba);
      //Récupere les pointages matériel d'une fiche pointage ,d'un jours précis
      $lesPointageEnginToday = $pdo->getLesPointagesEnginToday($_SESSION["chantier"],$_SESSION["date"],$idVisiteur,$numba);
      //Récupere les pointages voies d'une fiche pointage ,d'un jours précis
      $lesConsigneToday = $pdo->getLesConsigneToday($_SESSION["chantier"],$_SESSION["date"],$idVisiteur,$numba);
    }
    $lesChantiers = $pdo->getLesChantiers();
    $LesMeteo=$pdo->getMeteo();
    $lesCateg=$pdo->getLesEntreprise();
    include("vues/v_fichePointage.php");
    break;
  }
    case'validerPointage':{
      if (isset($_REQUEST["meteo"])) {
        $_POST['listMeteo']=$_REQUEST["meteo"];
      }
      include("vues/v_signature.php");
      break;
    }
		case'voirAllPointage':{
			if($_SESSION['statut'] == "Cadre"){
				$lesPointages = $pdo->getAllPointages();
				include("vues/pointages.php");
			}
			else{
				//header('Location: index.php?uc=pointages&action=voirPointage');
			}		
			break;
		}
    case'accueil':{
      include("vues/v_accueil.php");
      break;
    }
}?>