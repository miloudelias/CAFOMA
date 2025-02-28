<?php
$dest = "eliaszaina13@gmail.com";
$sujet = "Email de test";
$corp = "Salut, voici un email de test afin de tester l'envoi par un script PHP";
$headers = "From: cafoma13z@gmail.com";

if (mail($dest, $sujet, $corp, $headers)) {
    echo "Email envoyé avec succès à $dest ...";
} else {
    echo "Echec de l'envoi de l'email";
}

?>