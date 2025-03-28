<?php
    require_once "outil/Securite.class.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
    <title><?php echo $titre ?></title>
</head>
<div class="container">
    <h1 class="relief">CAFOMA<br>
        <a href="index.php" class="logo">
            <img src="public/images/CAFOMA.png" alt="Logo de l'application">
        </a>
    </h1>
    <h1 class="relief">Plateforme d'e-learning</h1>
</div>
<br>
<!-- https://getbootstrap.com/docs/5.3/components/navs-tabs/ -->
<div class="container">
    <div class="row">
        <div class="col-11">
            <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=afficher-liste">Liste des Formations</a> <?php ?>
                </li>
                <li class="nav-item">
                    <?php if(!Securite::isConnected()){ //si user est pas connecté ?>
                    <a class="nav-link disabled" aria-disabled="true">Mes formations suivies</a>
                    <?php } else { //si il est connecté ?>
                    <a class="nav-link" href="index.php?action=lister-inscriptions">Mes formations suivies</a> 
                    <?php }?> 
                </li>
                <li class="nav-item">
                    <?php if(!Securite::isConnected()){ //si user est pas connecté ?>
                    <a class="nav-link disabled" aria-disabled="true">Profil</a>
                    <?php } else { //si il est connecté ?>
                    <a class="nav-link" href="index.php?action=afficher-profil">Mon profil</a> 
                    <?php }?>
                </li>
                <?php if(Securite::verifAccessPartenaire()|| Securite::verifAccessAdmin()){ //is user est un partenaire ou admin?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=admin-formations-part">Administrer mes formations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=creer-formation">Créer formation</a>
                    </li>
                <?php } ?>
                <?php if(Securite::verifAccessAdmin()){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=administrer-all-formations">Aministration formations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=administrer-utilisateur">Administration</a>
                    </li>
                <?php } ?> 
                
            </ul>
        </div>
        <div class="col-1 text-right">
            <ul class="nav nav-underline">
                <?php if(Securite::isConnected()){ // Ajout possibilité de se logger ?>
                <li class="nav-item"> 
                    <a class="nav-link" href="index.php?action=logout">Se déconnecter</a>
                <?php } else { ?>
                    <a class="nav-link" href="index.php?action=login">Login / Register</a>
                </li>
            </ul>    
                <?php } ?>    
        </div>
    </div>
</div>

<div class="container">
        <h2><?php echo $titre ?></h2>
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-success">
             <?= htmlspecialchars($_SESSION['alert']); ?>
            </div>
         <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>
        <?php echo $content ?>
    </div>
   
    <div class="container">

    <footer>
        <h6>© par Elias ZAINA - Tous droits réservés</h6>
        <p class="text-center">
            <a href="index.php?action=mentions-legales">Mentions légales</a>
            <a href="index.php?action=cookies">Cookies</a>
            <a href="index.php?action=donnees-personnelles">Données personnelles</a>
        </p>
    </footer>
    </div>