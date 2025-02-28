<?php ob_start(); ?>
<?php require_once "outil/Securite.class.php"; ?>

<div class="container mt-4">
    <div class="card shadow-lg p-4 text-center">
        <h1 class="text-primary">Profil de <?= $user->getNom(); ?> <?= $user->getPrenom(); ?></h1>
        <hr class="my-4">
        
        <h4 class="text-secondary">Rôle : <span class="badge bg-info"><?= $user->getRole(); ?></span></h4>
        
        <div class="d-flex flex-column align-items-center mt-4">
            <div class="profile-image mb-3">
                <img class="rounded-circle border border-primary" width="120px" src="<?= $user->getImage(); ?>" alt="Photo de profil">
            </div>
            <form method="POST" action="index.php?action=modifier-image" enctype="multipart/form-data" class="mt-2">
                <label for="image" class="form-label fw-bold">Changer l'image de profil :</label><br>
                <input type="file" class="form-control-file" id="image" name="image" onchange="submit();" />
            </form>
        </div>

        <div class="mt-4">
            <h4 class="text-secondary">Votre email :</h4>
            <p class="text-dark fw-bold text-center"><?= $user->getMail(); ?></p>
        </div>

        <?php if(Securite::verifAccessEtudiant()) { ?>
            <div class="mt-3">
                <a href="index.php?action=supprimer-user" class="btn btn-danger">
                    Supprimer votre compte
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php
    $content = ob_get_clean();
    $titre = "Profil";
    require "template.view.php";
?>
