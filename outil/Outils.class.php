<?php

class Outils {
    
    public static function sendMail($destinataire, $sujet, $message){
        if(mail($destinataire,$sujet,$message)){
            echo("Mail envoyé");
        } else {
            echo("Mail non envoyé");
        }
    }
    
    public static function afficherTableau($tab,$titre){
        echo "<hr>";
        echo "<p>Tableau ".$titre."</p>";
        echo "<pre>";
        print_r($tab);
        echo "</pre>";
        echo "<hr>";
    }

    public static function afficherChaine($chaine, $titre){
        echo "<p>".$titre."</p>";
        echo "Chaine = ". $chaine . "<br>";
        echo "<hr>";
    }

    public static function ajouterImage($file, $dir){
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];
        move_uploaded_file($file['tmp_name'], $target_file);
        return $random."_".$file['name'];
    }
    
    public static function ajouterFichiers($fichier, $dir){
        $nomFichiersAjoutes = [];
        foreach ($fichier['name'] as $key =>$name) {
            $random = rand(0, 99999);
            $target_file = $dir . $random . "_" . ($name);
            if (move_uploaded_file($fichier['tmp_name'][$key], $target_file)) {
                $nomFichiersAjoutes[] = $random . "_" . basename($name);
            } else {
            throw new Exception("Échec de l'upload du fichier: " . $name);
            }
        }
        return $nomFichiersAjoutes;
    }

    public static function sousChaineTaille($chaine,$taille){
        if(strlen($chaine) >= $taille)
            $sousChaine = substr($chaine, 0, $taille)."...";
        else {
            $bouchon = str_repeat(" ", $taille-strlen($chaine));
            $sousChaine = $chaine;
        }
        return $sousChaine;
    }
}
?>
