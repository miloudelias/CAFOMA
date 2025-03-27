<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";

class InscriptionDao extends Connexion {
    private static $_instance = null;
    private $formationDao;
    
    private function __construct() {
        $this->formationDao = formationDao::getInstance();
    }
    
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new InscriptionDao();
        }
        return self::$_instance;
    }
    
    public function findAllInscription(){
        $stmt = $this->getBdd()->prepare(
                "SELECT * FROM inscription");
        $nb = $stmt->execute();
        $inscriptionListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if (isset($inscriptionListBd)){
            foreach($inscriptionListBd as $inscriptionBd){
                $inscription = new Inscription($inscriptionListBd['idFormation'], $inscriptionListBd['login'], $inscriptionListBd['dateInscription']);
                $inscriptions[] = $inscription;
            }
            return $formations;
        }
    }
    
    public function findAllInscriptionByLogin($login){
        $stmt = $this->getBdd()->prepare(
                "SELECT idFormation, login, idInscription, dateInscription, nom "
                . " FROM inscription "
                . " JOIN formation ON inscription.idFormation = formation.id "
                . " WHERE login = :login");
        $stmt->bindValue(":login", $login, PDO::PARAM_INT);
        $nb = $stmt->execute();
        $inscriptionListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $inscriptionList = array();
        foreach ($inscriptionListBd as $inscriptionBd){
            $inscription = new Inscription($inscriptionBd['idFormation'], $inscriptionBd['login']);
            $inscription->setIdInscription($inscriptionBd['idInscription']);
            $inscription->setDateInscription($inscriptionBd['dateInscription']);
            
            $formation = $this->formationDao->findOneFormationById($inscriptionBd['idFormation']);
            //echo "FormationDao - findAllFormation - f=".$f." formation[idFormation]=.$formation['idFormation']."<br>";
            $inscription->setFormation($formation);
            $inscriptionList[]=$inscription;
        }
        //Outils::afficherTableau($inscriptionList, "Liste inscription");
        return $inscriptionList;
    }
    
    public function findOneInscriptionById($idInscription) {
        $stmt = $this->getBdd()->prepare(
             "SELECT * FROM inscription WHERE idInscription = :idInscription");
        $stmt->bindValue(":idInscription", $idInscription, PDO::PARAM_INT);
        $nb = $stmt->execute();
        $inscriptionBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        //afficherTableau($formationBd, "findFormationByIdFormation formationBd");
        $inscription = new Inscription($inscriptionBd['idFormation'], $_SESSION['login']);
        $inscription->setIdInscription($inscriptionBd['idInscription']);
        $inscription->setDateInscription($inscriptionBd['dateInscription']);
        return $inscription;
    }
    
    public function creerInscription($inscription) {
       // echo "creerInscription inscription=". $inscription."<br>";
        $pdo = $this->getBdd();
        $req = "
                INSERT INTO inscription (idFormation, login, dateInscription)
                VALUES (:idFormation, :login, :dateInscription)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idFormation", $inscription->getIdFormation(), PDO::PARAM_INT);
        $stmt->bindValue(":login", $inscription->getLogin(), PDO::PARAM_STR);
        $stmt->bindValue(":dateInscription", $inscription->getDateInscription(), PDO::PARAM_STR);
        $nb = $stmt->execute();
        $stmt->closeCursor();
        if($nb > 0){
            return $pdo->lastInsertId();
        }
        return false;   
    }
    
    function supprimerInscription($idInscription) {
        $stmt = $this->getBdd()->prepare("DELETE FROM inscription WHERE idInscription = :idInscription");
        $stmt->bindValue(":idInscription", $idInscription, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    
    
}
