<?php ob_start(); ?>

<div class="container">
    <nav class="navbar bg-body-tertiary">
  <form class="container-fluid justify-content-start">
      <a href="index.php?action=gerer-partenaire" button class="btn btn-outline-success me-2" type="button">Gérer les partenaires</button></a>
      <a href="index.php?action=creer-partenaire" button class="btn btn-sm btn-outline-secondary" type="button">Créer un partenaire</button></a>
  </form>
</nav>
    <h2 class="text-center my-4">Gestion des Utilisateurs</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nom utilisateur</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">Mail</th>
                <th scope="col">Rôle</th>
                <th scope="col">Valide</th>
                <th scope="col">Mot de passe hashé</th>
                <th scope="col">Partenaire</th> 
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr class="align-middle">
                    <td><?= $user->getLogin(); ?></td>
                    <td><?= $user->getNom(); ?></td>
                    <td><?= $user->getPrenom(); ?></td>
                    <td><?= $user->getMail(); ?></td>
                    <td><?= $user->getRole(); ?></td>
                    <td><?= $user->getEstValide() ? "Oui" : "Non"; ?></td>
                    <td><?= $user->getPassword(); ?></td>
                    <td><?= $user->getIdPart(); ?> </td>
                    <td>
                            <a href="index.php?action=modifier-user&user=<?= urlencode($user->getLogin()); ?>" 
                                class="btn btn-warning">
                                Modifier
                            </a>
                            <a href="index.php?action=supprimer-user&user=<?= urlencode($user->getLogin()); ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                               Supprimer
                            </a>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="index.php?action=creer-user-partenaire" class="btn btn-primary">Ajouter un utilisateur Partenaire</a>
    </div>
</div>

<?php
    $content = ob_get_clean();
    $titre = "Administration";
    require "template.view.php";
?>
