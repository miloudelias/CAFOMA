<?php
require_once "Connexion.class.php";
require_once "Ressources.class.php";

class RessourcesDao extends Connexion {
     private static $_instance = null;
    
    private function __construct() {}
    
    public static function getInstance() {
        if(is_null(self::$_instance)){
            self::$_instance = new RessourcesDao();
        }
        return self::$_instance;
    }
    
    public function findAllRscByFormation($idFormation) {
        $stmt = $this->getBdd()->prepare("SELECT * FROM ressources WHERE idFormation = :idFormation");
        $stmt->bindValue(":idFormation", $idFormation, PDO::PARAM_INT);
        $stmt->execute();
        $ressources = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        $result = [];
        
        foreach ($ressources as $res){
            $result[] = new Ressources($res['idRessource'], $res['nomFichier'], $res['typeFichier'], $res['idFormation']);
        }
        return $result;
    }
    
    public function addRessource($nomFichier, $typeFicher, $idFormation){
        $stmt = $this->getBdd()->prepare("
                INSERT INTO ressources (nomFichier, typeFichier, idFormation)
                VALUES (:nomFichier, :typeFichier, :idFormation)");
        $stmt->bindValue(":nomFichier", $nomFichier, PDO::PARAM_STR);
        $stmt->bindValue(":typeFichier", $typeFicher, PDO::PARAM_STR);
        $stmt->bindValue(":idFormation", $idFormation, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if ($resultat > 0){
            echo "ressource insérer id=".$pdo->lastInsertId()."<br>";
        }
    }
    
     
}
