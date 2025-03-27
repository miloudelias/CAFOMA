<?php
ob_start();
?>

<?php if (isset($_SESSION['success_message'])) { ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
<?php } ?>

<nav class="navbar bg-body-tertiary">
  <form class="container-fluid justify-content-start">
      <a href="index.php?action=creer-formation" button class="btn btn-outline-success me-2" type="button">Créer formation</button></a>
      <a href="index.php?action=gerer-partenaire" button class="btn btn-sm btn-outline-secondary" type="button">Gérer partenaire</button></a>
  </form>
</nav>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Image</th>
            <th scope="col">Nom</th>
            <th scope="col">Description</th>
            <th scope="col">Type</th>
            <th scope="col">Durée</th>
            <th scope="col">Niveau</th>
            <th scope="col">Partenaire</th>
            <th scope="col" colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tabFormations as $formation) { ?>
            <tr class="align-middle">
                <td scope="row"><?php echo $formation->getId(); ?></td>
                <td>
                    <img width="80" src="public/images/<?php echo $formation->getImage(); ?>" alt="Image de la formation">
                </td>
                <td><?php echo $formation->getNom(); ?></td>
                <td><?php echo $formation->getDescription(); ?></td>
                <td><?php echo $formation->getType(); ?></td>
                <td><?php echo $formation->getDuree(); ?> heures</td>
                <td><?php echo $formation->getNiveau(); ?></td>
                <td><?php echo htmlspecialchars($formation->getPartenaire()->getNom()); ?></td>
                <td><a href="index.php?action=afficher-formation&id=<?= $formation->getId(); ?>" class="btn btn-info">Afficher formation</a></td>
                <td><a href="index.php?action=modifier-formation&id=<?= $formation->getId(); ?>" class="btn btn-warning">Modifier</a></td>
                <td><a href="index.php?action=supprimer-formation&id=<?= $formation->getId(); ?>" class="btn btn-danger">Supprimer</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>



<?php
$content = ob_get_clean();
$titre = "Administrer les formations";
require "template.view.php";
?>

