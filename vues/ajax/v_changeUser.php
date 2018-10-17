<?php
session_start();
require_once ("../../include/PHPMailer-master/class.phpmailer.php");
require_once("../../include/PHPMailer-master/class.smtp.php");
require_once ("../../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
if (isset($_POST['user'])) {
	//Le nom et le prenom dans un tableau associatif
	$name = explode(' ',$_POST['user']);
	if($name[0] !='' && $name[1] !=''){
		//le nom en majuscule
		$nom = strtoupper($name[0]);
		//Le prenom avec la premier lettre en majuscule
		$prenom = strtoupper(substr($name[1],0,1)).substr($name[1],1,strlen($name[1]));
		//recupere l'identifiant deu salarié avec le nom et le prenom
		$getIdSal = $pdo->getIdUser($nom,$prenom);
		//L'identifiant du chantier
		$idChantier = $_SESSION["chantier"];
		//L'identifiant du salariée
		$idSal = $getIdSal["id"];
		if (isset($_SESSION["lejour"])) {
            $_SESSION["date"] = $_SESSION["lejour"];
        }
		//si il y aun identifiant trouvé
		if ($idSal) {
			if ($idSal== $_SESSION["idVisiteur"]) {
				echo "<div class='erreur'><center>Continuer</center></div>";
				$update = $pdo->updateAnimateur($_SESSION["date"],$idChantier,$idSal);
			}
			else{
				echo "<div class='erreur'><center>Continuer</center></div>";
				$update = $pdo->updateAnimateur($_SESSION["date"],$idChantier,$idSal);
				/**
																							ENVOIE DU MAIL 
				*/
				$leRespChantier = $pdo->getRespChantier($_SESSION["chantier"]);
    			$leResp = $leRespChantier["responsable"];
    			$getMailConduc  = $pdo->getMail($leResp);
    			$getLibChant = $pdo->getLibChantier($_SESSION["chantier"]);
    			$chantier= $getLibChant["libelle"].' '.$getLibChant["numero"];
    			$mailConduc = $getMailConduc["mail"];
    			$date = $_SESSION["date"];?><div style="color:#FFBE7A;"> <?php
				////////////////////////////////////////////////////////////////SENDING MAIL/////////////////////////////////////////////
 				date_default_timezone_set("Europe/Paris");
 
				$mail = new PHPMailer();//Nouvel instance de mail
				$body = utf8_decode("<body style=\"margin: 10px;\">
				<div style=\"width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 20px;\">
				<br>
				&nbsp;Un rapport journalier signer avec retard est disponible pour $chantier le $date.<br>
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
    			$mail->Subject = utf8_decode("Nouveau rapport journalier (pointage) ,$chantier");
    			$mail->Body = $body;
    			$mail->AddAddress("$mailConduc");//Adresse du destinataire
     			if(!$mail->Send()){
        		//echo "Mailer Error: " . $mail->ErrorInfo;
        		}
        		else{
        		//echo "Message has been sent";
       			}
			}
		}
		else{
			echo "<div class='erreur'><center>Peut être avez vous fait une erreur de saisie,je n'ai trouvé aucun(e) personne de ce nom </center></div>";
		}
		if (isset($update)) {		
			if ($update) {
				echo "<div class='erreur'><center>un erreur sait produite durant l'enregistrement des informations,contactez votre webmaster</center></div>";
			}
		}
	}
}
else{
	echo "<div class='erreur'><center>Erreur veuillez contacter votre webmaster</center></div>";
}?>