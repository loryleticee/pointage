<?php
/************************************************************************************
 * Nom : creerPdfReservation ********************************************************
 * But : Cette fonction gÉnÉre une version PDF d'une rÉservation É partir d'un ******
 * tableau d'informations fournit en paramÉtre **************************************
 * depuis la base de donnÉes ********************************************************
 * Retour : aucun *******************************************************************
 ************************************************************************************/


function creerPdfReservation($lesPointages,$lesMateriauxAnsart,$lesMateriauxLoc,$leChantier,$travaux,$pannes,$materiauxAP,$redacteur,$lesConsignes,$laMeteo)
{
    // permet d'inclure la bibliothÉque fpdf
    require('include/fpdf/fpdf.php');
$onePointage=array_slice($lesPointages, 0,1);
$theDay=$onePointage[0][0];
$file = utf8_decode($theDay.' '.$onePointage[0][1].''.$leChantier['libelle']).' '.utf8_decode($leChantier['numero']).'.pdf';

    // instancie un objet de type FPDF qui permet de crÉer le PDF
	
    $pdf = new FPDF();
    // ajoute une page
    $pdf->AddPage();
    // dÉfinit la police courante
    $pdf->SetLeftMargin(25);
    $pdf->Image('include/images/logo.png',10,10, 24, 15);
    //decallage
    $pdf->Cell(50);
    // Titre encadré
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(90,10,utf8_decode('RAPPORT JOURNALIER'),1,0,'C');
    $pdf->Ln(11);
    $pdf->Cell(50);
    $pdf->Cell(90,10,utf8_decode($leChantier['numero']).' '.utf8_decode($leChantier['libelle']),1,0,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Ln(10);
    $pdf->Cell(180,7,utf8_decode("Rédacteur: ").utf8_decode($redacteur['nom'].' '.$redacteur['prenom'])."                                                                                                  Date: ".dateAnglaisVersFrancais($redacteur['jour'])."                 ".utf8_decode("Météo: ".$laMeteo["meteo"]),1,0,'L');
    $pdf->Ln(7);
    $pdf->Cell(180,7,"PERSONNEL",1,0,'C');
    $pdf->Ln(8);
    $p=array(30,30,30,30,30,30);
    $pdf->Cell($p[0],7,utf8_decode("Nom prénom"),1,0,'C');
    $pdf->Cell($p[1],7,utf8_decode("Entreprise"),1,0,'C');
    $pdf->Cell($p[2],7,utf8_decode("Horaire Début"),1,0,'C');
    $pdf->Cell($p[3],7,"Horaire Fin",1,0,'C');
    $pdf->Cell($p[4],7,utf8_decode("Durée"),1,0,'C');
    $pdf->Cell($p[5],7,"Observation",1,0,'C');
    $pdf->Ln(5);
    foreach ($lesPointages as $unPointage) {
            $pdf->Cell($p[0],10,utf8_decode(substr($unPointage[8],0,10)).' '.utf8_decode($unPointage[9]),'LR');
            $pdf->Cell($p[1],10,utf8_decode($unPointage[13]),'LR');
            $pdf->Cell($p[2],10,substr(utf8_decode($unPointage[2]),11,5),'LR');
            $pdf->Cell($p[3],10,substr(utf8_decode($unPointage[5]),11,5),'LR','R');
            $heureOne=substr($unPointage[2],11,2);
            $minuteOne=substr($unPointage[2],14,2);
            $heureOneD=substr($unPointage[3],11,2);
            $minuteOneD=substr($unPointage[3],14,2);
            $heureOneF=substr($unPointage[4],11,2);
            $minuteOneF=substr($unPointage[4],14,2);
            $heure=substr($unPointage[5],11,2);
            $minute=substr($unPointage[5],14,2);
            $datedebut = substr($unPointage[2],0,10);
            $datefin = substr($unPointage[5],0,10);
            $duree=totalNuit($heureOne,$heureOneD,$minuteOne,$minuteOneD,$heureOneF,$heure,$minuteOneF,$minute,$datedebut,$datefin);
            $pdf->Cell($p[4],10,$duree,'LR','R');
            $pdf->Cell($p[5],10,utf8_decode($unPointage[12]),'LR','R');
            $pdf->Ln(8);
    }
    $pdf->Cell(array_sum($p),2,'','B');
    $pdf->Ln(4);
    $pdf->Cell(180,7,"Materiel",1,0,'C');
    $pdf->Ln(8);
    $tab = array(90);
    $pdf->Cell($tab[0],7,utf8_decode("ANSART-TP"),1,0,'C');
    $ta = array(90);
    $pdf->Cell($ta[0],7,utf8_decode("LOCATION"),1,0,'C');
    $pdf->Ln(7);
    $b=array(45,45);
    $pdf->Cell($b[0],7,utf8_decode("numero"),1,0,'C');
    $pdf->Cell($b[1],7,utf8_decode("type"),1,0,'C');
    $a=array(45,45);
    $pdf->Cell($a[0],7,utf8_decode("Entreprise"),1,0,'C');
    $pdf->Cell($a[1],7,utf8_decode("type"),1,0,'C');
    $pdf->Ln(6);
    $ml = 0;
    $lenghtTab = count($lesMateriauxAnsart);
    foreach ($lesMateriauxAnsart as $aMateriel) {
        $pdf->Cell($b[0],7,utf8_decode($aMateriel['numero']),'LR');
        $pdf->Cell($b[1],7,utf8_decode($aMateriel['nom']),'LR','R');
        if ($ml<$lenghtTab) {
            $pdf->Ln(5);
        }
        $ml++;
    }
    $pdf->Cell(90);
    foreach ($lesMateriauxLoc as $aMaterielLoc) {
        $pdf->Cell($a[0],7,utf8_decode($aMaterielLoc['entreprise']),'LR');
        $pdf->Cell($a[1],7,utf8_decode($aMaterielLoc['nom']),'LR','R');
        $pdf->Ln(5);
    }
    $pdf->Ln();
    $pdf->Cell(180,2,'','B');
    $pdf->Ln(3);
        $tCons = array(22,22,22,22,22,22,22,22);
    $pdf->Cell($tCons[0],7,utf8_decode("Numéro de voie"),1,0,'C');
    $pdf->Cell($tCons[1],7,utf8_decode("Début (AITC)"),1,0,'C');
    $pdf->Cell($tCons[2],7,utf8_decode("Fin (AITC)"),1,0,'C');
    $pdf->Cell($tCons[3],7,utf8_decode("Debut caténaire"),1,0,'C');
    $pdf->Cell($tCons[4],7,utf8_decode("Fin caténaire"),1,0,'C');
    $pdf->Cell($tCons[5],7,utf8_decode("Début travaux"),1,0,'C');
    $pdf->Cell($tCons[6],7,utf8_decode("Fin travaux"),1,0,'C');
    $pdf->Cell($tCons[7],7,utf8_decode("Durée effective"),1,0,'C');
    $pdf->Ln(4);
    foreach ($lesConsignes as $uneConsigne) {
        $pdf->Cell($tCons[0],10,utf8_decode($uneConsigne[4]),'LR');
        $pdf->Cell($tCons[1],10,substr(utf8_decode($uneConsigne[5]),0,5),'LR');
        $pdf->Cell($tCons[2],10,substr(utf8_decode($uneConsigne[6]),0,5),'LR','R');
        $pdf->Cell($tCons[3],10,substr(utf8_decode($uneConsigne[7]),0,5),'LR','R');
        $pdf->Cell($tCons[4],10,substr(utf8_decode($uneConsigne[8]),0,5),'LR','R');
        $pdf->Cell($tCons[5],10,substr(utf8_decode($uneConsigne[9]),0,5),'LR','R');
        $pdf->Cell($tCons[6],10,substr(utf8_decode($uneConsigne[10]),0,5),'LR','R');
        //
        $dureeEffectiv = dureeEffective($uneConsigne[5],$uneConsigne[6],$uneConsigne[7],$uneConsigne[8]);
        //
        $pdf->Cell($tCons[7],10,$dureeEffectiv,'LR','R');
        $pdf->Ln(8);
    }
    $pdf->Cell(array_sum($tCons),2,'','T');
    $pdf->Ln(6);
    $tTR = array(180);
    $pdf->Cell(180,6,utf8_decode("Travaux Réalisés"),1,0,'C');
    $pdf->Ln(5);
    foreach ($travaux as $untravaux) {
        $pdf->Cell($tTR[0],7,utf8_decode($untravaux['libelle']),'LR');
        $pdf->Ln(5);
    }
    $pdf->Cell(array_sum($tTR),2,'','B');
    $pdf->Ln(3);
    $tP = array(180);
    $pdf->Cell(180,6,utf8_decode("Pannes ou Arrêts"),1,0,'C');
    $pdf->Ln(5);
    foreach ($pannes as $unePanne) {
        $pdf->Cell($tP[0],7,utf8_decode($unePanne['libelle']),'LR');
        $pdf->Ln(5);
    }
    $pdf->Cell(array_sum($tP),2,'','B');
    $pdf->Ln(3);
    $tMAP = array(180);
    $pdf->Cell(180,6,utf8_decode("Materiel à prévoir"),1,0,'C');
    $pdf->Ln(6);
    foreach ($materiauxAP as $unMAP) {
        $pdf->Cell($tMAP[0],7,utf8_decode($unMAP['libelle']),'LR');
        $pdf->Ln(5);
    }
    $pdf->Cell(array_sum($tMAP),2,'','B');
    $pdf->Image($redacteur['signature'],60,265,24,8,'PNG');
    $pdf->SetXY(15,260);
    $pdf->Cell(40,10,utf8_decode('Rédacteur: '.$redacteur["nom"].' '.$redacteur["prenom"]."                                                 Conducteur de Travaux : "));//ATP SECU
    $pdf->SetXY(15,265);
    $pdf->Cell(40,10,utf8_decode("Date: ".date("d-m-Y")."                 Visa:                                                 Date:                      Visa:                 "));
    $pdf->SetXY(150,265);
    // Police Arial italique 8
    $pdf->SetFont('Arial','I',8);
    $pdf->AliasNbPages();
    // NumÉro de page
    $pdf->Cell(0,5,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
    ob_get_clean();
    $pdf->Output($file,'D');
}
$create=creerPdfReservation($lesPointages,$lesMateriauxAnsart,$lesMateriauxLoc,$leChantier,$travaux,$pannes,$materiauxAP,$redacteur,$lesConsignes,$laMeteo);