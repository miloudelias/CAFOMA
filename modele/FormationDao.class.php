<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";
require_once "PartenaireDao.class.php";


class FormationDao extends Connexion {
    private static $_instance = null;
    private $partenaireDao;
    
    private function __construct() {
        $this->partenaireDao = partenaireDao::getInstance();        
    }
    
    public static function getInstance() {
        if(is_null(self::$_instance)){
            self::$_instance = new FormationDao();
        }
        return self::$_instance;
    }
    
    public function getFormations(){
        return $this->formations;
    }
    
    function findAllFormation(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM formation");
        $stmt->execute();
        $bddFormations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddFormations as $formation){
            $f=new Formation($formation['id'], $formation['nom'], $formation['type'], $formation['description'], $formation['contenu'], $formation['image'], $formation['fichiers']);
            $partenaire = $this->partenaireDao->findPartenaireByIdPart($formation['partenaire_id']);
            $f->setPartenaire($partenaire);
            $formations[]=$f;
        }
        return $formations;
    }
    
    function findOneFormationById($id){
        $stmt = $this->getBdd()->prepare("SELECT * FROM formation WHERE id=:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $formation = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        //echo "id=".$id."<br>";
        $f=new Formation($formation['id'], $formation['nom'], $formation['type'],$formation['description'], $formation['contenu'], $formation['image'], $formation['fichiers']);
        
        $partenaire = $this->partenaireDao->findPartenaireByIdPart($formation['partenaire_id']);
        $f->setPartenaire($partenaire);
        
        
        return $f;
    }
    
    function supprimerFormation($id){
        $pdo = $this->getBdd();
        
        $req = "Delete from formation where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "formation supprimer id=".$id."<br>";
        }
    }
    
    function creerFormation($nom, $type, $description, $contenu, $image, $fichiers){
        echo("DAO");
        $pdo = $this->getBdd();
        $req= "INSERT INTO formation(nom, type, description, contenu, image, fichiers)
               values (:nom, :type ,:description, :contenu, :image, :fichiers)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":type",$type,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":contenu",$contenu,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":fichiers",$fichiers,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "formation insérer id=".$pdo->lastInsertId()."<br>";
        } 
    }
    
    
}

