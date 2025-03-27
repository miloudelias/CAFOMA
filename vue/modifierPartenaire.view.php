<?php
ob_start();
?>

<form method="POST" action="index.php?action=modifier-partenaire-validation" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
    <h2 class="text-center mb-4">Modifier <?=$partenaire->getNom(); ?></h2>

    <div class="mb-3">
        <label class="form-label" for="nom">Nom du partenaire :</label>
        <input class="form-control" type="text" id="nom" name="nom" value="<?= $partenaire->getNom(); ?>" required>
    </div>
    
     <div class="mb-3">
        <label class="form-label" for="description">Description :</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= $partenaire->getDescription(); ?></textarea>
    </div>
    
    <input type="hidden" name="idPartenaire" value="<?= $partenaire->getIdPartenaire(); ?>">
    <div class="text-center">
        <input class="btn btn-success px-4" type="submit" name="form_modifier" value="Modifier le partenaire"/>
    </div>
</form>



<?php
$content = ob_get_clean();
$titre = "Administration";
require "template.view.php";
?>