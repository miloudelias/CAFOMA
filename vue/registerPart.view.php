<?php
ob_start();
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 950px;">
        <h3 class="text-center mb-4">Créer un compte partenaire</h3>

        <?php if(isset($alert) && $alert !== ""): ?>
            <div class="alert alert-danger" role="alert">
            <?= $alert ?>
            </div>              
        <?php endif; ?>

        <form action="index.php?action=creer-user-partenaire-valid" method="post">
            <div class="mb-3">
                <label for="login" class="form-label"><i class="fas fa-user"></i>Nom d'utilisateur</label>
                <input type="text" class="form-control" id="login" name="login" required>
            </div>
            
            <div class="mb-3">
                <label for="mail" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="mail" name="mail" required>
            </div>
            
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock"></i>Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="idPart">Partenaire :</label>
                <select class="form-control" id="idPart" name="idPart" required>
                    <?php foreach($partenaireList as $partenaire) { ?>
                        <option value="<?= $partenaire->getIdPartenaire(); ?>">
                        <?= $partenaire->getNom(); ?>
                        </option>
                    <?php } ?>                    
                </select>
            </div>
            
            <button type="submit" class="btn btn-success">S'inscrire</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$titre = "Inscription Partenaire";
require "template.view.php";
?>