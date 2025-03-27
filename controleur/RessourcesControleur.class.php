<?php
require_once "modele/RessourcesDao.class.php";


class RessourcesControleur {
    private $ressourcesDao;
    
    public function __construct() {
        $this->ressourcesDao = RessourcesDao::getInstance();
    }
    
    public function afficherRessourcesFormation($idFormation) {
        $ressources = $this->ressourcesDao->findAllRscByFormation($idFormation);
        require "vue/afficherFormation.view.php";
    }
    
    public function ajouterRessource($nomFichier, $typeFichier, $idFormation) {
        $this->ressourcesDao->addRessource($nomFichier, $typeFichier, $idFormation);
    }
    
}
