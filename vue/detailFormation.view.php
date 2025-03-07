<?php
ob_start();
?>
<br>

<div class="row">
    <div class="col-4">
        <img height="200px" src="public/images/<?php echo $formation->getImage(); ?>" alt="Image de la formation">
    </div>
    
    <div class="col-6">
        <br>
        <h3>Type de formation : <?php echo $formation->getType(); ?></h3>
        <br>
        <h3>Durée : <?php echo $formation->getDuree(); ?> heures</h3>
        <br>
        <h3>Niveau : <?php echo $formation->getNiveau(); ?></h3>
        <br>
        <h3>Mode : <?php echo $formation->getMode(); ?></h3>
        <br>
        
        
        <h3>Partenaire :
            <a href="index.php?action=afficher-partenaire&idPart=<?php echo $formation->getPartenaire()->getIdPartenaire(); ?>"><?= $formation->getPartenaire()->getNom(); ?></a>
        </h3>
        <br>
        
        <h3>Description : <?php echo $formation->getDescription(); ?></h3>
        <br>
    </div>
    
</div>


<?php
$content = ob_get_clean();
$titre = $formation->getNom();
require "template.view.php";
?>