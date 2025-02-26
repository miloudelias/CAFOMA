<?php
require_once "modele/FormationDao.class.php";
require_once "./outil/Outils.class.php";


class FormationControleur {
    private $formationDao;
    private $partenaireDao;
    
    public function __construct() {
        $this->formationDao = FormationDao::getInstance();
        $this->partenaireDao = PartenaireDao::getInstance();
    }
    
    function afficherAccueil(){
        require "vue/accueil.view.php";
    }
    
    function afficherListe(){
        $alert = "";
        $formations=$this->formationDao->findAllFormation();
        require "vue/afficherListe.view.php";
    }
    
    function afficherFormation($id){
        $formation=$this->formationDao->findOneFormationById($id);
        require "vue/afficherFormation.view.php";
    }
    
    function creerFormation(){ 
        if(/*Securite::verifAccessPartenaire()*/1){
            $partenaireList = $this->partenaireDao->findAllPartenaire();
            require "vue/creerformation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    
    function creerValidationFormation($nom,$type ,$description, $contenu, $partenaire_id){
        if(/*Securite::verifAccessPartenaire()*/1){
            echo "controleur";
         $file = $_FILES['image'];
            $repertoire = "public/images/";
            $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            
         $fichier = $_FILES['fichiers'];
            $directory = "public/fichiers/";
            
            $nomFichierAjoute = Outils::ajouterFichiers($fichier,$directory);
            $nomFichiersAjoute[] = $nomFichierAjoute;
            
            $fichiersJson = json_encode($nomFichiersAjoute);
            
            $this->formationDao->creerFormation($nom, $type ,$description, $contenu,$nomImageAjoute, $fichiersJson, $partenaire_id);
            
            $_SESSION['success_message'] = "La formation '$nom' a été créée avec succès !";
             //header("Location: index.php?action=administrer-formations");
            header("Location: index.php?action=afficher-liste");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }

    function administrerFormations() {
        if (Securite::isConnected() && isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $idPart = $user->getIdPart(); // Récupération de l'ID du partenaire

            // Récupérer toutes les formations du partenaire
            $tabFormations = $this->formationDao->findFormationsByPartenaire($idPart);

            // Charger la vue correspondante
            require "vue/administrerFormations.view.php";
        } /*else {
        header("Location: index.php?action=login"); // Redirection si non connecté
        exit();
        }*/
    }
    
}
