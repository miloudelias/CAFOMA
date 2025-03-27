<?php
require_once "Connexion.class.php";
require_once "Partenaire.class.php";
require_once "./outil/Outils.class.php";

class PartenaireDao extends Connexion {
    private static $_instance = null;
    
    private function __construct() {}
    
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
            $partenaire->setIdPartenaire($partenaireBd['idPartenaire']);
            $partenaireList[]=$partenaire;
        }
        return $partenaireList;
    }
    
    function findPartenaireByIdPartenaire($idPartenaire){ 
        //echo "idPartenaire=".$idPartenaire."<br>";
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM partenaire WHERE idPartenaire = :idPartenaire");
        $stmt->bindValue(":idPartenaire",$idPartenaire,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $partenaireBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($partenaireBd) {
       // Outils::afficherTableau($partenaireBd, "findPartenaireByIdPartenaire partenaireBd");
        $partenaire = new Partenaire($partenaireBd['nom'], $partenaireBd['description']);
        $partenaire->setIdPartenaire($partenaireBd['idPartenaire']);
        return $partenaire;
        } else {
        // Gérer le cas où aucun partenaire n'est trouvé
        throw new Exception("Partenaire non trouvé pour l'id: $idPartenaire");
    }
    }
    
    public function creerPartenaire($nom, $description){
        $pdo = $this->getBdd();
        $req = "INSERT INTO partenaire (nom, description)
                values (:nom, :description)";
        
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
       $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $resultat= $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "partenaire insérer id=".$pdo->lastInsertId()."<br>";
        }
    }
    
     function modifierPartenaire($idPartenaire, $nom, $description){
            $pdo = $this->getBdd();
            $req = "UPDATE partenaire
                    SET nom = :nom, description = :description
                    WHERE idPartenaire = :idPartenaire";
            $stmt = $pdo->prepare($req);
            $stmt->bindValue(":idPartenaire", $idPartenaire, PDO::PARAM_INT);
            $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindValue(":description", $description, PDO::PARAM_STR);

            $resultat = $stmt->execute();
            $stmt->closeCursor();

            if($resultat > 0){
                echo "partenaire modifier id=".$id."<br>";
            }
    }
    
    function supprimerPartenaire($idPartenaire){
        $pdo = $this->getBdd();
        
        $req = "Delete from formation where idPartenaire = :idPartenaire";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idPartenaire",$idPartenaire,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "partenaire supprimer id=".$id."<br>";
        }
    }
    
        
}
