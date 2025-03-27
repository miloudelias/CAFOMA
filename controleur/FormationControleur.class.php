<?php
require_once "modele/FormationDao.class.php";
require_once "modele/PartenaireDao.class.php";
require_once "modele/InscriptionDao.class.php";
require_once "modele/UtilisateurDao.class.php";
require_once "modele/RessourcesDao.class.php";
require_once "./outil/Outils.class.php";


class FormationControleur {
    private $formationDao;
    private $partenaireDao;
    private $inscriptionDao;
    private $utilisateurDao;
    private $ressourcesDao;
    
    public function __construct() {
        $this->formationDao = FormationDao::getInstance();
        $this->partenaireDao = PartenaireDao::getInstance();
        $this->inscriptionDao = InscriptionDao::getInstance();
        $this->utilisateurDao = UtilisateurDao::getInstance();
        $this->ressourcesDao = RessourcesDao::getInstance();
    }
    
    function afficherAccueil(){
        require "vue/accueil.view.php";
    }
    
    function afficherListe(){
        //echo "controleur";
        $alert = "";
        $formations=$this->formationDao->findAllFormation();
        require "vue/afficherListe.view.php";
    }
    
    function afficherFormation($id){
        if (Securite::isConnected() || Securite::verifAccessPartenaire()) {
            $formation=$this->formationDao->findOneFormationById($id);
            require "vue/afficherFormation.view.php";
        }
    }
    
    function detailFormation($id){
        $formation=$this->formationDao->findOneFormationById($id);
        require "vue/detailFormation.view.php";
    }
    
    function creerFormation(){ 
        if(Securite::verifAccessPartenaire()|| Securite::verifAccessAdmin()){
            $partenaireList = $this->partenaireDao->findAllPartenaire();
            require "vue/creerformation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    
    function creerValidationFormation($nom, $type, $description, $contenu, $duree, $niveau, $mode, $file, $ressources, $idPart){
        if(Securite::verifAccessPartenaire()|| Securite::verifAccessAdmin()){
            echo "controleur";
         $file = $_FILES['image'];
            $repertoire = "public/images/";
            $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            
         $ressources = [];
            if (!empty($_FILES['ressources']['name'][0])) { // Vérifier s'il y a des fichiers
                foreach ($_FILES['ressources']['name'] as $key => $nomFichier) {
                    $tmpName = $_FILES['ressources']['tmp_name'][$key];
                    $typeFichier = $_FILES['ressources']['type'][$key];

                    $directory = "public/fichiers/";
                    $nomFichierAjoute = Outils::ajouterFichiers([
                        'name' => $nomFichier,
                        'tmp_name' => $tmpName
                    ], $directory);

                    $ressources[] = [
                        "nomFichier" => $nomFichierAjoute,
                        "typeFichier" => $typeFichier
                    ];
                }
            
                $this->formationDao->creerFormation($nom, $type ,$description, $contenu, $duree, $niveau, $mode, $nomImageAjoute, $ressources, $idPart);
            
                $_SESSION['success_message'] = "La formation '$nom' a été créée avec succès !";
                if(Securite::verifAccessAdmin()){
                    header("Location: index.php?action=administrer-formations");
                } else {
                    header("Location: index.php?action=admin-formations-part");
                }
                
            }
        else throw new Exception("Vous n'avez pas les droits nécessaires");
        }
    }    

    function administrerAllFormations() {
        if (Securite::verifAccessAdmin()) {
            $tabFormations = $this->formationDao->findAllFormation();
            require "vue/administrerFormations.view.php";
        }    
    }
    
    function modifierFormation($id){
        if(Securite::verifAccessAdmin() || Securite::verifAccessPartenaire()){
            $formation= $this->formationDao->findOneFormationById($id);
            Outils::afficherTableau($formation, "modif formation controleur");
            require "vue/modifierFormation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    
    function modifierFormationValidation($id, $nom,  $type, $description, $contenu, $duree, $niveau, $mode, $file, $fichier) {
        if(Securite::verifAccessAdmin() || Securite::verifAccessPartenaire()) {
            Outils::afficherTableau($_POST, "POST");
            echo "Modifier VALIDATION FORMATION id<br>";
            
            $repertoire = "public/images/";
            $file = $_FILES['image'];
            Outils::afficherTableau($file, "file");
 
            if (!empty($_FILES['image']['name']) && $_FILES['image']['size'] > 0) {
            if (!empty($image) && file_exists($repertoire . $image)) {
                unlink($repertoire . $image); // Supprime l'ancienne image
            }
            $nomImageAjoute = Outils::ajouterImage($_FILES['image'], $repertoire);
        }
            
            $directory = "public/fichiers/";
            $fichier = $_FILES['fichiers'];
            Outils::afficherTableau($fichier, "fichier");
            
            
            
           

        // === MISE À JOUR EN BASE DE DONNÉES ===
        $this->formationDao->modifierFormation($id, $nom, $type, $description, $contenu, $duree, $niveau, $mode, $nomImageAjoute, $fichiersJson);

        $_SESSION['success_message'] = "La formation '$nom' a été mise à jour avec succès !";
        header("Location: index.php?action=afficher-liste");
        exit;  
        }
        else throw new Exception ("Vous n'avez pas les droits nécessaires");
    }
    
    function supprimerFormation($id){
        if(Securite::verifAccessAdmin() || Securite::verifAccessPartenaire()){
            if(/*!$this->inscriptionDao->isExistInscritByIdFormation($id)*/1){
                $nomImage = $this->formationDao->findOneFormationById($id)->getImage();
                $this->formationDao->supprimerFormation($id);
                unlink("public/images/".$nomImage);
                header("Location: index.php?action=administrer-all-formations");
            }
            else throw new Exception ("Impossible de supprimer la formation car il y a des inscrits");
        }
        else throw new Exception ("Vous n'avez pas le droit d'accéder à cette page");
    }
    
   
    
     function adminFormationsPart() {
        if(Securite::verifAccessPartenaire() || Securite::verifAccessAdmin()) {
            $login = $_SESSION['login']; 
            $idPartenaire = $this->utilisateurDao->getIdPartByLogin($login);

            $formations = $this->formationDao->findAllFormationsByUserPart($idPartenaire);
            require "vue/adminFormationsPart.view.php";
        }
        else throw new Exception ("Vous n'avez pas le droit d'accéder à cette page");
    }
}
