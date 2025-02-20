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
}
