<?php
require_once "modele/FormationDao.class.php";
require_once "modele/PartenaireDao.class.php";
require_once "./outil/Outils.class.php";


class PartenaireControleur {
    private $formationDao;
    private $partenaireDao;
    
    public function __construct() {
        $this->formationDao = FormationDao::getInstance();
        $this->partenaireDao = PartenaireDao::getInstance();
    }
    
    public function lirePartenaire($idPartenaire){
        //echo "Controleur ";
        try {
            $partenaire = $this->partenaireDao->findPartenaireByIdPartenaire($idPartenaire);
            $formationList = $this->formationDao->findFormationsByPartenaire($idPartenaire);
            //Outils::afficherTableau($formationList, "formations");
            require "vue/afficherPartenaire.view.php";
        } catch (Exception $ex) {
            echo "Erreur : " . $ex->getMessage();
        }
    }
    
    public function voirPartenaire($idPartenaire){
        //echo "Controleur ";
        try {
            $partenaire = $this->partenaireDao->findPartenaireByIdPartenaire($idPartenaire);
            $formationList = $this->formationDao->findFormationsByPartenaire($idPartenaire);
            //Outils::afficherTableau($formationList, "formations");
            require "vue/voirPartenaire.view.php";
        } catch (Exception $ex) {
            echo "Erreur : " . $ex->getMessage();
        }
    }  

    
    function creerPartenaire(){
        require "vue/creerPartenaire.view.php";
    }
    
    public function creerPartenaireValidation($nom, $description){
        if(isset($_POST['nom']) && isset($_POST['description'])) {
            $this->partenaireDao->creerPartenaire($nom, $description);
            $_SESSION['success_message'] = "Le partenaire '{$_POST['nom']}' a été ajouté avec succès.";
            header("Location: index.php?action=gerer-partenaire");
        } else {
            echo "Erreur : Tous les champs doivent être remplis.";
        }
    }
    
    function gererPartenaire(){
        if(Securite::verifAccessAdmin()){
            $users = $this->partenaireDao->findAllPartenaire();
            require "vue/gererPartenaire.view.php";
        }
        else { 
            throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
        }    
    }
    
    function modifierPartenaire($idPartenaire){
        if(Securite::verifAccessAdmin()){
            $partenaire= $this->partenaireDao->findPartenaireByIdPartenaire($idPartenaire);
            //Outils::afficherTableau($partenaire, "modif partenaire controleur");
            require "vue/modifierPartenaire.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    
    function modifierPartenaireValidation($idPartenaire, $nom, $description){
        if(Securite::verifAccessAdmin()){
            Outils::afficherTableau($_POST, "POST");
            echo "Modifier VALIDATION PARTENAIRE id<br>";
        $this->partenaireDao->modifierPartenaire($idPartenaire, $nom, $description);

        $_SESSION['success_message'] = "Le partenaire '$nom' a été mise à jour avec succès !";
        header("Location: index.php?action=gerer-partenaire");
        exit;  
        }
        else throw new Exception ("Vous n'avez pas les droits nécessaires");
    }
    
}
