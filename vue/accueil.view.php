<?php ob_start()?>
<p>Test</p>
<?php
    $content=ob_get_clean();
    $titre= "Page d'Accueil";
    require "vue/template.view.php";
?>    
    


