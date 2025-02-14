<?php
require_once "controleur/FormationControleur.php";

session_start();
$formationControleur = new FormationControleur();

try{
    if(empty($_GET['action']) || !isset($_GET['action'])){
        $formationControleur->afficherAccueil();
    }
} catch (Exception $ex) {
    $title = "Erreur";
    $erreurMsg = $ex->getMessage();
    require "vue/erreur.view.php";       
}

