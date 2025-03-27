<?php
ob_start();
?>

<form method="POST" action="index.php?action=creer-partenaire-validation" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
    <h2 class="text-center mb-4">Créer un nouveau partenaire</h2>

    <div class="mb-3">
        <label class="form-label" for="nom">Nom de la formation :</label>
        <input class="form-control" type="text" id="nom" name="nom" required>
    </div>
    
     <div class="mb-3">
        <label class="form-label" for="description">Description :</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    
    
    <div class="text-center">
        <button class="btn btn-success px-4" type="submit" name="form_ajouter">Créer le partenaire</button>
    </div>
</form>



<?php
$content = ob_get_clean();
$titre = "Administration";
require "template.view.php";
?>