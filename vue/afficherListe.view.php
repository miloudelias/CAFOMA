<?php
require_once "outil/Outils.class.php";
ob_start();
?>

<?php if (isset($_SESSION['success_message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
<?php } ?>

<?php if($alert !== ""){ ?>
    <div class="alert alert-danger" role="alert">
        <?= $alert ?>
    </div> 
<?php } else { ?>
<div class="container">
   <?php foreach($formations as $formation) { ?>
    <div class="col-12 mb-4">
        <div class="card text-center" style="width: 64rem; margin: auto;">
            <div class="card-header">
                <?php echo $formation->getType() ?>
            </div>
            <img height="350px" src="public/images/<?php echo $formation->getImage(); ?>" class="card-image" alt="image">
            <div class="card-body">
                <h5 class="card-title"><?php echo Outils::sousChaineTaille($formation->getNom(), 20); ?></h5>
                <p class="card-text"<?php echo Outils::sousChaineTaille($formation->getDescription(), 50); ?></p>
                <p<a href="index.php?action=afficher-partenaire&idPart=<?php echo $formation->getPartenaire()->getIdPart(); ?>"><?= $formation->getPartenaire()->getNom(); ?></a></p>
                <?php //if(Securite::isConnected()){ ?>
                    <a href="index.php?action=afficher-formation&id=<?php echo $formation->getId(); ?>" class="btn btn-primary">Détail</a>
                    <a href="index.php?action=ajouter-mes-formations&id=<?php echo $formation->getid(); ?>" class="btn btn-success">S'inscrire</a>
                <?php //} ?>
            </div>
    </div>
</div>
   <?php } ?>
<?php } ?>
<?php
$content = ob_get_clean();
$titre = "Liste des Formations";
require "template.view.php";
?> 


