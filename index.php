<?php
require_once "controleur/FormationControleur.class.php";
require_once "outil/Securite.class.php";
require_once "outil/Outils.class.php";

session_start();
$formationControleur = new FormationControleur();

try{
    if(empty($_GET['action']) || !isset($_GET['action'])){
        $formationControleur->afficherAccueil();
    }
    else switch ($_GET['action']){
        case "afficher-liste": $formationControleur->afficherListe();
            break;
        
        case "afficher-formation": $formationControleur->afficherFormation($_GET['id']);
            break;
        
        case "creer-formation": $formationControleur->creerFormation();
            break;
        
        case "creer-formation-validation": 
            $formationControleur->creerValidationFormation(
            $_POST['nom'],
            $_POST['type'],
            $_POST['description'],
            $_POST['contenu'],
            $_FILES['image'],
            $_FILES['fichiers'],
            $_POST['idPart']
        );
        break;

        case "supprimer-formation":  $formationControleur->supprimerFormation($_GET['id']);
            break;
        
        case "administrer-formations":  $formationControleur->administrerFormations();
            break;
        
        case "supprimer-formations":  $formationControleur->supprimerFormations($_GET['idPart']);
        break;
    }
} catch (Exception $ex) {
    $title = "Erreur";
    $erreurMsg = $ex->getMessage();
    require "vue/erreur.view.php";       
}

