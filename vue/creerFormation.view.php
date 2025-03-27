<?php
ob_start();
?>

<form method="POST" action="index.php?action=creer-formation-validation" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
    <h2 class="text-center mb-4">Créer une nouvelle formation</h2>
    
    <p>Veuillez pensez à sélectionner votre Etablissement auquel vous êtes affilié. </p>

    <div class="mb-3">
        <label class="form-label" for="nom">Nom de la formation :</label>
        <input class="form-control" type="text" id="nom" name="nom" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="type">Type de formation :</label>
        <select class="form-control" id="type" name="type" required>
            <option value="MOOC">MOOC (Massive Online Open Course)</option>
            <option value="SPOC">SPOC (Small Private Open Course)</option>
            <option value="FOAD">FOAD (Formation Ouverte A Distance)</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label" for="description">Description :</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label" for="contenu">Contenu de la formation :</label>
        <textarea class="form-control" id="contenu" name="contenu" rows="8" required></textarea>
    </div>
      
    <div class="mb-3">
        <label class="form-label" for="duree">Durée (en heures) :</label>
        <input class="form-control" type="number" id="duree" name="duree" min="1" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label" for="niveau">Niveau :</label>
        <input class="form-control" type="text" id="niveau" name="niveau" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label" for="mode">Mode de formation :</label>
        <select class="form-control" id="mode" name="mode" required>
            <option value="Formation initiale">Formation initiale</option>
            <option value="Formation en apprentissage">Formation en apprentissage</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="image">Image de présentation :</label>
        <input class="form-control" type="file" id="image" name="image" accept="image/*">
    </div>

    <div class="mb-3">
        <label class="form-label" for="fichiers">Ressources (PDF, ZIP, MP4) :</label>
        <input class="form-control" type="file" id="ressources" name="ressources[]" multiple accept=".pdf,.doc,.docx,.zip,.mp4" multiple>
    </div>

    <div class="mb-3">
        <label class="form-label" for="partenaire_id">Partenaire :</label>
        <select class="form-control" id="partenaire_id" name="idPart" required>
            <?php foreach($partenaireList as $partenaire) { ?>
                <option value="<?= $partenaire->getIdPartenaire(); ?>">
                    <?= $partenaire->getNom(); ?>
                </option>
            <?php } ?>                    
        </select>
    </div>
    
    <div class="text-center">
        <button class="btn btn-success px-4" type="submit" name="form_ajouter">Créer la formation</button>
    </div>
</form>



<?php
$content = ob_get_clean();
$titre = "Ajout d'une formation";
require "template.view.php";
?>