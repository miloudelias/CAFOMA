<?php ob_start(); ?>


<?php if (!empty($alert)) { ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($alert); ?>
    </div>              
<?php } else { ?>
   <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 1450px;">
        <h3 class="text-center mb-4">Liste de mes inscriptions</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Inscription</th>
                    <th scope="col">Nom de la Formation</th>
                    <th scope="col">Date d'Inscription</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptionList as $inscription) { ?>
                
                    <tr class="align-middle">
                        <td scope="row"><?php echo htmlspecialchars($inscription->getIdInscription()); ?></td>
                        <td><?php echo htmlspecialchars($inscription->getFormation()->getNom()); ?></td>
                        <td><?php echo htmlspecialchars($inscription->getDateInscription()); ?></td> 
                        <td>
                            <a href="index.php?action=afficher-formation&id=<?= $inscription->getIdFormation(); ?>" class="btn btn-info">Voir</a>
                            <a href="index.php?action=annuler-inscription&id=<?= $inscription->getIdInscription(); ?>" class="btn btn-danger">Annuler</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table> 
    </div>
   </div>    
<?php } ?>

<?php
$content = ob_get_clean();
$titre = "Mes formations";
require "template.view.php";
?>
