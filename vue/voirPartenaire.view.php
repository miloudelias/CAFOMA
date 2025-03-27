<?php ob_start(); ?>

<div class="container mt-4">
    <div class="card shadow-lg p-4">
        
        <div class="text-center">
            <h4 class="text-secondary">Description :</h4> 
            <p class="text-dark"><?= $partenaire->getDescription(); ?></p>
        </div>
        
        <?php if(isset($formationList) && !empty($formationList)) { ?>
    <div class="container mt-4">
        <h3 class="text-center text-success">Formations proposées par <?= $partenaire->getNom(); ?></h3> 
        <table class="table table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Type</th>
                    <th scope="col">Durée</th>
                    <th scope="col">Niveau</th>
                    <th scope="col">Mode</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($formationList as $formation) { ?>
                    <tr class="align-middle">
                        <td><img width="80" class="rounded" src="public/images/<?= $formation->getImage(); ?>" alt="Image de la formation"></td>
                        <td><?= $formation->getNom(); ?></td>
                        <td><?= $formation->getType(); ?></td>
                        <td><?= $formation->getDuree(); ?> heures</td>
                        <td><?= $formation->getNiveau(); ?></td>
                        <td><?= $formation->getMode(); ?></td>
                        <td>
                            <a href="index.php?action=detail-formation&id=<?= $formation->getId(); ?>" class="btn btn-info">Détails</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table> 
    </div>
<?php } else { ?>
    <p class="text-center text-muted mt-4">Aucune formation disponible pour ce partenaire.</p>
<?php } ?>
        
    </div>
</div>



<?php
$content = ob_get_clean();
$titre = "Partenaire - " . $partenaire->getNom();
require "template.view.php";
?>
