<?php
ob_start();
?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); // Supprime le message après l'affichage ?>
<?php endif; ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width:750px;">
        <h3 class="text-center mb-4">Connexion</h3>

        <?php if ($alert !== "") { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $alert ?>
            </div>
        <?php } ?>

        <form action="index.php?action=login-validation" method="post">
            <div class="mb-3">
                <label for="username" class="form-label"><i class="fas fa-user"></i> Nom utilisateur</label>
                <input type="text" class="form-control" id="username" name="login" required>
            </div>
            <div class="mb-3">
                <label for="passwd" class="form-label"><i class="fas fa-lock"></i> Mot de passe</label>
                <input type="password" class="form-control" id="passwd" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>

        <hr>

        <p class="text-center">
            Pas encore de compte ? <a href="index.php?action=register" class="text-decoration-none">Créez-en un ici</a>.
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
$titre = "Login";
require "template.view.php";
?>
