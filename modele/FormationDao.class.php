<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";
require_once "PartenaireDao.class.php";
require_once "outil/Outils.class.php";


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
        //echo " DAO";
        $stmt = $this->getBdd()->prepare("SELECT * FROM formation");
        $stmt->execute();
        $bddFormations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Outils::afficherTableau($bddFormations, "formations");
        $stmt->closeCursor();
        foreach($bddFormations as $formation){
            //echo "idpart:".$formation['IdPart'];
            $f=new Formation($formation['id'], $formation['nom'], $formation['type'], $formation['description'], $formation['contenu'], $formation['duree'], $formation['niveau'], $formation['mode'], $formation['image'], $formation['fichiers']);
            $partenaire = $this->partenaireDao->findPartenaireByIdPartenaire($formation['IdPart']);
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
        $f=new Formation($formation['id'], $formation['nom'], $formation['type'],$formation['description'], $formation['contenu'],$formation['duree'], $formation['niveau'], $formation['mode'], $formation['image'], $formation['fichiers']);
        
        $partenaire = $this->partenaireDao->findPartenaireByIdPartenaire($formation['IdPart']);
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
    
    function creerFormation($nom, $type, $description, $contenu, $duree, $niveau, $mode, $image, $fichiers, $IdPart){
        echo("DAO");
        $pdo = $this->getBdd();
        $req= "INSERT INTO formation(nom, type, description, contenu, duree, niveau, mode, image, fichiers, IdPart)
               values (:nom, :type ,:description, :contenu, :duree, :niveau, :mode, :image, :fichiers, :IdPart)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":type",$type,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":contenu",$contenu,PDO::PARAM_STR);
        $stmt->bindValue(":duree", $duree, PDO::PARAM_INT);
        $stmt->bindValue(":niveau", $niveau, PDO::PARAM_STR);
        $stmt->bindValue(":mode", $mode, PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":fichiers",$fichiers,PDO::PARAM_STR);
        $stmt->bindValue(":IdPart",$IdPart,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "formation insérer id=".$pdo->lastInsertId()."<br>";
        } 
    }
    
    public function findFormationsByPartenaire($IdPart){
        $stmt = $this->getBdd()->prepare(
              "SELECT * FROM formation WHERE IdPart = :IdPart"
        );
        $stmt->bindValue(":IdPart", $IdPart, PDO::PARAM_INT);
        $stmt->execute();
        
        $formationListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        //Outils::afficherTableau($formationListBd, "formationListBd");
        if(!empty($formationListBd)) {
            $formationList = [];
            foreach ($formationListBd as $formationBd) {
                $formation = new Formation(
                $formationBd['id'],
                $formationBd['nom'], 
                $formationBd['type'], 
                $formationBd['description'], 
                $formationBd['contenu'],
                $formationBd['duree'],
                $formationBd['niveau'],
                $formationBd['mode'],        
                $formationBd['image'], 
                $formationBd['fichiers'], 
                $formationBd['IdPart']
            );
            $formation->setId($formationBd['id']);
            $formationList[] = $formation;
            }
            return $formationList;
        } else {
            return null;
        }
    }
    
}

