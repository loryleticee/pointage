<?php
/** 
 * ClASse d'accès aux données. 
 
 * Utilise les services de la clASse PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la clASse
 
 * @package default
 * @author  LETICEE LORY <0665938792 loryleticee@gmail.com>
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

Class PdoGsb{   		
      	private static $serveur='mysql:host=http://127.0.0.1/phpmyadmin';
      	private static $bdd='dbname=ansart-tp_pointageetaccueilsecurite';   		
      	private static $user='root';    		
      	private static $mdp='';	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la clASse
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la clASse
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la clASse PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau ASsociatif 
*/
	public function getInfosUser($login, $mdp){
		$req = "SELECT salarie.id, salarie.nom,salarie.mdp , salarie.prenom , type.libelle AS type  FROM salarie,type WHERE salarie.id_type=type.id 
		AND salarie.login='$login' AND salarie.mdp='$mdp' ";
		$res = PdoGsb::$monPdo->query($req);
		$ligne = $res->fetch();
		return $ligne;
	}
/**
*Retourne les pointages salarié du jour passé en paramètres
 * @param $chantier l'identifiant du chantier
 * @param $day la date du jour  
 * @param $idVisiteur l'identifiant du visiteur
 * @param $numba le numero identifiant de la fiche
 * @return les pointages des salaries sous la forme d'un tableau ASsociatif 
*/
	public function getLesPointagesSalToday($chantier,$day,$idVisiteur,$numba){
	    $req = "SELECT DISTINCT pointage.jour,pointage.idFichePointage as id,dt_debutOne,dt_finOne,dt_debut,dt_fin,
	    statut.libelle as statut,salarie.nom as nom,salarie.prenom as prenom,chantier.libelle as chantier,chantier.numero as numero,fiche_pointage.numba
	    FROM fiche_pointage,pointage,salarie,statut,chantier 
	    WHERE fiche_pointage.numba=pointage.numba
	    AND chantier.id=pointage.idChantier 
	    AND salarie.id=pointage.salarie 
	    AND statut.id=pointage.statut 
	    AND fiche_pointage.signature='' 
	    AND pointage.idChantier=$chantier
	    AND pointage.jour='$day' 
	    AND pointage.idSal=$idVisiteur
	    AND pointage.numba=$numba";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
*Retourne les pointages matériaux du jour passé en paramètres
 * @param $chantier l'identifiant du chantier
 * @param $day la date du jour  
 * @param $idVisiteur l'identifiant du visiteur
 * @param $numba le numero identifiant de la fiche
 * @return les pointages des salaries sous la forme d'un tableau ASsociatif 
*/
	public function getLesPointagesEnginToday($chantier,$day,$idVisiteur,$numba){
	    $req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,
	    indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier,entreprise.raison as E,pointagemateriel.engin as idmat,pointagemateriel.numba
	    FROM pointagemateriel,engin,indice,chantier,entreprise,fiche_pointage
	    WHERE engin.numero=pointagemateriel.num
	    AND entreprise.id = engin.id 
	    AND engin.libelle = pointagemateriel.libelle
	    AND chantier.id=pointagemateriel.idChantier 
	    AND indice.id=pointagemateriel.indice
	    AND fiche_pointage.id = pointagemateriel.idFichePointage
	    AND fiche_pointage.signature=''
	    AND pointagemateriel.idChantier=$chantier 
	    AND pointagemateriel.jour='$day' 
	    AND pointagemateriel.idSal=$idVisiteur
	   	AND pointagemateriel.numba=$numba";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	/**
	*Récupere les fiches pointages par semaine
	* @param $idFicheWeek l'identifiant de la fiche de pointage
	* @param $idChantier l'identifiant du chantier
	* @param $idSal L'identifiant du salarié
	 * @return les pointages des salaries sous la forme d'un tableau ASsociatif 
	*/
	public function getPointagesByWeek($idFicheWeek,$idChantier,$idSal){
		$req = "SELECT DISTINCT pointage.jour,pointage.idFichePointage as id ,dt_debutOne,dt_finOne,dt_debut,dt_fin,pointage.idSal as redacteur,
	    statut.libelle as statut,salarie.nom as nom,salarie.prenom as prenom ,chantier.libelle as chantier,chantier.numero as numero
	    FROM fiche_pointage,chantier,pointage,salarie,statut 
	    WHERE fiche_pointage.id=pointage.idFichePointage
	    AND salarie.id=pointage.salarie 
	    AND chantier.id=pointage.idChantier
	    AND statut.id=pointage.statut  
	    AND fiche_pointage.id=$idFicheWeek
	    AND chantier.id=$idChantier
	    AND pointage.idSal = $idSal";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	/**
	*Retourne les pointages par jour
	* @param $idChantier l'identifiant du chantier
	* @param $jour La date du chantier
	* @param $idSal l'identifant du salarié qui a pointé
	* @return les pointages des salaries sous la forme d'un tableau ASsociatif 
	*/
	public function getPointagesByDay($idChantier,$jour,$idSal){
		$req = "SELECT DISTINCT pointage.jour,pointage.idFichePointage as id ,dt_debutOne,dt_finOne,dt_debut,dt_fin,pointage.idSal as redacteur,
	    statut.libelle as statut,salarie.nom as nom,salarie.prenom as prenom,chantier.libelle as libChantier,chantier.numero as numero,coment,
	    entreprise.raison as raison
	    FROM fiche_pointage,chantier,pointage,salarie,statut,entreprise
	    WHERE fiche_pointage.id = pointage.idFichePointage
	    AND salarie.group = entreprise.id
	    AND salarie.id=pointage.salarie 
	    AND chantier.id=pointage.idChantier
	    AND statut.id=pointage.statut  
	    AND pointage.idChantier=$idChantier
	    AND pointage.jour='$jour'
	    AND pointage.idSal = $idSal";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	/**
	*Retourne les pointages par jour et par numéro identifiant
	* @param $idChantier l'identifiant du chantier
	* @param $jour La date du chantier
	* @param $idSal l'identifant du salarié qui a pointé
	* @param $numba Numéro identifiant
	* @return les pointages des salaries sous la forme d'un tableau ASsociatif 
	*/
	public function getPointagesByDayBis($idChantier,$jour,$idSal,$numba){
		$req = "SELECT DISTINCT pointage.jour,pointage.idFichePointage as id ,dt_debutOne,dt_finOne,dt_debut,dt_fin,pointage.idSal as redacteur,
	    statut.libelle as statut,salarie.nom as nom,salarie.prenom as prenom,chantier.libelle as libChantier,chantier.numero as numero,coment,
	    entreprise.raison as raison
	    FROM fiche_pointage,chantier,pointage,salarie,statut,entreprise
	    WHERE fiche_pointage.id = pointage.idFichePointage
	    AND salarie.group = entreprise.id
	    AND salarie.id=pointage.salarie 
	    AND chantier.id=pointage.idChantier
	    AND statut.id=pointage.statut  
	    AND pointage.idChantier=$idChantier
	    AND pointage.jour='$jour'
	    AND pointage.idSal = $idSal
	    AND pointage.numba = $numba";	
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	/**
	*Récupere les  pointages matériaux par semaine
	* @param $week l'identifiant de la fiche de pointage
	* @param $chantier l'identifiant du chantier
	* @param $idSal L'identifiant du salarié
	* @return les pointages des salaries sous la forme d'un tableau ASsociatif 
	*/
	public function getLesPointagesEnginByWeek($chantier,$week,$idSal){
	    $req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,pointagemateriel.idSal as redacteur,
	    indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier
	    FROM pointagemateriel,engin,indice,chantier 
	    WHERE engin.id=pointagemateriel.engin 
	   	AND pointagemateriel.num = engin.numero
	    AND chantier.id=pointagemateriel.idChantier 
	    AND indice.id=pointagemateriel.indice
	    AND pointagemateriel.idChantier=$chantier 
	    AND pointagemateriel.idFichePointage=$week
	    AND pointagemateriel.idSal=$idSal";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
	/**
	*Récupere les  pointages matériaux par jour
	* @param $week l'identifiant de la fiche de pointage
	* @param $chantier l'identifiant du chantier
	* @param $idSal L'identifiant du salarié
	* @return les pointages des matériaux sous la forme d'un tableau ASsociatif 
	*/
	public function getLesPointagesEnginByDay($chantier,$day,$idSal){
	    $req = "SELECT DISTINCT pointagemateriel.jour, pointagemateriel.idFichePointage AS id,pointagemateriel.idSal as redacteur,
	    engin.numero as nengin,engin.libelle as libengin,chantier.libelle as libchant,
	    chantier.numero as numchant,
	    indice.numero as indice,pointagemateriel.jour as jour
		FROM pointagemateriel,engin,chantier,indice
		WHERE pointagemateriel.idChantier = chantier.id
		AND pointagemateriel.indice = indice.id
		AND pointagemateriel.num = engin.numero
		AND pointagemateriel.libelle = engin.libelle
		AND pointagemateriel.idChantier =$chantier
		AND pointagemateriel.jour ='$day'
		AND pointagemateriel.idSal=$idSal"; 
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
		/**
	*Récupere les  pointages matériaux par jour et par numéro identifiant
	* @param $week l'identifiant de la fiche de pointage
	* @param $chantier l'identifiant du chantier
	* @param $idSal L'identifiant du salarié
	* @param $numba numéro identifiant 
	* @return les pointages des matériaux sous la forme d'un tableau ASsociatif 
	*/
	public function getLesPointagesEnginByDayBis($chantier,$day,$idSal,$numba){
	    $req = "SELECT DISTINCT pointagemateriel.jour, pointagemateriel.idFichePointage AS id,pointagemateriel.idSal as redacteur,
	    engin.numero as nengin,engin.libelle as libengin,chantier.libelle as libchant,
	    chantier.numero as numchant,
	    indice.numero as indice,pointagemateriel.jour as jour
		FROM pointagemateriel,engin,chantier,indice
		WHERE pointagemateriel.idChantier = chantier.id
		AND pointagemateriel.indice = indice.id
		AND pointagemateriel.num = engin.numero
		AND pointagemateriel.libelle = engin.libelle
		AND pointagemateriel.idChantier =$chantier
		AND pointagemateriel.jour ='$day'
		AND pointagemateriel.idSal = $idSal
		AND pointagemateriel.numba = $numba"; 
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
* Retourne l'identifiant du dernier matériel
* @return $laLigne Identifiant du dernier salarié
*/
		public function getLastIdEngin(){
			$req="SELECT max(idENgin) AS idEngin FROM engin";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
            return $laLigne;
		}
/**
* Récupère toutes les informations sur l'engin passé en parametre
* @param string $lib Libelle du matériel
* @param string $um Numero du matériel
* @return array $laLigne Tableau associatif contenant toutes les informations sur le salarié
*/
		public function getUnEngin($num,$lib){
			$req="SELECT * FROM engin WHERE numero=$num AND libelle=$lib";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
            return $laLigne;
		}
/**
* Ajoute un engin
* @param string $id identifiant du matériel
* @param string $libelle Libelle du matériel
* @param string $um Numero du matériel
* @return array $laLigne Tableau associatif contenant toutes les informations sur le salarié
*/
		public function addEngin($id,$numero,$libelle){
			$req="INSERT INTO engin VALUES ($id,$numero,'$libelle')";  
			$res = PdoGsb::$monPdo->query($req);
		}
		/**
* Supprime le matériel passé en parametre
* @param integer idEngin Identifiant du materiel
* @param integer $numeroEngin numero du materiel
*/
    public function alterEngin($idEngin,$libelle,$numero){
            $req = "UPDATE engin SET libelle ='$libelle' ,numero =$numero WHERE id =$idEngin AND numero= $numero";
            PdoGsb::$monPdo->query($req);
    }
    /**
* Modifie l'engin passé en parametre
* @param integer $idSal Identifiant du salarié
*/
    public function supEngin($idEngin,$numeroEngin){
            $req = "DELETE FROM engin WHERE id =$idEngin AND numero= $numeroEngin";
            PdoGsb::$monPdo->query($req);
    }
/**
* Ajoute un engin de location
* @param string $id identifiant du matériel
* @param string $libelle Libelle du matériel
* @param string $um Numero du matériel
* @return array $laLigne Tableau associatif contenant toutes les informations sur le salarié
*/
		public function addEnginLoc($id,$numero,$libelle){
			$req="INSERT INTO engin VALUES ($id,$numero,'$libelle')";  
			$res = PdoGsb::$monPdo->query($req);
		}
/**
* Retourne l'identifiant du dernier salarié
* @return $laLigne Identifiant du dernier salarié
*/
	public function getLastIdSal(){
            $req = "SELECT max(id) AS id FROM salarie";  
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}

/**
* Ajoute un salarié dans la base données
 * @param integer $id Identifiant du salarié
 * @param string $nom Nom du salarié
 * @param string $prenom Prenom du salarié
 * @param string $login Login du salarié
 * @param string $mdp Mot de passe du salarié
 * @param string $email Adresse email du salarié
 * @param integer $tauxHoraire Taux horaire du salarié
 * @param integer $group Identifiant de l'entreprise du salarié
 * @param integer $type Identifiant du type de salarié
*/
	public function addSal($id,$nom,$prenom,$login,$mdp,$email,$group,$type){
            $req = "INSERT INTO salarie VALUES ($id,'$nom','$prenom','$login','$mdp','$email',0,$group,$type)";  
            PdoGsb::$monPdo->query($req);
	}
	/**
* Ajoute un salarié interimere dans la base données
 * @param integer $id Identifiant du salarié
 * @param string $nom Nom du salarié
 * @param string $prenom Prenom du salarié
 * @param integer $group Identifiant de l'entreprise du salarié

*/
	public function addSalInterim($id,$nom,$prenom,$group){
            $req = "INSERT INTO salarie VALUES ($id,'$nom','$prenom','Ceci01Est02Un03login04Generer05Automatiq','f563474fbf2e47a462b9dd36a18a733442f048a53b041b8609786a8e82421a280e042a0b78a312489b7f07ea3139124d4d8f3319b80931b8fcb6c11ede7c3e44','',$group,4)";  
            PdoGsb::$monPdo->query($req);
	} 
/**
* Récupère toutes les informations sur le salarié passé en parametre
* @param string $nom Nom du salarié
* @return array $lesLignes Tableau associatif contenant toutes les informations sur le salarié
*/
		public function getInfosSal(){
			$req="SELECT * FROM salarie";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
* Récupere les types de salarié
* @return array $lesLignes Tableau assicatif contenant les types de salariés
*/
		public function getLesTypes(){
			$req="SELECT * FROM type";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
* Récupère Toutes les informations sur tous les salariés
* @return array $lesLignes Tableau assicatif contenant toutes les information sur les salariés
*/
		public function getLesSal(){
			$req="SELECT * FROM salarie ";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
* Supprime le salarié passé en parametre
* @param integer $idSal Identifiant du salarié
*/
	public function supSal($idSal){
            $req = "DELETE FROM salarie WHERE id =$idSal";
            PdoGsb::$monPdo->query($req);
    }

      public function getStatut($idUser){
            $req = "SELECT id_type as statut FROM salarie WHERE id=$idUser ";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
			return $laLigne;
      }
	
/**
* Récupère Toutes les informations sur tous les ouvriers
* @return array $lesLignes Tableau assicatif contenant toutes les information sur les salariés
*/
		public function getOuvrier(){
         	$req="SELECT * FROM salarie WHERE id!=0 AND id_type!=3 group by nom ASC;";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
*Recupere un ouvrier à l'aide de son nom et son prenom
*@param chainede Description
*/
		public function getOuvrierById($nom,$prenom){
         	$req="SELECT * FROM salarie WHERE nom='$nom' AND prenom='$prenom'";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
///////////////////////////////////////////LES CHANTIERS//////////////////////////////
/**
* Selectionne tous les  chantiers
* @return array $lesLignes Tableau associatif contenant les chantiers
*/
		public function getLesChantiers(){
         	$req="SELECT * FROM chantier";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}		
/**
* Selectionne l'identifiant du derniers chantier enregistré
* @return array $laLigne Tableau associatif contenant l'identifiant du dernier
*/
		public function getLastChantier(){
         	$req="SELECT max(id) as id FROM chantier";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
/**
 * Recupere l'identifiant du chantier
 * @param string $libelle du chantier
 * @return array $laLigne Tableau associatif contenant l'identifiant du chantier
*/
		public function getIdChantier($libelle){
         	$req="SELECT id FROM chantier WHERE libelle='$libelle'";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
/**
 * Recupere l'identifiant du chantier
 * @param string $numero du chantier
 * @return array $laLigne Tableau associatif contenant l'identifiant du chantier
*/
		public function getIdChantierByNum($numero){
         	$req="SELECT id FROM chantier WHERE numero=$numero";  
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
/**
* Recupere Les infos du chantier liée à la fiche passé en parametre
* @param integer $fiche Identifiant de la fiche
* @return $lesLignes Tableau associatif contenant les infos du chantier
*/
		public function getChantierFiche($fiche){
                    $req="SELECT * FROM chantier WHERE idChantier=''";  
                    $res = PdoGsb::$monPdo->query($req);
                    $lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
*Ajoute un chantier
* @param integer $id Identifiant du chantier
* @param integer $num Numéro du chantier
* @param string $libelle Nom du chantier
* @param integer $resp Identifiant du conducteur de travaux responsable du chantier
*/
		public function addChantier($id,$num,$libelle,$resp){
         	$req="INSERT INTO chantier VALUES($id,$num,'$libelle',$resp)";  
			PdoGsb::$monPdo->query($req);
		}
		/**
 * Recupere Le libelle du chantier 
 * @param integer $idFiche Identifiant du chantier 
 * @return array $laLigne Tableau associatif contenant Le libelle du chantier 
 */        
	public function getLibChantier($idFiche){
            $req = "SELECT libelle,numero FROM chantier WHERE id=$idFiche";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}
/**
 * Recupere l'identifiant responsable du chantier
 * @param integer $idChantier Identifiant du chantier
 * @return array Tableau associatif contenant l'identifiant responsable du chantier
 */        
	public function getRespChantier($idChantier){
            $req = "SELECT responsable FROM chantier WHERE id=$idChantier";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}
/**
 * Recupère L'email du conducteur de travaux responsable de la fiche d'accueil securite
 * @param integer $idUser Identifiant du conducteur de travaux
 * @return array Tableau associatif contenant L'email du conducteur de travaux responsable de la fiche d'accueil securite
 */        
	public function getMail($idUser){
            $req = "SELECT salarie.email as mail FROM salarie WHERE salarie.id=$idUser";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}
	/**
 * Recupere les materiaux
 * @return array Tableau associatif contenant les materiaux
 */      
		public function getEngin(){
         	$req="SELECT * FROM engin WHERE id!=0";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
/**
*Retourne la liste des martéraux ANSART
*@return la liste de matériaus d'ANSART TP
*/
		public function getEnginAnsart(){
         	$req="SELECT * FROM engin WHERE id=0";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchall();
			return $lesLignes;
		}
		
////////////////////////////////////////// LES POINTAGES //////////////////////////////////
		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
        public function pointerSal($idFicheWeek,$idVisiteur,$idChantier,$day,$DebutD,$FinD,$DebutF,$FinF,$statut,$idUser,$coment,$numba){
        	$req="INSERT INTO pointage VALUES($idFicheWeek,$idVisiteur,$idChantier,'$day','$DebutD','$FinD','$DebutF','$FinF',$statut,$idUser,'$coment',$numba)";
         	PdoGsb::$monPdo->query($req);
        }
        		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
        public function pointerEngin($idFiche,$date,$chantier,$idVisiteur,$indice,$engin,$libelle,$numero,$numba){
        	$req="INSERT INTO pointagemateriel VALUES($idFiche,$idVisiteur,$chantier,'$date',$indice,$numero,$engin,'$libelle','',$numba)";
         	PdoGsb::$monPdo->query($req);
        }
        		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function getLastPointage($day){
         	$req="SELECT * from pointage WHERE jour='$day'";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function pointeAllReadySal($day,$idUser,$idChantier,$heurDebut,$numba){
         	$req="SELECT * from pointage,fiche_pointage 
         	WHERE fiche_pointage.id=pointage.idFichePointage  
         	AND pointage.jour='$day' 
         	AND salarie=$idUser 
         	AND idChantier=$idChantier 
         	AND fiche_pointage.signature='' 
         	AND pointage.dt_debutOne=$heurDebut
         	AND pointage.numba=$numba";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function getPointagesEnginAnsart($chantier,$day){
	    	$req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,
	    	indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier,coment
	    	FROM pointagemateriel,engin,indice,chantier
	    	WHERE engin.numero=pointagemateriel.num  
	    	AND engin.libelle=pointagemateriel.libelle
	    	AND engin.id=pointagemateriel.engin
	    	AND chantier.id=pointagemateriel.idChantier 
	    	AND indice.id=pointagemateriel.indice
	    	AND pointagemateriel.idChantier=$chantier 
	    	AND pointagemateriel.jour='$day'
	    	AND pointagemateriel.engin=0"; 
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes; 
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
        public function getPointagesEnginAnsartBis($chantier,$day,$idSal,$numba){
	    	$req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,
	    	indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier,coment
	    	FROM pointagemateriel,engin,indice,chantier
	    	WHERE engin.numero=pointagemateriel.num 
	    	AND engin.libelle=pointagemateriel.libelle
	    	AND engin.id=pointagemateriel.engin
	    	AND chantier.id=pointagemateriel.idChantier 
	    	AND indice.id=pointagemateriel.indice
	    	AND pointagemateriel.idChantier=$chantier 
	    	AND pointagemateriel.jour='$day'
	    	AND pointagemateriel.idSal=$idSal
	    	AND pointagemateriel.engin=0
	    	AND pointagemateriel.numba=$numba"; 
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes; 
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
         public function getPointagesEnginLoc($chantier,$day){
	    	$req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,
	    	indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier,coment,entreprise.raison as entreprise
	    	FROM pointagemateriel,engin,indice,chantier,entreprise
	    	WHERE engin.numero=pointagemateriel.num 
	    	AND engin.id=pointagemateriel.engin
	    	AND entreprise.id=pointagemateriel.engin
	    	AND engin.libelle=pointagemateriel.libelle
	    	AND chantier.id=pointagemateriel.idChantier 
	    	AND indice.id=pointagemateriel.indice
	    	AND pointagemateriel.idChantier=$chantier 
	    	AND pointagemateriel.jour='$day'
	    	AND pointagemateriel.engin!=0"; 
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes; 
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
        public function getPointagesEnginLocBis($chantier,$day,$numba){
	    	$req = "SELECT DISTINCT pointagemateriel.jour,pointagemateriel.idFichePointage as id,
	    	indice.numero as indice,engin.libelle as nom,engin.numero as numero,chantier.libelle as chantier,chantier.numero as numeroChantier,coment,entreprise.raison as entreprise
	    	FROM pointagemateriel,engin,indice,chantier,entreprise
	    	WHERE engin.numero=pointagemateriel.num 
	    	AND entreprise.id=pointagemateriel.engin
	    	AND engin.libelle=pointagemateriel.libelle
	    	AND engin.id=pointagemateriel.engin
	    	AND chantier.id=pointagemateriel.idChantier 
	    	AND indice.id=pointagemateriel.indice
	    	AND pointagemateriel.idChantier=$chantier 
	    	AND pointagemateriel.jour='$day'
	    	AND pointagemateriel.engin!=0
	    	AND pointagemateriel.numba=$numba";  
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes; 
         }
		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function getIdSemaine ($day){
         	$req="SELECT semaine.id as id FROM semaine WHERE semaine.debutS <= '$day' AND semaine.finS >= '$day'";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
         public function getFichePointageSemaine ($idWeek,$idChantier){
         	$req="SELECT id FROM fiche_pointage_semaine WHERE id= $idWeek  AND idChantier=$idChantier";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
         		/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
         public function newFicheWeek($idSemaine,$idChantier){
        	$req="INSERT INTO fiche_pointage_semaine VALUES($idSemaine,$idChantier)";
         	PdoGsb::$monPdo->query($req);
        }          
/**
*Recupere les fiche d'un pointage par rapport a un jour et un tulisateur
*@param $name Description
*/
		public function getFichePointage($idFicheWeek,$idChantier,$day,$idUser,$numba){
         	$req="SELECT * from fiche_pointage WHERE jour='$day' AND idSal=$idUser AND chantier=$idChantier AND id=$idFicheWeek AND numba=$numba";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
        public function getLesPointagesFiche($idFiche){
			$req = "SELECT * FROM pointage WHERE idFiche = $idFiche";	
			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes; 
		}
		public function getNumabFiche($idSemaine,$idChantier,$day,$idVisiteur,$numba){
         	$req="SELECT numba as numero,signature from fiche_pointage WHERE jour='$day' AND idSal=$idVisiteur AND chantier=$idChantier AND id=$idSemaine AND numba=$numba";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
/**
*Crée un nouvelle fiche de pointage
*@param $idSemaine 
*@param $idChantier
*@param $day                
**@param $idVisiteur
*/
         public function newFiche($idSemaine,$idChantier,$day,$idVisiteur,$numba){
         	$req="INSERT INTO fiche_pointage(id,chantier,jour,idSal,commentaire,signature,numba) values($idSemaine,$idChantier,'$day',$idVisiteur,'','',$numba)";
         	$res = PdoGsb::$monPdo->query($req);
         }
        public function newFicheAgain($idSemaine,$idChantier,$day,$idVisiteur,$numba){
         	$req="INSERT INTO fiche_pointage(id,chantier,jour,idSal,commentaire,signature,numba) values($idSemaine,$idChantier,'$day',$idVisiteur,'','',$numba)";
         	$res = PdoGsb::$monPdo->query($req);
         }
////////////////////////////////////////////// LES ENTREPRISES  /////////////////////////////
/**
* Recupere les entreprises
* @return array $lesLignes Tableau associatif contenant les infos des entreprises
*/
         public function  getLesEntreprise(){
         	$req="SELECT * FROM entreprise order by raison ASC";
         	$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes;
         }
         /**
* Recupere la derniere lol
* @return array $lesLignes Tableau associatif contenant les infos de la derniere entreprise
*/
         public function getLastEntreprise(){
			$req="SELECT max(id) as id FROM entreprise";
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
/**
* Recupere tous les themes de la base de donées
* @return array $lesLignes Tableau associatif contenant les infos des themes
*/
         public function  getLesThemes(){
         	$req="SELECT * FROM theme";
         	$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes;
         }
/**
* Modifie un theme
* @param integer $id Identifiant du theme
* @param string $nom Nom du theme
*/
      public function alterTheme($id,$nom){
            $req = "UPDATE theme SET libelle='$nom' WHERE id=$id";  
            PdoGsb::$monPdo->query($req);
      }
/**
* Supprime le theme passé en parametre
* @param integer $id Identifiant du theme
*/
      public function supTheme($id){
            $req = "DELETE FROM theme WHERE id =$id";
            PdoGsb::$monPdo->query($req);
         }
////////////////////////////////////////////////////// HACKAGE ///////////////////////
/**
*Hash un mot de passe]
*
*/
         function hash_password($password){
	 		 // 256 bits rANDom string
 			$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
  			// prepend salt then hash
  			$hash = hash("sha256", $password . $salt);
  			// return salt AND hash in the same string
  			return $salt . $hash;
		}
/**Recupere le mot passe hasé correspon au login t'appé*
*@param $lgin
*/
		 public function getHash($login){
         	$req="SELECT mdp FROM salarie WHERE login='$login'";
         	$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
         }
/**Verifie le si le mot de passe est le bon
*@param le hash
*
*/
		function check_password($password, $dbhash){
 			// get salt from dbhash
			 $salt = substr($dbhash, 0, 64);   
 			// get the SHA256 hash
 			$valid_hash = substr($dbhash, 64, 64);
 			// hash the password
 			 $test_hash = hash("sha256", $password . $salt);
			// test
			return $test_hash === $valid_hash;
		}
////////////////////////////////LES COMMMENTAIRES /////////////////////////
/**
*Ajoute un commentaire à la fiche de pointage passé en
*
*/
		public function Addcoment($com,$fiche){
                    $req="UPDATE fiche_pointage SET commentaire='$com' WHERE id=$fiche";
                    PdoGsb::$monPdo->query($req);
		}
/**Recupere le commentaire de la fiche 
*
*
*/
		public function getCom($fiche){
 			$req="SELECT commentaire as com from fiche_pointage WHERE id=$fiche";
         	$res = PdoGsb::$monPdo->query($req);
         	$laLigne = $res->fetch();
			return $laLigne;
		}
/**Recupere l'identifiant du theme'
*
*/
		 public function getIdTheme($libTheme){
 			$req="SELECT * from theme WHERE libelle ='$libTheme';";
			$res = PdoGsb::$monPdo->query($req);
			//$f=PdoGsb::$monPdo->errorInfo();
			//print_r($f);
			$laLigne = $res->fetch();
         	return $laLigne;
         }
		public function getLastTheme(){
			$req="SELECT max(id) as id FROM theme";
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
		public function addTheme($id,$libelle){
			$req="INSERT INTO theme VALUES($id,'$libelle')";
			PdoGsb::$monPdo->query($req);
		}
/**
* Recupere l'identifiantde l'utilisateur grace au nom et au prenom
 * @param string $nom Nom de l'utilisateur
 * @param string $prenom prenom de l'utilisateur
 * @return array $laLigne Tableau associatif contenant l'identifiant de l'utilisateur
 */ 
		public function getIdUser($nom,$prenom){
			$req="SELECT id FROM salarie WHERE nom ='$nom' AND prenom='$prenom'";
 			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetch();
			return $laLigne;
		}
		public function addSalToAsc($idUser,$idAsc){
			$req="INSERT INTO assec_personnel VALUES($idUser,$idAsc)";
 			PdoGsb::$monPdo->query($req);
		}
		public function getSalAsc($numFiche,$date){
			$req="SELECT salarie.id,salarie.nom,salarie.prenom FROM salarie,assec_personnel,assec WHERE salarie.id=assec_personnel.idSalalarie 
			AND assec.id=assec_personnel.idAssec
			AND assec_personnel.idAssec= $numFiche
			AND assec.jour='$date'";
 			$res = PdoGsb::$monPdo->query($req);
			$lesLignes = $res->fetchAll();
			return $lesLignes;
		}
		/**
 * Recupère L'identifiant, le nom et le prenom des conducteur de travaux
 * @return array Tableau associatif contenant 
 */        
	public function getLesConduc(){
            $req = "SELECT id,nom,prenom FROM salarie WHERE id_type=3";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
        }
        public function getLesWeek($idChantier){
            $req = "SELECT DISTINCT pointage.idFichePointage as id FROM pointage WHERE pointage.idChantier=$idChantier";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      	public function getLesJour($idSemaine,$chantier){
            $req = "SELECT DISTINCT jour FROM pointage WHERE jour BETWEEN (select debutS FROM semaine where id=$idSemaine ) AND (select finS from semaine where id =$idSemaine) AND idChantier=$chantier";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function alterPointage($idSal,$jour,$user,$chantier,$debutD,$finD,$debutF,$finF){
            $req = "UPDATE pointage SET dt_debutOne ='$debutD', dt_finOne='$finD',dt_debut='$debutF',dt_fin='$finF' 
            WHERE salarie=$idSal AND jour='$jour' AND  idSal=$user AND idChantier=$chantier";
            $res = PdoGsb::$monPdo->query($req);
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function alterPointageEngin($name,$id,$date,$chantier,$indice,$num){
            $req = "UPDATE pointagemateriel SET indice=$indice
            WHERE jour='$date' AND idChantier=$chantier AND  libelle='$name' AND engin=$id AND num=$num";
            $res = PdoGsb::$monPdo->query($req);
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function getLesCateg(){
           	$req = "SELECT *  FROM categorie";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function getLesIndice(){
           	$req = "SELECT * FROM indice";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function getIdFicheByDC($date,$chantier,$user){
 			$req="SELECT idFichePointage as id from pointage WHERE idChantier=$chantier AND jour ='$date' AND idSal=$user";
         	$res = PdoGsb::$monPdo->query($req);
         	$laLigne = $res->fetch();
			return $laLigne;
		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function delPointageSal($date,$idChantier,$id,$numba){
            $req="DELETE FROM pointage WHERE jour='$date' AND idChantier=$idChantier AND salarie=$id and numba=$numba";
            PdoGsb::$monPdo->query($req);
		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function delPointageEngin($date,$idChantier,$id,$lib,$num,$numba){
            $req="DELETE FROM pointagemateriel 
                WHERE jour='$date' 
                AND idChantier=$idChantier 
                AND engin=$id AND libelle='$lib' 
                AND num=$num AND numba=$numba";
            PdoGsb::$monPdo->query($req);
		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function getIdEngin($num,$name){
 			$req="SELECT id from engin WHERE numero=$num AND libelle ='$name'";
         	$res = PdoGsb::$monPdo->query($req);
         	$laLigne = $res->fetch();
			return $laLigne;
		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function addMAP($id,$msg,$day){
 			$req="INSERT INTO materiel_a_prevoir VALUES($id,'$msg','$day')";
         	$res = PdoGsb::$monPdo->query($req);

		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function addTAR($id,$msg,$day){
 			$req="INSERT INTO travaux VALUES($id,'$msg','$day')";
         	$res = PdoGsb::$monPdo->query($req);

		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function addPanne($id,$msg,$day){
 			$req="INSERT INTO panne VALUES($id,'$msg','$day')";
         	$res = PdoGsb::$monPdo->query($req);
		}
				/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
		public function getTravaux($id,$day){
           	$req = "SELECT * FROM travaux WHERE id=$id AND jour='$day'";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function getPannes($id,$day){
           	$req = "SELECT * FROM panne WHERE id=$id AND jour='$day'";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
      			/**
		*Pointe un salarié
		* @param $idFicheWeek
		* @param $idVisiteur
		* @param $idChantier
		* @param $day
		* @param $DebutD
		* @param $FinD
		* @param $DebutF
		* @param $FinF
		* @param $statut
		* @param $idUser
		* @param $coment
		* @param $numba
		*/
      	public function getMateriauxAP($id,$day){
           	$req = "SELECT * FROM materiel_a_prevoir WHERE id=$id AND jour='$day'";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
      	}
 /**
 * Recupere l'identifiant et la signature du chef de chantier(conducteur de travaux) qui a édité la fiche d'accueil securité
 * @param integer $idFiche Identifiant de la fiche 
 * @param date $date Date de la fiche
 * @return array Tableau associatif contenant l'identifiant et la signature du chef de chantier(conducteur de travaux) qui a édité la fiche
 */  
	public function getAnimateur($numfiche,$datefiche,$numba){
            $req = "SELECT fiche_pointage.jour as jour,fiche_pointage.idSal as id,fiche_pointage.signature as signature, salarie.nom as nom ,salarie.prenom as prenom FROM fiche_pointage,salarie WHERE fiche_pointage.idSal=salarie.id AND fiche_pointage.chantier=$numfiche AND fiche_pointage.jour='$datefiche'";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}
/**
 * Recupere l'identifiant et la signature du chef de chantier(conducteur de travaux) qui a édité la fiche d'accueil securité
 * @param integer $idFiche Identifiant de la fiche 
 * @param date $date Date de la fiche
 * @return array Tableau associatif contenant l'identifiant et la signature du chef de chantier(conducteur de travaux) qui a édité la fiche
 */  
	public function getOtherAnimateur($numfiche,$datefiche,$numba){
           	$req = "SELECT fiche_pointage.jour as jour,fiche_pointage.idSalValider as id,fiche_pointage.signature as signature,
            	salarie.nom as nom ,salarie.prenom as prenom 
            	FROM fiche_pointage,salarie 
            	WHERE fiche_pointage.idSalValider=salarie.id 
            	AND fiche_pointage.chantier=$numfiche 
            	AND fiche_pointage.jour='$datefiche'
            	AND fiche_pointage.numba=$numba";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
	}
/**
 * Cloture une fiche pointage
 * @param integer $idFiche Identifiant de la fiche 
 * @param date $date Date de la fiche
 * @param string $signature Signature du chef de travaux (conducteur de travaux) qui a édité la fiche d'accueil securité
 */        
	public function cloturer($idChantier,$date,$signature,$idSal){
        $req = "UPDATE fiche_pointage SET signature='$signature' 
        WHERE chantier= $idChantier AND jour='$date' AND idSal=$idSal";
        PdoGsb::$monPdo->query($req);
	}
	/**
 * Cloture une fiche pointage
 * @param integer $idFiche Identifiant de la fiche 
 * @param date $date Date de la fiche
 * @param string $signature Signature du chef de travaux (conducteur de travaux) qui a édité la fiche d'accueil securité
 */        
	public function cloturerBis($idChantier,$date,$signature,$idSal){
        $req = "UPDATE fiche_pointage SET signature='$signature' 
        WHERE chantier= $idChantier AND jour='$date' AND idSalValider=$idSal";
        PdoGsb::$monPdo->query($req);
	}
	/**
	*Retourne les meteos
	*/
	public function getMeteo(){
        $req = "SELECT * FROM meteo";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }
    /**
    *Ajoute une meteo 
    */
    public function addMeteo($idChantier,$meteo,$idSal,$day){
 		$req="UPDATE fiche_pointage SET meteo=$meteo WHERE chantier=$idChantier AND idSal=$idSal AND jour='$day'";
        $res = PdoGsb::$monPdo->query($req);

	}
	public function verifFicheValideBis($idChantier,$idSal,$day,$numba){
        $req = "SELECT signature  FROM fiche_pointage WHERE fiche_pointage.idSal=$idSal AND fiche_pointage.chantier=$idChantier AND fiche_pointage.jour='$day' AND numba=$numba";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
	}
	public function verifFicheValide($idChantier,$idSal,$day){
        $req = "SELECT signature  FROM fiche_pointage WHERE fiche_pointage.idSal=$idSal AND fiche_pointage.chantier=$idChantier AND fiche_pointage.jour='$day'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
	}
	public function addConsigne($id,$chantier,$jour,$idSal,$numVoie,$aitcD,$aitcF,$cCD,$cCF,$hD,$hF,$numba){
 		$req="INSERT INTO consigne VALUES($id,$chantier,'$jour',$idSal,'$numVoie','$aitcD','$aitcF','$cCD','$cCF','$hD','$hF',$numba)";
        $res = PdoGsb::$monPdo->query($req);
	}
	public function getLesConsigne($chantier,$jour,$numba){
        $req = "SELECT * FROM consigne WHERE chantier=$chantier AND jour='$jour' AND numba=$numba";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }
	public function purger(){
 		$req="DELETE FROM consigne VALUES($id,$chantier,'$jour',$idSal,'$numVoie','$aitcD','$aitcF','$cCD','$cCF','$hD','$hF')";
        $res = PdoGsb::$monPdo->query($req);
	}
/**
* Modifie un salariée
* @param integer $id Identifiant du salarié
* @param string $nom Nom du salarié
* @param string $prenom prenom du salarié
* @param integer $tauxHoraire taux horaire du salarié
*/
	public function alterSal($id,$nom,$prenom){
            $req = "UPDATE salarie SET nom='$nom',prenom='$prenom'  WHERE id=$id";  
            PdoGsb::$monPdo->query($req);
	}
/**
 * Modifie un chantier 
 * @param integer $id Identifiant du chantier
 * @param string $nom Nom du chantier 
 * @param integer $numNumero du chantier
 */        
	public function alterChant($id, $nom, $num){
            $req = "UPDATE chantier SET numero=$num ,libelle='$nom' WHERE id=$id";
            PdoGsb::$monPdo->query($req);
	}
/**
 * Supprime le chantier passé en parametre
 * @param integer $idChantier Identifant du chantier
 */         
    public function supChantier($idChantier){
           $req = "DELETE FROM chantier WHERE id =$idChantier";
           PdoGsb::$monPdo->query($req);
    }

/**
*Ajoute un chantier
* @param integer $id Identifiant du chantier
* @param integer $num Numéro du chantier
* @param string $libelle Nom du chantier
* @param integer $resp Identifiant du conducteur de travaux responsable du chantier
*/
      public function addGroup($id,$nom){
            $req = "INSERT INTO entreprise VALUES($id,'$nom')";  
            PdoGsb::$monPdo->query($req);
}/**
 * Supprime l'entreprise passé en parametre
 * @param integer $idChantier Identifant du chantier
 */         
         public function supGroup($id){
            $req = "DELETE FROM entreprise WHERE id =$id";
            PdoGsb::$monPdo->query($req);
         }
/**
 * Modifie une entreprise
 * @param integer $id Identifiant d'une entreprise
 * @param string $nom Nom d'une entreprise
 */        
      public function alterGroup($id, $nom){
            $req = "UPDATE entreprise SET raison='$nom' WHERE id=$id";
            PdoGsb::$monPdo->query($req);
      }
/**
* Selectionne l'identifiant du derniers theme enregistré
* @return array $laLigne Tableau associatif contenant l'identifiant du dernier
*/
      public function getLastGroup(){
            $req = "SELECT max(id) as id FROM theme";  
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
      }
/**
 * Ajoute un document à la base vie
 * @param integer $id Identifiant du document
 * @param string $libelle Libelle du document
 */
      public function addDoc($id,$libelle){
            $req = "INSERT INTO docbasevie VALUES($id,'$libelle')";
            PdoGsb::$monPdo->query($req);
      }
/**
 * Modifie un document à la base de vie
 * @param integer $id Identifiant du document à la base de vie
 * @param string $nom Nom du document à la base de vie
 */        
      public function alterDoc($id, $nom){
            $req = "UPDATE docbasevie SET libelle='$nom' WHERE id=$id";
            PdoGsb::$monPdo->query($req);
      }
 /**
 * Recupere l'identifiant du dernier document mis a disposition à la base vie 
 * @return array Tableau associatif contenant l'identifant du dernier document enregistré
 */        
	public function getLasOtherDoc(){
            $req = "SELECT max(id) as id FROM docbasevie";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
        }
/**
 * Recupere les document à la base vie
 * @return array $lesLignes Tableau associatif contenant les infos des document a la base vie
 */
	public function getLesdocBaseVie(){
            $req = "SELECT * FROM docbasevie";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
	}
/**
 * Supprime le document passé en parametre
 * @param integer $id Identifant du document
 */         
         public function supDoc($id){
            $req = "DELETE FROM docbasevie WHERE id =$id";
            PdoGsb::$monPdo->query($req);
         }
                  /**
 * Supprime le document passé en parametre
 * @param integer $id Identifant du document
 */         
    public function banirIp($ip){
            $req = "INSERT INTO ipbani VALUES('$ip')";
            PdoGsb::$monPdo->query($req);
    }
	public function delBani($ip){
            $req = "DELETE FROM ipbani WHERE adresse='$ip'";
            PdoGsb::$monPdo->query($req);
     }
     /**
     *Retourn les adresse ip banni
     */
    public function getLesBani(){
            $req = "SELECT * FROM ipbani";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
	}
	/**
	*Retourne l'identifiant d'une fiche pointage
	*@param $jour
	*@param $use
	*/
	public function verifFichePointage($jour,$user){
            $req = "SELECT DISTINCT id FROM fiche_pointage WHERE jour='$jour' AND idSal=$user";
            $res = PdoGsb::$monPdo->query($req);
            $laLigne = $res->fetch();
            return $laLigne;
     }
    /**
    *Retourne les pointages consignes du jour
    *@param $chantier
    *@param $jour
    *@param $idSal
    *@param $numba
    *@return les pointages consignes du jour 
    */
     public function getLesConsigneToday($chantier,$jour,$user,$numba){
            $req = "SELECT * FROM consigne WHERE idSal=$user AND jour='$jour' AND chantier=$chantier AND numba=$numba";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
     }
    /**
    *Retourne les pointages consignes par chantier et jour 
    *@param $chantier
    *@param $jour
    *@param $idSal
    *@return les pointages consignes par chantier et jour 
    */
     public function getLesConsigneByDay($chantier,$jour,$idSal){
            $req = "SELECT * FROM consigne WHERE jour='$jour' AND chantier=$chantier AND idSal=$idSal";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
    }
            /**
    *Retourne les pointages consignes par chantier et jour et numéro identifiant
    *@param $chantier
    *@param $jour
    *@param $idSal
    *@param $numba
    *@return les pointages consignes par chantier et jour et numéro identifiant
    */
    public function getLesConsigneByDayBis($chantier,$jour,$idSal,$numba){
            $req = "SELECT * FROM consigne 
            WHERE jour='$jour' 
            AND chantier=$chantier 
            AND idSal=$idSal 
            AND consigne.numba=$numba";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
    }
        /**
    *Retourne les pointages consignes par chantier et semaine
    *@param $chantier
    *@param $week
    *@param $idSal
    *@return le dernier matériel enregistré
    */
    public function getLesConsigneByWeek($chantier,$week,$idSal){
            $req = "SELECT * FROM consigne WHERE idFiche='$week' AND chantier=$chantier AND idSal=$idSal";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
    }    
    /**
    *Modifie une consigne
    * @param $voie
    * @param $jour
    * @param $idSal
    * @param $chantier
    * @param $aitcD
    * @param $aitcF
    * @param $cCD
    * @param $cCF
    * @param $hD
    * @param $hF
    */
    public function alterConsigne($voie,$jour,$idSal,$chantier,$aitcD,$aitcF,$cCD,$cCF,$hD,$hF){
            $req = "UPDATE consigne SET aitc1='$aitcD',aitc2='$aitcF',c_catenaire_debut='$cCD',c_catenaire_fin='$cCF',debutTravaux='$hD',finTravaux='$hF' 
            WHERE num_voie='$voie'
            AND idSal=$idSal
            AND jour='$jour'
            AND chantier=$chantier";
            PdoGsb::$monPdo->query($req);
    }
    /**
    *Supprime une consigne d'une fiche de pointage
    * @param $dayte
    * @param $idChantier
    * @param $voie
    */
    public function delConsigne($date,$idChantier,$voie){
        $req="DELETE FROM consigne
        WHERE jour='$date'
        AND chantier=$idChantier
        AND num_voie='$voie'";
        PdoGsb::$monPdo->query($req);
	}
    /**
    *Retourne les dates pour un chantier
    *@param $chantier
    *@return les dates
    */
	public function getYears($chantier){
            $req = "SELECT DISTINCT fiche_pointage.jour as jour
            FROM fiche_pointage
            WHERE fiche_pointage.chantier=$chantier 
            group by fiche_pointage.jour ASC";
            $res = PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
    }
    /**
    *Met a jour le validateur de la fiche
    *@param $jour
    *@param $chantier
    *@param $idSal
    */
    public function updateAnimateur($jour,$chantier,$idSal){
            $req = "UPDATE fiche_pointage SET idSalValider=$idSal
            WHERE jour='$jour'
            AND chantier=$chantier";
            PdoGsb::$monPdo->query($req);
    }
    /**
    *Verifie si une fiche pointage à été signé par une personne autre que le créateur de la fiche 
    *@param $chantier
    *@param $jour
    *@return l'identifiant du valideur
    */
    public function verifOdaAnimator($chantier,$jour){
           $req = "SELECT idSalValider as id
           FROM fiche_pointage
           WHERE jour='$jour'
           AND chantier=$chantier";
           $res = PdoGsb::$monPdo->query($req);
           $laLigne = $res->fetch();
           return $laLigne;
    }
    /**
    *Retourne la méteo d'une fiche de pointage
    *@param $chantier
    *@param $jour
    *@return la méteo d'une fiche de pointage
    */
        public function getMeteoPointage($chantier,$jour){
           $req = "SELECT meteo.libelle as meteo
           FROM fiche_pointage,meteo
            WHERE meteo.id=fiche_pointage.meteo
            AND jour='$jour'
            AND chantier=$chantier";
           $res = PdoGsb::$monPdo->query($req);
           $laLigne = $res->fetch();
           return $laLigne;
    }
        /**
    *Retourne les salariés d'une fiche de pointage
    *@param $chantier identifiant chantier
    *@param $jour Jour du chantuer
    *@return les salariés d'une fiche de pointage
    */
        public function getAllAnimator($chantier,$jour){
           $req = "SELECT salarie.id as id ,salarie.nom as nom ,salarie.prenom as prenom  
           FROM fiche_pointage,salarie 
           WHERE salarie.id = fiche_pointage.idSal 
           AND jour='$jour' 
           AND chantier=$chantier 
           group by nom DESC";
           $res = PdoGsb::$monPdo->query($req);
           $lesLignes = $res->fetchAll();
           return $lesLignes;
    }
    /**
    *Retourne le dernier matériel enregistré
    *@param $id
    *@param $lib
    *@return le dernier matériel enregistré
    */
    public function EnginAllReadySave($id,$lib){
           $req = "SELECT DISTINCT max(numero) as numero FROM engin WHERE id=$id AND libelle='$lib' ";
           $res = PdoGsb::$monPdo->query($req);
           $lesLignes = $res->fetchAll();
           return $lesLignes;
    }
    /**
    *Retourne les fiches selon un chantier et un jour
    * @param $chantier 
    * @param $day
    * @return  Retourne les fiches 
    */
    public function getLesFiche($chantier,$day){
            $req="SELECT DISTINCT numba as numero FROM pointage WHERE jour='$day' AND idChantier=$chantier";
            $res =PdoGsb::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
         }
  }