<?php

/**
 * Description of Securite
 *
 * @author elias
 */

class Securite {
    public static function verifAccessAdmin(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "administrateur");
    }
    public static function verifAccessPartenaire(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "partenaire");
    }
    public static function verifAccessEtudiant(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "etudiant");
    }
    public static function isConnected(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']));
    }
}
