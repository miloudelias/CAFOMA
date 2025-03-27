<?php
ob_start(); 
?>

    
<form method="POST" action="index.php?page=formations&action=modifier-formation-validation" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
    <h2><?=$formation->getNom(); ?></h2>
    
        <div class="mb-3">
            <label class="form-label" for="nom">Nom de la formation :</label>
            <input class="form-control" type="text" id="nom" name="nom" value="<?= $formation->getNom(); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="type">Type de formation :</label>
            <select class="form-control" id="type" name="type" required>
                <option value="MOOC" <?= $formation->getType() == "MOOC" ? "selected" : ""; ?>>MOOC (Massive Online Open Course)</option>
                <option value="SPOC" <?= $formation->getType() == "SPOC" ? "selected" : ""; ?>>SPOC (Small Private Open Course)</option>
                <option value="FOAD" <?= $formation->getType() == "FOAD" ? "selected" : ""; ?>>FOAD (Formation Ouverte A Distance)</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="description">Description :</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?= $formation->getDescription(); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label" for="contenu">Contenu de la formation :</label>
            <textarea class="form-control" id="contenu" name="contenu" rows="8" required><?= $formation->getContenu(); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label" for="duree">Durée (en heures) :</label>
            <input class="form-control" type="number" id="duree" name="duree" min="1" value="<?= $formation->getDuree(); ?>" required>
        </div>
    
        <div class="mb-3">
            <label class="form-label" for="niveau">Niveau :</label>
            <input class="form-control" type="text" id="niveau" name="niveau" value="<?= $formation->getNiveau(); ?>" required>
        </div>
    
        <div class="mb-3">
            <label class="form-label" for="mode">Mode de formation :</label>
            <select class="form-control" id="mode" name="mode" required>
                <option value="Formation initiale" <?= $formation->getMode() == "Formation initiale" ? "selected" : ""; ?>>Formation initiale</option>
                <option value="Formation en apprentissage" <?= $formation->getMode() == "Formation en apprentissage" ? "selected" : ""; ?>>Formation en apprentissage</option>
            </select>
        </div>
        
        <!-- Image actuelle -->
        <div class="mb-3">
            <label class="form-label">Image actuelle :</label><br>
                <img src="public/images/<?= $formation->getImage(); ?>" width="200px" class="mb-2"><br>
            <label class="form-label" for="image">Changer l'image :</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
            <input type="hidden" name="image" value="<?= $formation->getImage(); ?>">
        </div>
        
        <!-- Fichiers actuels -->
        <div class="mb-3">
            <label class="form-label">Fichiers actuels :</label><br>
            <?php
            $fichiers = $formation->getFichiers();
            if (!is_array($fichiers)) {
                $fichiers = json_decode($fichiers, true) ?? [];
            }

            if (!empty($fichiers)) {
                foreach ($fichiers as $fichier) {
                    echo "<a href='public/fichiers/$fichier' target='_blank'>$fichier</a><br>";
                }
            } else {
                echo "Aucun fichier joint.";
            }
            ?>
            <br>
            <label class="form-label" for="fichiers">Remplacer les fichiers :</label>
            <input class="form-control" type="file" id="fichiers" name="fichiers[]" multiple accept=".pdf,.doc,.docx,.zip,.mp4">
            <input type="hidden" name="fichiers" value='<?= $formation->getFichiers(); ?>'>
        </div>
        
        
        <input type="hidden" name="id" value="<?= $formation->getId(); ?>">
    <div class="text-center">    
      <input class="btn btn-primary px-4" type="submit" value="Modifier la formation" name="form_modifier"/>
    </div>  
</form>

<?php
$content = ob_get_clean();
$titre = "Modifier la Formation";
require "template.view.php";
?>