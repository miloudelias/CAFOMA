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
        $bddLivres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddLivres as $formation){
            $f=new Formation($formation['id'], $formation['nom'], $formation['description'], $formation['type'], $formation['image'], $formation['fichiers']);
            $partenaire = $this->partenaireDao->findPartenaireByIdPart($formation['partenaire_id']);
            $f->setPartenaire($partenaire);
            $formations[]=$f;
        }
        return $formations;
    }
}

