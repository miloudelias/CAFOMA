<?php ob_start(); ?>

<h2 class="text-center my-4">Gestion des Partenaires</h2>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $partenaire): ?>
            <tr class="align-middle">
                <td><?= htmlspecialchars($partenaire->getIdPartenaire()); ?></td>
                <td><?= htmlspecialchars($partenaire->getNom()); ?></td>
                <td><?= htmlspecialchars($partenaire->getDescription()); ?></td>
                <td>
                    <a href="index.php?action=afficher-partenaire&idPartenaire=<?= urlencode($partenaire->getIdPartenaire()); ?>" 
                       class="btn btn-info">
                       Voir
                    </a>
                    
                    <a href="index.php?action=modifier-partenaire&idPartenaire=<?= urlencode($partenaire->getIdPartenaire()); ?>" 
                       class="btn btn-warning">
                       Modifier
                    </a>
                    
                    <a href="index.php?action=supprimer-partenaire&idPartenaire=<?= urlencode($partenaire->getIdPartenaire()); ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?');">
                       Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="text-center">
    <a href="index.php?action=creer-partenaire" class="btn btn-primary">Ajouter un Partenaire</a>
</div>

<?php
$content = ob_get_clean();
$titre = "Administration";
require "template.view.php";
?>
