<?php
require_once "controleur/FormationControleur.class.php";
require_once "controleur/UserControleur.class.php";
require_once "controleur/PartenaireControleur.class.php";
require_once "outil/Securite.class.php";
require_once "outil/Outils.class.php";

session_start();
$formationControleur = new FormationControleur();
$userControleur = new UserControleur();
$partenaireControleur = new PartenaireControleur();

try{
    if(empty($_GET['action']) || !isset($_GET['action'])){
        $formationControleur->afficherAccueil();
    }
    else switch ($_GET['action']){
        case "afficher-liste": $formationControleur->afficherListe();
            break;
        
        case "afficher-formation": $formationControleur->afficherFormation($_GET['id']);
            break;
        
        case "detail-formation": $formationControleur->detailFormation($_GET['id']);
            break;
        
        case "creer-formation": $formationControleur->creerFormation();
            break;
        
        case "creer-formation-validation": 
            /*Outils::afficherTableau($_FILES['image'],"image");
            Outils::afficherTableau($_FILES['fichiers'],"fichiers");
            var_dump($_POST['nom']." ".
            $_POST['type']." ".
            $_POST['description']." ".
            $_POST['contenu']." ".
            $_POST['duree']." ".
            $_POST['niveau']." ".
            $_POST['mode']." ".
            $_POST['idPart'] );
            exit;*/
            $formationControleur->creerValidationFormation(
            $_POST['nom'],
            $_POST['type'],
            $_POST['description'],
            $_POST['contenu'],
            $_POST['duree'],
            $_POST['niveau'],
            $_POST['mode'],
            $_FILES['image'],
            $_FILES['fichiers'],
            $_POST['idPart']        
        );
            break;

        case "supprimer-formation":  $formationControleur->supprimerFormation($_GET['id']);
            break;
        
        case "administrer-all-formations":  $formationControleur->administrerFormations();
            break;
        
        case "supprimer-formations":  $formationControleur->supprimerFormations($_GET['idPart']);
            break;
        
        case "login": $userControleur->login();
            break;
        
        case "login-validation": $userControleur->loginValidation($_POST['login'], $_POST['password']);
            break;
        
        case "afficher-profil": $userControleur->afficherProfil();
            break;
        
        case "logout": $userControleur->logout();
            break;
        
        case "register": $userControleur->creerCompte();
            break;
        
        case "creer-etudiant-validation": $userControleur->creerEtudiantValidation($_POST['login'], $_POST['mail'], $_POST['password'], $_POST['nom'], $_POST['prenom']);
            break;
        
        case "supprimer-etudiant": $userControleur->supprimerCompteEtudiant();
        
        case "valider-user": $userControleur->recevoirMailUserValidation($_GET['login'], $_GET['cle']);
            break;
        
        case "administrer-utilisateur": $userControleur->administrerUtilisateur();
            break;
        
        case "modifier-user": $userControleur->modifierUser();
            break;
        
        
        case "creer-user-partenaire": $userControleur->creerComptePart();
            break;
        
        case "creer-user-partenaire-valid": $userControleur->creerPartenaireValidation($_POST['login'], $_POST['mail'], $_POST['password'], $_POST['nom'], $_POST['prenom']);
            break;
        
        case "creer-partenaire": $partenaireControleur->creerPartenaire();
            break;
        
        case "creer-partenaire-validation": $partenaireControleur->creerPartenaireValidation($_POST['nom'], $_POST['description']); 
            break;
        
        case "afficher-partenaire": $partenaireControleur->lirePartenaire($_GET['idPart']);
            break;
        
        case "gerer-partenaire": $partenaireControleur->gererPartenaire();
            break;
        
    }
} catch (Exception $ex) {
    $title = "Erreur";
    $erreurMsg = $ex->getMessage();
    require "vue/erreur.view.php";       
}

