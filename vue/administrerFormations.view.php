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
    <button class="btn btn-sm btn-outline-secondary" type="button">Smaller button</button>
  </form>
</nav>


<?php
$content = ob_get_clean();
$titre = "Ajout d'une formation";
require "template.view.php";
?>

