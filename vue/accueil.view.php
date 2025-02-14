<?php ob_start()?>
<p>Test</p>
<?php
    $content=ob_get_clean();
    $titre= "Accueil";
    require "vue/template.view.php";
?>    
    


