<?php
require_once "modele/FormationDao.class.php";
require_once "./outil/Outils.class.php";
require_once "modele/InscriptionDao.class.php";
require_once "modele/Inscription.class.php";

class InscriptionControleur {
    private $inscriptionDao;
    private $formationDao;
    
    public function __construct() {
        $this->inscriptionDao = InscriptionDao::getInstance();
        $this->formationDao = FormationDao::getInstance();
    }
    
   /*public function validerMesInscriptions() {
        echo date('Y-m-d H:i:s');
        if (isset($_SESSION['formations'])){
            $login = $_SESSION['login'];
            foreach ($_SESSION['formations'] as $idFormation) {
                $inscription = new Inscription($idFormation, $login);
                $inscription = $this->inscriptionDao->creerInscription($inscription);
            }
            unset($_SESSION['formations']);
            header ("Location: index.php?action=afficher-inscriptions");
        } else {
            header ("Location : index.php?action=afficher-liste");
        }   
    }*/
    
    public function listerMesInscriptions(){
        $alert="";
        $login = $_SESSION['login'];
        $inscriptionList = $this->inscriptionDao->findAllInscriptionByLogin($login);
        //Outils::afficherTableau($inscriptionList, "inscriptionList");
        if(isset($inscriptionList) && !empty($inscriptionList)){
            require "vue/listerInscriptionsFormation.view.php";
        } else {
            $alert="Vous êtes inscrit à aucune formation, sélectionnez en dans le catalogue";
            require "vue/listerInscriptionsFormation.view.php";
        }
    }
    
 
    
    function ajouterFormationInscriptions($id){ // ajout 
        if (Securite::isConnected()) {
        $alert="";
        if(!isset($_SESSION['formations'])){
            $_SESSION['formations'] = array();
        }
        if(in_array($id, $_SESSION['formations'])){
            //echo $id." est déjà suivie<br>";
            throw new Exception("Vous êtes déjà inscrit(e) à cette formation");
        }
        else {
            $_SESSION['formations'][]=$id;
            $login = $_SESSION['login'];
            //echo $id." ".$login;
            
            $formation = $this->formationDao->findOneFormationById($id);
            $nomFormation = $formation ? $formation->getNom() : "cette formation";
            
            $inscription = new Inscription($id, $login);
            $this->inscriptionDao->creerInscription($inscription);
            //Outils::afficherTableau($inscription, "inscription controleur");
            $alert = "Vous vous êtes bien inscrit à la formation '$nomFormation'.";
            $_SESSION['alert'] = $alert;
            header("Location: index.php?action=afficher-liste");
        }
        //Outils::afficherTableau($_SESSION['formations'],"SESSION['formations']");
        //header("Location: index.php?action=afficher-liste");
        }
    }
    
    function annulerInscription($idInscription) {
        if (Securite::isConnected()) {
            // Vérifier si l'inscription existe
            $inscription = $this->inscriptionDao->findOneInscriptionById($idInscription);
        
        if (!$inscription) {
            $_SESSION['alert'] = "L'inscription que vous tentez de supprimer n'existe pas.";
        } else {
            $this->inscriptionDao->supprimerInscription($idInscription);
            $_SESSION['alert'] = "Votre inscription a bien été annulée.";
        }

        // Redirection après suppression
        header("Location: index.php?action=lister-inscriptions");
        exit();
    }
}

 
}
