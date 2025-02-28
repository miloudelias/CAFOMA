<?php
require_once "Connexion.class.php";
require_once "Partenaire.class.php";
require_once "./outil/Outils.class.php";

class PartenaireDao extends Connexion {
    private static $_instance = null;
    
    private function __construct() {

    }
    
    public static function getInstance() {
        if(is_null(self::$_instance)){
            self::$_instance = new PartenaireDao();
        }
        return self::$_instance;
    }
    
     public function findAllPartenaire(){
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM partenaire");
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $partenaireListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($partenaireListBd as $partenaireBd){
            $partenaire = new Partenaire($partenaireBd['nom'], $partenaireBd['description']);
            //echo "FormationDao - findAllFormation - f=".$f." formation[idFormation]=".$formation['idFormation']."<br>";
            $partenaire->setIdPart($partenaireBd['idPart']);
            $partenaireList[]=$partenaire;
        }
        return $partenaireList;
    }
    
    function findPartenaireByIdPart($idPart){ 
        //echo "idPart=".$idPart."<br>";
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM partenaire WHERE idPart = :idPart");
        $stmt->bindValue(":idPart",$idPart,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $partenaireBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        //Outils::afficherTableau($partenaireBd, "findPartenaireByIdPart partenaireBd");
        $partenaire = new Partenaire($partenaireBd['nom'], $partenaireBd['description']);
        $partenaire->setIdPart($partenaireBd['idPart']);
        return $partenaire;
    }
          
}
