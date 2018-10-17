<?php
session_start();
require_once ("../../include/PHPMailer-master/class.phpmailer.php");
require_once("../../include/PHPMailer-master/class.smtp.php");
require_once ("../../include/class.pdogsb.inc.php");
/**
 * @name $getPdoAnsart connection
 */
$pdo = PdoGsb::getPdoGsb();
        /**
         * Si l'utilisateur choisit pour la signature est l'utilisateur connecté
         * Cloture la fiche et envoie un mail au conducteur de travaux responsable du chantier
         * Sinon Enregistre la signature du personnel
         * @$_SESSION["identUser"] integer Identifiant du personnel choisit pour la signature
         * @$_SESSION["idVisiteur"] integer Identifiant de l'utilsateur connecté
         * @$clot array Execute la fonction qui cloture la fiche avec en parametres suivant
         * @$_SESSION["numFicheAsc"] integer Identifant de la fiche accueil securité choisit
         * @date() date La date du jour
         * @$visa string La signature du personnel choisit
         * @$getLibChant array Tableau associatif contenant le libelle du chantier passé en parametre
         * @$chantier string Le libelle du chantier
         * @$leRespChantier array Tableau associatif contenant l'identifant du conducteur de trvaux responsable de la fiche acceuil securité passé en parametre
         * @$leResp integer L'identifiant du conducteur de travaux responsable de la fiche securité 
         * @$getMailConduc array Tableau associatif contenant le mail du responsable de la fiche accueil securité
         * @$mailConduc string L'email du conducteur de travaux responsable de la fiche d'accueil securite
         * @$date string+date La date du jour concatené avec un chaine de caratères
         * $save array Execute l'enregistrement de la signature du personnel qui vient de signer
        */

    	   $getLibChant = $pdo->getLibChantier($_SESSION["chantier"]);
    	   $chantier= $getLibChant["libelle"].' '.$getLibChant["numero"];
    	   $leRespChantier = $pdo->getRespChantier($_SESSION["chantier"]);
    	   $leResp = $leRespChantier["responsable"];
    	   $getMailConduc  = $pdo->getMail($leResp);
    	   $mailConduc = $getMailConduc["mail"];?>
            <div style="color:#FFBE7A;"> <?php
////////////////////////////////////////////////////////////////SENDING MAIL/////////////////////////////////////////////
 		  date_default_timezone_set("Europe/Paris");
 
	       $mail = new PHPMailer();//Nouvel instance de mail
	       $body = utf8_decode("<body style=\"margin: 10px;\">
			<div style=\"width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">
			<br>
			&nbsp;Une $chantier<br>
			</div>
			</body>");
   	        $mail->IsSMTP(); // SMTP Activé
    	   $mail->SMTPDebug = 0; // debogage: 1 = erreurs et messages, 2 = messages uniquement
    	   $mail->SMTPAuth = true; // authentication activé
    	   $mail->SMTPSecure = 'ssl'; // Transfert securisé activé, Requis pour GMail
    	   $mail->Host = "smtp.alwaysdata.com";
    	   $mail->Port = 465; // ou 587
           $mail->IsHTML(true);
    	   $mail->Username = "travaux@ansart-tp.com";
    	   $mail->Password = "Ansarttp91";
    	   $mail->SetFrom("noreply@ansart-tp.com");
    	   $mail->Subject = utf8_decode("Panne ou arret à prevoir sur $chantier");
    	   $mail->Body = $body;
    	   $mail->AddAddress("$mailConduc");//Adresse du destinataire $mailConduc
     	  if(!$mail->Send()){
            //echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else{
            //echo "Message has been sent";
            }?></div>
